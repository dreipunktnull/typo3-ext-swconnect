<?php
defined('TYPO3_MODE') or die();

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    'sw_connect',
    'Products',
    'Products'
);

$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist']['swconnect_products'] = 'recursive,select_key,pages';
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist']['swconnect_products'] = 'pi_flexform';

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue(
    'swconnect_products',
    'FILE:EXT:sw_connect/Configuration/FlexForms/flexform_products.xml'
);

// TypoScript
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile('sw_connect', 'Configuration/TypoScript', 'Shopware Connector');
