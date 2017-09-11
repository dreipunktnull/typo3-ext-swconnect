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

if (!is_array($GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['sw_connect_images'])) {
    $GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['sw_connect_images'] = [
        'backend' => \TYPO3\CMS\Core\Cache\Backend\TransientMemoryBackend::class
    ];
}

if (!is_array($GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['sw_connect_seourl'])) {
    $GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['sw_connect_seourl'] = [
        'backend' => \TYPO3\CMS\Core\Cache\Backend\Typo3DatabaseBackend::class,
        'frontend' => \TYPO3\CMS\Core\Cache\Frontend\StringFrontend::class,
    ];
}

\NamelessCoder\MultilevelCache\CacheConfiguration::convert('sw_connect_products', [
    [
        'backend' => \TYPO3\CMS\Core\Cache\Backend\TransientMemoryBackend::class,
        'options' => [
            'defaultLifetime' => 0,
        ]
    ],
    [
        'backend' => \TYPO3\CMS\Core\Cache\Backend\Typo3DatabaseBackend::class,
        'options' => [
            'defaultLifetime' => 3600,
        ]
    ],
]);

\NamelessCoder\MultilevelCache\CacheConfiguration::convert('sw_connect_seourl', [
    [
        'backend' => \TYPO3\CMS\Core\Cache\Backend\TransientMemoryBackend::class,
        'options' => [
            'defaultLifetime' => 0,
        ]
    ],
    [
        'backend' => \TYPO3\CMS\Core\Cache\Backend\Typo3DatabaseBackend::class,
        'options' => [
            'defaultLifetime' => 3600,
        ]
    ],
]);

\NamelessCoder\MultilevelCache\CacheConfiguration::convert('sw_connect_images', [
    [
        'backend' => \TYPO3\CMS\Core\Cache\Backend\TransientMemoryBackend::class,
        'options' => [
            'defaultLifetime' => 0,
        ]
    ],
    [
        'backend' => \TYPO3\CMS\Core\Cache\Backend\Typo3DatabaseBackend::class,
        'options' => [
            'defaultLifetime' => 3600,
        ]
    ],
]);

/**
 * Register a global fluid namespace
 */
$GLOBALS['TYPO3_CONF_VARS']['SYS']['fluid']['namespaces']['swc'][] = 'DPN\\SwConnect\\ViewHelpers';

/**
 * Icons
 */
$iconRegistry = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Imaging\IconRegistry::class);
$iconRegistry->registerIcon(
    'swconnect-article',
    \TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
    [
        'source' => 'EXT:sw_connect/Resources/Public/Icons/icon-shopware.svg',
    ]
);
$iconRegistry->registerIcon(
    'swconnect-toolbar-item',
    \TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
    [
        'source' => 'EXT:sw_connect/Resources/Public/Icons/icon-shopware.svg',
    ]
);
$iconRegistry->registerIcon(
    'swconnect-toolbar-dpn',
    \TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
    [
        'source' => 'EXT:sw_connect/Resources/Public/Icons/icon-shopware.svg',
    ]
);

unset($iconRegistry);

/**
 * Shopware media rendering
 */
$GLOBALS['TYPO3_CONF_VARS']['SYS']['mediafile_ext'] .= ',shopware';
$GLOBALS['TYPO3_CONF_VARS']['SYS']['fal']['onlineMediaHelpers']['shopware'] = \DPN\SwConnect\Media\ShopwareImageHelper::class;

$rendererRegistry = \TYPO3\CMS\Core\Resource\Rendering\RendererRegistry::getInstance();
$rendererRegistry->registerRendererClass(\DPN\SwConnect\Rendering\ShopwareImageRenderer::class);

unset($rendererRegistry);

/**
 * FAL Driver
 */
$GLOBALS['TYPO3_CONF_VARS']['SYS']['fal']['registeredDrivers']['SwConnectShopware'] = [
    'class' => \DPN\SwConnect\Resource\Driver\SwConnectShopwareDriver::class,
    'shortName' => 'SwConnectShopware',
    'flexFormDS' => 'FILE:EXT:sw_connect/Configuration/Resource/Driver/SwConnectShopwareDriverFlexForm.xml',
    'label' => 'SwConnect Shopware'
];

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

/**
 * Add Status Information to the Toolbar Item
 */
$signalSlotDispatcher->connect(
    \DPN\SwConnect\Backend\ToolbarItems\SwConnectToolbarItem::class,
    \DPN\SwConnect\Backend\ToolbarItems\SwConnectToolbarItem::SIGNAL_COLLECT_STATUS,
    \DPN\SwConnect\Slot\StatusCollectorSlot::class,
    'collect'
);

unset($signalSlotDispatcher);

/**
 * LinkHandling
 */
$GLOBALS['TYPO3_CONF_VARS']['SYS']['linkHandler']['shopware-product'] = \DPN\SwConnect\LinkHandler\ProductLinkHandler::class;
$GLOBALS['TYPO3_CONF_VARS']['SYS']['formEngine']['linkHandler']['shopware-product'] = \DPN\SwConnect\LinkHandler\ProductLinkHandler::class;
$GLOBALS['TYPO3_CONF_VARS']['FE']['typolinkBuilder']['shopware-product'] = \DPN\SwConnect\LinkHandler\ProductLinkBuilder::class;

if (TYPO3_MODE === 'BE') {
    $GLOBALS['TYPO3_CONF_VARS']['BE']['toolbarItems'][1498721802] = \DPN\SwConnect\Backend\ToolbarItems\SwConnectToolbarItem::class;
}
