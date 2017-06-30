<?php

namespace DPN\SwConnect\Controller;

use DPN\SwConnect\Service\Decorator\CachedProductService;
use DPN\SwConnect\Service\ProductService;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

class ProductController extends ActionController
{
    /**
     * @var ProductService
     */
    protected $productService;

    /**
     * @param CachedProductService $productService
     */
    public function __construct(CachedProductService $productService)
    {
        parent::__construct();

        $this->productService = $productService;
    }

    /**
     */
    public function categoryAction()
    {
        $this->view->assign('products', $this->productService->findByCategories(
            $this->settings,
            explode(',', $this->settings['categories'])
        ));
    }
}
