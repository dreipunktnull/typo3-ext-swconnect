<?php

namespace DPN\SwConnect\Hook;

use DPN\SwConnect\FormEngine\Utility\TemplateLayout;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Imaging\IconFactory;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Reflection\ObjectAccess;

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
        $flexFormData = GeneralUtility::xml2array($params['row']['pi_flexform']);
        $settings = ObjectAccess::getPropertyPath($flexFormData, 'data.sDEF.lDEF');

        $products = [];
        if ($settings !== null && array_key_exists('settings.override.products', $settings)) {
            $productIds = explode(',', $settings['settings.override.products']['vDEF']);

            if (\count(array_filter($productIds)) > 0) {
                $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)
                    ->getConnectionForTable('tx_dpnswconnect_article')
                    ->createQueryBuilder();
                $products = $queryBuilder->select('shopware_id', 'name', 'article_number')
                    ->from('tx_dpnswconnect_article')
                    ->where($queryBuilder->expr()->in('shopware_id', $productIds))
                    ->execute()
                    ->fetchAll()
                ;
            }
        }

        $output .= '<div class="table-responsive">';
        $output .= '<table class="table table-striped">';
        $output .= '<tr><th>UID:</th><td>' . $params['row']['uid'] . '</td></tr>';
        $output .= '<tr><th>Selected products:</th><td>';

        if (\count($products) > 0) {
            $output .= '<ul>';
            foreach ($products as $product) {
                $output .= '<li>' . sprintf('%s - %s (%s)', $product['article_number'], $product['name'], $product['shopware_id']) . '</li>';
            }
            $output .= '</ul>';
        }

        $output .= '</td></tr>';

        $output .= '</table>';
        $output .= '</div>';

        return $output;
    }
}
