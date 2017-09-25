<?php

namespace DPN\SwConnect\FormEngine;

use DPN\SwConnect\Domain\Model\Category;
use DPN\SwConnect\Service\CategoryService;
use DPN\SwConnect\Service\Decorator\CachedCategoryService;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Imaging\Icon;
use TYPO3\CMS\Core\Imaging\IconFactory;
use TYPO3\CMS\Core\Tree\TableConfiguration\DatabaseTreeDataProvider;
use TYPO3\CMS\Core\Tree\TableConfiguration\DatabaseTreeNode;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Object\ObjectManager;

class ProductCategoryTreeProvider extends DatabaseTreeDataProvider
{
    /**
     * @var \TYPO3\CMS\Core\Authentication\BackendUserAuthentication
     */
    protected $backendUserAuthentication;

    /**
     * @var array
     */
    protected $configuration;

    /**
     * @var CategoryService
     */
    protected $categoryService;

    /**
     * Required constructor
     *
     * @param array $configuration TCA configuration
     */
    public function __construct(array $configuration)
    {
        $this->configuration = $configuration;
        $this->backendUserAuthentication = $GLOBALS['BE_USER'];
    }

    /**
     * Returns the root node
     *
     * @return \TYPO3\CMS\Backend\Tree\TreeNode
     */
    public function getRoot()
    {
        return $this->buildRepresentationForNode($this->treeData);
    }

    /**
     * Fetches the subnodes of the given node
     *
     * @param \TYPO3\CMS\Backend\Tree\TreeNode $node
     * @return \TYPO3\CMS\Backend\Tree\TreeNodeCollection
     */
    public function getNodes(\TYPO3\CMS\Backend\Tree\TreeNode $node)
    {
    }

    /**
     * Init the tree data
     */
    public function initializeTreeData()
    {
        $this->expandedList = $GLOBALS['BE_USER']->uc['tcaTrees'][$this->treeId];

        $this->nodeSortValues = array_flip($this->itemWhiteList);
        $this->columnConfiguration = $GLOBALS['TCA'][$this->getTableName()]['columns'][$this->getLookupField()]['config'];

        $om = GeneralUtility::makeInstance(ObjectManager::class);
        $this->categoryService = $om->get(CachedCategoryService::class);

        if (isset($this->columnConfiguration['foreign_table']) && $this->columnConfiguration['foreign_table'] != $this->getTableName()) {
            throw new \InvalidArgumentException('TCA Tree configuration is invalid: tree for different node-Tables is not implemented yet', 1290944650);
        }

        $this->treeData = GeneralUtility::makeInstance(\TYPO3\CMS\Backend\Tree\TreeNode::class);
        $this->loadTreeData();
        $this->emitPostProcessTreeDataSignal();
    }

    /**
     * Loads the tree data (all possible children)
     */
    protected function loadTreeData()
    {
        $this->treeData->setId($this->getRootUid());
        $this->treeData->setParentNode(null);
        if ($this->levelMaximum >= 1) {
            $childNodes = $this->getChildrenOf($this->treeData, 1);
            if ($childNodes !== null) {
                $this->treeData->setChildNodes($childNodes);
            }
        }
    }

    /**
     * Gets node children
     *
     * @param \TYPO3\CMS\Backend\Tree\TreeNode $node
     * @param int $level
     * @return NULL|\TYPO3\CMS\Backend\Tree\TreeNodeCollection
     */
    protected function getChildrenOf(\TYPO3\CMS\Backend\Tree\TreeNode $node, $level)
    {
        $nodeData = null;
        if ($node->getId() !== 0) {
            $category = $this->categoryService->findById($node->getId());

            $nodeData = $this->transformCategoryForNodeData($category);
        }
        if (empty($nodeData)) {
            $nodeData = [
                'uid' => 0,
                $this->getLookupField() => ''
            ];
        }
        $storage = null;
        $children = $this->getRelatedRecords($nodeData);
        if (!empty($children)) {
            /** @var $storage \TYPO3\CMS\Backend\Tree\TreeNodeCollection */
            $storage = GeneralUtility::makeInstance(\TYPO3\CMS\Backend\Tree\TreeNodeCollection::class);
            foreach ($children as $child) {
                $node = GeneralUtility::makeInstance(\TYPO3\CMS\Backend\Tree\TreeNode::class);
                $node->setId($child);
                if ($level < $this->levelMaximum) {
                    $children = $this->getChildrenOf($node, $level + 1);
                    if ($children !== null) {
                        $node->setChildNodes($children);
                    }
                }
                $storage->append($node);
            }
        }
        return $storage;
    }

    /**
     * Gets related records depending on TCA configuration
     *
     * @param array $row
     * @return array
     */
    protected function getRelatedRecords(array $row)
    {
        if ($this->getLookupMode() == self::MODE_PARENT) {
            $children = $this->getChildrenUidsFromParentRelation($row);
        } else {
            $children = $this->getChildrenUidsFromChildrenRelation($row);
        }
        $allowedArray = [];
        foreach ($children as $child) {
            if (!in_array($child, $this->idCache) && in_array($child, $this->itemWhiteList)) {
                $allowedArray[] = $child;
            }
        }
        $this->idCache = array_merge($this->idCache, $allowedArray);
        return $allowedArray;
    }

