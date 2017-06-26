<?php

defined('TYPO3_MODE') or die();

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'DPN.sw_connect',
    'Products',
    [
        'Product' => 'category',
    ],
    [
        'Product' => 'category',
    ]
);

if (!is_array($GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['sw_connect_products'])) {
    $GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['sw_connect_products'] = [];
}

if (!is_array($GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['sw_connect_categories'])) {
    $GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['sw_connect_categories'] = [];
}

if (!is_array($GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['sw_connect_images_1st'])) {
    $GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['sw_connect_images_1st'] = [
        'backend' => \TYPO3\CMS\Core\Cache\Backend\TransientMemoryBackend::class
    ];
}

//$GLOBALS['TYPO3_CONF_VARS']['SYS'][]

/**
 * Register a global fluid namespace
 */
$GLOBALS['TYPO3_CONF_VARS']['SYS']['fluid']['namespaces']['swc'][] = 'DPN\\SwConnect\\ViewHelpers';

/**
 * Shopware media rendering
 */
$GLOBALS['TYPO3_CONF_VARS']['SYS']['mediafile_ext'] .= ',shopware';
$GLOBALS['TYPO3_CONF_VARS']['SYS']['fal']['onlineMediaHelpers']['shopware'] = \DPN\SwConnect\Media\ShopwareImageHelper::class;

$rendererRegistry = \TYPO3\CMS\Core\Resource\Rendering\RendererRegistry::getInstance();
$rendererRegistry->registerRendererClass(\DPN\SwConnect\Rendering\ShopwareImageRenderer::class);

unset($rendererRegistry);

/**
 * Signals / Slots
 */

/** @var \TYPO3\CMS\Extbase\SignalSlot\Dispatcher $signalSlotDispatcher */
$signalSlotDispatcher = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Extbase\SignalSlot\Dispatcher::class);

/**
 * Post-processes added files to add meta-information
 */
$signalSlotDispatcher->connect(
    \TYPO3\CMS\Core\Resource\ResourceStorage::class,
    \TYPO3\CMS\Core\Resource\ResourceStorage::SIGNAL_PostFileAdd,
    \DPN\SwConnect\Slot\ResourceStorageSlots::class,
    'postProcessAddedFiles'
);

unset($signalSlotDispatcher);
