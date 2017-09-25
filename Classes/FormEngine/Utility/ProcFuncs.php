<?php

namespace DPN\SwConnect\FormEngine\Utility;

use DPN\SwConnect\Domain\Model\Article;
use DPN\SwConnect\Service\Decorator\CachedCategoryService;
use DPN\SwConnect\Service\Decorator\CachedProductService;
use DPN\SwConnect\Service\ShopService;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Object\ObjectManager;

class ProcFuncs
{
    /**
     * @param array $fConfig
     * @param \TYPO3\CMS\Backend\Form\ $fObj
     */
    public static function getCategories(&$fConfig, $fObj)
    {
        $objectManager = GeneralUtility::makeInstance(ObjectManager::class);
        $categoryService = $objectManager->get(CachedCategoryService::class);

        $allCategories = $categoryService->findAll();

        foreach ($allCategories as $category) {
            $fConfig['items'][] = [0 => $category['name'], 1 => $category['id']];
        }
    }

    /**
     * @param array $fConfig
     * @param \TYPO3\CMS\Backend\Form\ $fObj
     */
    public static function getProducts(&$fConfig, $fObj)
    {
        $objectManager = GeneralUtility::makeInstance(ObjectManager::class);
        $productService = $objectManager->get(CachedProductService::class);

        $allProducts = $productService->findAll();

        $products = [];
        foreach ($allProducts as $product) {
            $products[] = $productService->findOne($product->getId());
        }

        foreach ($products as $product) {
            /** @var Article $product */
            $fConfig['items'][] = [0 => $product->getMainDetail()->getNumber().' - '.$product->getName(), 1 => $product->getId()];
        }

        usort($fConfig['items'], function($a, $b) {
            return strcmp($a[0], $b[0]);
        });
    }

    /**
     * @param array $fConfig
     * @param \TYPO3\CMS\Backend\Form\ $fObj
     */
    public static function getShops(&$fConfig, $fObj)
    {
        $objectManager = GeneralUtility::makeInstance(ObjectManager::class);
        $shopService = $objectManager->get(ShopService::class);

        $allShops = $shopService->findAll();

        foreach ($allShops as $shop) {
            $isDefault = (bool) $shop->isDefault();
            $fConfig['items'][] = [
                0 => sprintf('[%s] %s (%s) %s', $shop->getId(), $shop->getName(), $shop->getCurrency()->getName(), $isDefault ? 'Standard Shop' : ''),
                1 => $shop->getId(),
            ];
        }
    }
}
