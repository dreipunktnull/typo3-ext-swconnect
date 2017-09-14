<?php

namespace DPN\SwConnect\FormEngine\Utility;

use DPN\SwConnect\Service\Decorator\CachedCategoryService;
use DPN\SwConnect\Service\Decorator\CachedProductService;
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

        foreach ($allProducts as $product) {
            $fConfig['items'][] = [0 => $product->getName(), 1 => $product->getId()];
        }
    }
}
