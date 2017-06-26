<?php

namespace DPN\SwConnect\FormEngine\Utility;

use DPN\SwConnect\Service\Decorator\CachedCategoryService;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Object\ObjectManager;

class ProcFuncs
{
    /**
     * @param array $fConfig
     * @param \TYPO3\CMS\Backend\Form\ $fObj
     *
     * @return void
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
}
