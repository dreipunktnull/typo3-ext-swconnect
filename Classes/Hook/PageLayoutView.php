<?php

namespace DPN\SwConnect\Hook;

use DPN\SwConnect\FormEngine\Utility\TemplateLayout;
use TYPO3\CMS\Core\Imaging\IconFactory;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Renders the preview for an item.
 */
class PageLayoutView
{
    /**
     * @var TemplateLayout
     */
    private $templateLayout;

    /**
     * @var IconFactory
     */
    private $iconFactory;

    public function __construct()
    {
        $this->templateLayout = GeneralUtility::makeInstance(TemplateLayout::class);
        $this->iconFactory = GeneralUtility::makeInstance(IconFactory::class);
    }

    /**
     * @param array $params
     * @return string
     */
    public function printSettings(array $params) : string
    {
        $output = '';
        $flexformData = GeneralUtility::xml2array($params['row']['pi_flexform']);

        $output .= '<div class="table-responsive">';
        $output .= '<table class="table table-striped">';
        $output .= '<tr><th>UID:</th><td>'.$params['row']['uid'].'</td></tr>';
        $output .= '</table>';
        $output .= '</div>';

        return $output;
    }
}
