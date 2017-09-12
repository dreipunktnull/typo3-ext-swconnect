<?php

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig('
    <INCLUDE_TYPOSCRIPT: source="FILE:EXT:sw_connect/Configuration/PageTS/TCEMAIN.typoscript">
');

/**
 * Add default template layouts
 */
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig('
    <INCLUDE_TYPOSCRIPT: source="FILE:EXT:sw_connect/Configuration/PageTS/DefaultTemplateLayouts.tsconfig">
');

/**
 * Prepare config array structure.
 */
if (!array_key_exists('sw_connect', $GLOBALS['TYPO3_CONF_VARS']['EXT'])) {
    $GLOBALS['TYPO3_CONF_VARS']['EXT']['sw_connect'] = [];
}

if (!array_key_exists('templateLayouts', $GLOBALS['TYPO3_CONF_VARS']['EXT']['sw_connect'])) {
    $GLOBALS['TYPO3_CONF_VARS']['EXT']['sw_connect']['templateLayouts'] = [];
}
