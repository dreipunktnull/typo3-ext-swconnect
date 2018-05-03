<?php

namespace DPN\SwConnect\Service;

use DPN\SwConnect\Client\ShopwareClient;
use DPN\SwConnect\Domain\Model\Image;
use DPN\SwConnect\Serialization\SerializerFactory;
use TYPO3\CMS\Core\SingletonInterface;
use TYPO3\CMS\Extensionmanager\Utility\ConfigurationUtility;

class ImageService implements SingletonInterface
{
    /**
     * @var ConfigurationUtility
     */
    protected $configurationUtility;

    /**
     * @param ConfigurationUtility $configurationUtility
     */
    public function __construct(ConfigurationUtility $configurationUtility)
    {
        $this->configurationUtility = $configurationUtility;
    }

    /**
     * @return array
     */
    public function findAll()
    {
        $api = $this->getClient();

        $result = $api->get('media?limit=1000');

        return $result['data'];
    }

    /**
     * @param int $id
     *
     * @return Image
     */
    public function find(int $id)
    {
        $client = $this->getClient();

        $result = $client->get(sprintf('media/%d', $id));

        try {
            $serializer = SerializerFactory::createDefaultSerializer();

            return $serializer->denormalize($result['data'], Image::class);
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
