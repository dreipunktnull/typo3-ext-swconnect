<?php

namespace DPN\SwConnect\Service\Decorator;

use DPN\SwConnect\Domain\Model\Article;
use DPN\SwConnect\Domain\Model\Category;
use DPN\SwConnect\Service\CategoryService;
use TYPO3\CMS\Core\Cache\CacheManager;
use TYPO3\CMS\Extensionmanager\Utility\ConfigurationUtility;

class CachedCategoryService extends CategoryService
{
    /**
     * @var CacheManager
     */
    protected $cacheManager;

    /**
     * @param ConfigurationUtility $configurationUtility
     * @param CacheManager $cacheManager
     */
    public function __construct(ConfigurationUtility $configurationUtility, CacheManager $cacheManager)
    {
        parent::__construct($configurationUtility);

        $this->cacheManager = $cacheManager;
    }

    /**
     * @return Article[]
     */
    public function findAll()
    {
        $cache = $this->cacheManager->getCache('sw_connect_categories');
        if (!$cache->has('all')) {
            $allCategories = parent::findAll();

            $cache->set('all', $allCategories, [], 3600);

            return $allCategories;
        }

        return $cache->get('all');
    }

    /**
     * @param int $id
     * @return Category
     */
    public function findById(int $id)
    {
        $entryIdentifier = sprintf('category-%s', $id);
        $cache = $this->cacheManager->getCache('sw_connect_categories');
        if (!$cache->has($entryIdentifier)) {
            $category = parent::findById($id);

            if ($category !== null) {
                $cache->set($entryIdentifier, $category, [], 3600);
            }

            return $category;
        }

        return $cache->get($entryIdentifier);
    }

    /**
     * @param int $id
     *
     * @return Category[]
     */
    public function findChildrenByParentId(int $id)
    {
        $entryIdentifier = sprintf('categories-by-parent-%s', $id);
        $cache = $this->cacheManager->getCache('sw_connect_categories');
        if (!$cache->has($entryIdentifier)) {
            $children = parent::findChildrenByParentId($id);

            if ($children !== null) {
                $cache->set($entryIdentifier, $children, [], 3600);
            }

            return $children;
        }

        return $cache->get($entryIdentifier);
    }
}
