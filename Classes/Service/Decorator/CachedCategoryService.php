<?php

namespace DPN\SwConnect\Service\Decorator;

use DPN\SwConnect\Service\CategoryService;
use TYPO3\CMS\Core\Cache\CacheManager;
use TYPO3\CMS\Extensionmanager\Utility\ConfigurationUtility;

class CachedCategoryService extends CategoryService
{
    /**
     * @var CacheManager
     */
    protected $cacheManager;

    /**
     * @param ConfigurationUtility $configurationUtility
     */
    public function __construct(ConfigurationUtility $configurationUtility, CacheManager $cacheManager)
    {
        parent::__construct($configurationUtility);

        $this->cacheManager = $cacheManager;
    }

    /**
     * @return array|mixed
     */
    public function findAll()
    {
        $cache = $this->cacheManager->getCache('sw_connect_categories');
        if (!$cache->has('all')) {
            $allCategories = parent::findAll();

            $cache->set('all', $allCategories, [], 3600);

            return $allCategories;
        }

        return $cache->get('all');
    }
}
