<?php

namespace DPN\SwConnect\Service\Decorator;

use DPN\SwConnect\Domain\Model\Article;
use DPN\SwConnect\Service\ProductService;
use DPN\SwConnect\Service\UnitService;
use TYPO3\CMS\Core\Cache\CacheManager;
use TYPO3\CMS\Core\Cache\Frontend\FrontendInterface;
use TYPO3\CMS\Extensionmanager\Utility\ConfigurationUtility;

class CachedProductService extends ProductService
{
    /**
     * @var CacheManager
     */
    protected $cacheManager;

    /**
     * @var FrontendInterface
     */
    protected $cache;

    /**
     * @var Article[]
     */
    protected $articleCache = [];

    /**
     * @param ConfigurationUtility $configurationUtility
     * @param UnitService $unitService
     * @param CacheManager $cacheManager
     */
    public function __construct(ConfigurationUtility $configurationUtility, UnitService $unitService, CacheManager $cacheManager)
    {
        parent::__construct($configurationUtility, $unitService);

        $this->cacheManager = $cacheManager;
    }

    /**
     * @param int $id
     * @return Article
     */
    public function findOne(int $id)
    {
        if ($this->cache === null) {
            $this->initializeCache();
        }

        if (true === array_key_exists($id, $this->articleCache)) {
            return $this->articleCache[$id];
        }

        $entryIdentifier = sprintf('article-%s', $id);
        if ($this->cache->has($entryIdentifier)) {
            return $this->cache->get($entryIdentifier);
        }

        $article = parent::findOne($id);

        if ($article !== null) {
            $this->cache->set($entryIdentifier, $article);
            $this->articleCache[$id] = $article;
        }

        return $article;
    }

    /**
     * @return FrontendInterface
     * @throws \TYPO3\CMS\Core\Cache\Exception\NoSuchCacheException
     */
    protected function initializeCache(): FrontendInterface
    {
        return $this->cache = $this->cacheManager->getCache('sw_connect_products');
    }
}