    /**
     * Gets related records depending on TCA configuration
     *
     * @param array $row
     * @return array
     */
    protected function getChildrenUidsFromParentRelation(array $row)
    {
        $uid = $row['uid'];
        if ($uid === 0) {
            $uid = 1;
        }
        $relatedUids = [];

        /** @var Category[] $categories */
        $categories = $this->categoryService->findChildrenByParentId($uid);

        foreach ($categories as $category) {
            $relatedUids[] = $category->getId();
        }

        return $relatedUids;
    }

    /**
     * Gets related children records depending on TCA configuration
     *
     * @param array $row
     * @return array
     */
    protected function getChildrenUidsFromChildrenRelation(array $row)
    {
        $relatedUids = [];
        $uid = $row['uid'];
        $value = $row[$this->getLookupField()];
        switch ((string)$this->columnConfiguration['type']) {
            case 'inline':
                // Intentional fall-through
            case 'select':
                if ($this->columnConfiguration['MM']) {
                    $dbGroup = GeneralUtility::makeInstance(\TYPO3\CMS\Core\Database\RelationHandler::class);
                    $dbGroup->start(
                        $value,
                        $this->getTableName(),
                        $this->columnConfiguration['MM'],
                        $uid,
                        $this->getTableName(),
                        $this->columnConfiguration
                    );
                    $relatedUids = $dbGroup->tableArray[$this->getTableName()];
                } elseif ($this->columnConfiguration['foreign_field']) {
                    $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)
                        ->getQueryBuilderForTable($this->getTableName());
                    $queryBuilder->getRestrictions()->removeAll();
                    $records = $queryBuilder->select('uid')
                        ->from($this->getTableName())
                        ->where(
                            $queryBuilder->expr()->eq(
                                $this->columnConfiguration['foreign_field'],
                                $queryBuilder->createNamedParameter($uid, \PDO::PARAM_INT)
                            )
                        )
                        ->execute()
                        ->fetchAll();

                    if (!empty($records)) {
                        $relatedUids = array_column($records, 'uid');
                    }
                } else {
                    $relatedUids = GeneralUtility::intExplode(',', $value, true);
                }
                break;
            default:
                $relatedUids = GeneralUtility::intExplode(',', $value, true);
        }
        return $relatedUids;
    }

    private function transformCategoryForNodeData(Category $category = null)
    {
        if ($category === null) {
            return;
        }

        return [
            'uid' => $category->getId(),
        ];
    }

    /**
     * Builds a complete node including childs
     *
     * @param \TYPO3\CMS\Backend\Tree\TreeNode $basicNode
     * @param NULL|\TYPO3\CMS\Core\Tree\TableConfiguration\DatabaseTreeNode $parent
     * @param int $level
     * @return \TYPO3\CMS\Core\Tree\TableConfiguration\DatabaseTreeNode Node object
     */
    protected function buildRepresentationForNode(\TYPO3\CMS\Backend\Tree\TreeNode $basicNode, DatabaseTreeNode $parent = null, $level = 0)
    {
        /** @var $node \TYPO3\CMS\Core\Tree\TableConfiguration\DatabaseTreeNode */
        $node = GeneralUtility::makeInstance(\TYPO3\CMS\Core\Tree\TableConfiguration\DatabaseTreeNode::class);
        $row = [];
        if ($basicNode->getId() == 0) {
            $node->setSelected(false);
            $node->setExpanded(true);
            $node->setLabel('Shop');
        } else {
            $category = $this->categoryService->findById($basicNode->getId());
            $node->setLabel($category->getName() ?: $basicNode->getId());
            $node->setSelected(GeneralUtility::inList($this->getSelectedList(), $basicNode->getId()));
            $node->setExpanded($this->isExpanded($basicNode));
        }
        $node->setId($basicNode->getId());
        $node->setSelectable(!GeneralUtility::inList($this->getNonSelectableLevelList(), $level) && !in_array($basicNode->getId(), $this->getItemUnselectableList()));
        $node->setSortValue($this->nodeSortValues[$basicNode->getId()]);
        $iconFactory = GeneralUtility::makeInstance(IconFactory::class);
        $node->setIcon($iconFactory->getIcon('swconnect-model-category', Icon::SIZE_SMALL));
        $node->setParentNode($parent);
        if ($basicNode->hasChildNodes()) {
            $node->setHasChildren(true);
            /** @var $childNodes \TYPO3\CMS\Backend\Tree\SortedTreeNodeCollection */
            $childNodes = GeneralUtility::makeInstance(\TYPO3\CMS\Backend\Tree\SortedTreeNodeCollection::class);
            $tempNodes = [];
            foreach ($basicNode->getChildNodes() as $child) {
                $tempNodes[] = $this->buildRepresentationForNode($child, $node, $level + 1);
            }
            $childNodes->exchangeArray($tempNodes);
            $childNodes->asort();
            $node->setChildNodes($childNodes);
        }
        return $node;
    }
}
