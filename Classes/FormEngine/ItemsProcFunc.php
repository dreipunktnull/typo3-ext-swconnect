<?php

namespace DPN\SwConnect\FormEngine;

use DPN\SwConnect\FormEngine\Utility\TemplateLayout;
use TYPO3\CMS\Backend\Utility\BackendUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class ItemsProcFunc
{
    /**
     * Reads the available template layouts from TSconfig to make them
     * available in the flexform.
     *
     * @param array $config
     */
    public function user_templateLayout(array &$config)
    {
        $pageId = $this->getPageId($config['flexParentDatabaseRow']['pid']);
        if ($pageId > 0) {
            $templateLayoutsUtility = GeneralUtility::makeInstance(TemplateLayout::class);
            $templateLayouts = $templateLayoutsUtility->getAvailableTemplateLayouts($pageId);

            foreach ($templateLayouts as $layout) {
                $additionalLayout = [
                    htmlspecialchars($this->getLanguageService()->sL($layout[0])),
                    $layout[1],
                ];
                array_push($config['items'], $additionalLayout);
            }
        }
    }

    /**
     * @return mixed|\TYPO3\CMS\Lang\LanguageService
     */
    private function getLanguageService()
    {
        return $GLOBALS['LANG'];
    }

    /**
     * Get page id, if negative, then it is a "after record"
     *
     * @param int $pid
     * @return int
     */
    protected function getPageId($pid)
    {
        $pid = (int)$pid;
        if ($pid > 0) {
            return $pid;
        }

        $row = BackendUtility::getRecord('tt_content', abs($pid), 'uid,pid');

        return $row['pid'];
    }
}
