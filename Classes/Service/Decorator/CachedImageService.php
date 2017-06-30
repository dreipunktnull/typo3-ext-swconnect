<?php

namespace DPN\SwConnect\Service\Decorator;

use DPN\SwConnect\Domain\Model\Image;
use DPN\SwConnect\Service\ImageService;
use TYPO3\CMS\Core\Cache\CacheManager;
use TYPO3\CMS\Core\Cache\Frontend\FrontendInterface;
use TYPO3\CMS\Extensionmanager\Utility\ConfigurationUtility;

class CachedImageService extends ImageService
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
     * @var Image[]
     */
    protected $imageCache = [];

    /**
     * @param ConfigurationUtility $configurationUtility
     * @param CacheManager $cacheManager
     */
    public function __construct(ConfigurationUtility $configurationUtility, CacheManager $cacheManager)
    {
        parent::__construct($configurationUtility);

        $this->cacheManager = $cacheManager;
    }


    /**
     * @param int $id
     * @return Image
     */
    public function find(int $id)
    {
        if ($this->cache === null) {
            $this->initializeCache();
        }

        if (true === array_key_exists($id, $this->imageCache)) {
            return $this->imageCache[$id];
        }

        $entryIdentifier = sprintf('image-%s', $id);
        if ($this->cache->has($entryIdentifier)) {
            return $this->cache->get($entryIdentifier);
        }

        $image = parent::find($id);

        if ($image !== null) {
            $this->cache->set($entryIdentifier, $image);
            $this->imageCache[$id] = $image;
        }

        return $image;
    }

    /**
     * @return FrontendInterface
     *
     * @throws \TYPO3\CMS\Core\Cache\Exception\NoSuchCacheException
     */
    protected function initializeCache(): FrontendInterface
    {
        return $this->cache = $this->cacheManager->getCache('sw_connect_images');
    }
}
