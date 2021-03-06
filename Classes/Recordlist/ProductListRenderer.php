<?php

namespace DPN\SwConnect\Recordlist;

use DPN\SwConnect\Service\Decorator\CachedProductService;
use Shopware\Models\Article\Article;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Fluid\View\StandaloneView;

class ProductListRenderer
{
    /**
     * @var StandaloneView
     */
    protected $view;

    public function __construct()
    {
        $this->view = GeneralUtility::makeInstance(StandaloneView::class);

        $this->view->setTemplateRootPaths(['EXT:sw_connect/Resources/Private/Templates/RecordList/ProductList/']);
        $this->view->setLayoutRootPaths(['EXT:sw_connect/Resources/Private/Layouts/RecordList/ProductList/']);
        $this->view->setPartialRootPaths(['EXT:sw_connect/Resources/Private/Partials/RecordList/ProductList/']);
    }

    /**
     * @return string
     */
    public function render()
    {
        $products = $this->gatherProducts();
        $this->view->assign('products', $products);

        return $this->view->render('List');
    }

    private function gatherProducts()
    {
        $objectManager = GeneralUtility::makeInstance(ObjectManager::class);
        $productService = $objectManager->get(CachedProductService::class);

        $articles = $productService->findAll();

        uasort($articles, function ($a, $b) {
            /** @var $a Article */
            /** @var $b Article */
            return strcmp($a->getName(), $b->getName());
        });

        $fullArticles = [];

        foreach ($articles as $article) {
            $fullArticles[] = $productService->findOne($article->getId());
        }

        return $fullArticles;
    }
}
