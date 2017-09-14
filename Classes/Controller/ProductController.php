<?php

namespace DPN\SwConnect\Controller;

use DPN\SwConnect\Service\Decorator\CachedProductService;
use DPN\SwConnect\Service\ProductService;

class ProductController extends AbstractController
{
    const DISPLAY_MODE_CATEGORY = 'category';

    const DISPLAY_MODE_ITEMLIST = 'item_list';

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
     * Displays a product listing.
     */
    public function listAction()
    {
        if (static::DISPLAY_MODE_CATEGORY === $this->settings['merged']['mode']) {
            $this->view->assign('products', $this->productService->findByCategories(
                $this->settings,
                explode(',', $this->settings['merged']['categories'])
            ));
        }

        if (static::DISPLAY_MODE_ITEMLIST === $this->settings['merged']['mode']) {
            $this->view->assign('products', $this->productService->findByIds(
                $this->settings,
                explode(',', $this->settings['merged']['products'])
            ));
        }

        $this->view->assign('row', $this->configurationManager->getContentObject()->data);
    }
}
