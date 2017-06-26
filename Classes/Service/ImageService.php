<?php

namespace DPN\SwConnect\Service;

use DPN\SwConnect\Client\ShopwareClient;
use DPN\SwConnect\Domain\Model\Image;
use DPN\SwConnect\Serialization\SerializerFactory;
use TYPO3\CMS\Core\Cache\CacheManager;
use TYPO3\CMS\Core\SingletonInterface;
use TYPO3\CMS\Extensionmanager\Utility\ConfigurationUtility;

class ImageService implements SingletonInterface
{
    /**
     * @var ConfigurationUtility
     */
    protected $configurationUtility;

    /**
     * @var CacheManager
     */
    protected $cacheManager;

    /**
     * @param ConfigurationUtility $configurationUtility
     * @param CacheManager $cacheManager
     */
    public function __construct(ConfigurationUtility $configurationUtility, CacheManager $cacheManager)
    {
        $this->configurationUtility = $configurationUtility;
        $this->cacheManager = $cacheManager;
    }

    /**
     * @return array
     */
    public function findAll()
    {
        $api = $this->getClient();

        $result = $api->get('categories?limit=1000');

        return $result['data'];
    }

    /**
     * @param int $id
     *
     * @return Image
     */
    public function find($id)
    {
        $cache = $this->cacheManager->getCache('sw_connect_images_1st');
        $entryIdentifier = sprintf('image_%d', $id);
        if ($cache->has($entryIdentifier)) {
            return $cache->get($entryIdentifier);
        }

        $client = $this->getClient();

        $result = $client->get(sprintf('media/%d', $id));

        try {
            $serializer = SerializerFactory::createDefaultSerializer();
            $image = $serializer->denormalize($result['data'], Image::class);
            $cache->set($entryIdentifier, $image);

            return $image;
        } catch (\Exception $exception) {
            return null;
        }
    }

    /**
     * @return ShopwareClient
     */
    protected function getClient()
    {
        $extConf = $this->configurationUtility->getCurrentConfiguration('sw_connect');
        $api = new ShopwareClient($extConf['api_url']['value'], $extConf['api_user']['value'], $extConf['api_secret']['value']);
        return $api;
    }
}
