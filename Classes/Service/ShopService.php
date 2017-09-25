<?php

namespace DPN\SwConnect\Service;

use DPN\SwConnect\Client\ShopwareClient;
use DPN\SwConnect\Domain\Model\Shop;
use DPN\SwConnect\Serialization\SerializerFactory;
use TYPO3\CMS\Core\SingletonInterface;
use TYPO3\CMS\Extensionmanager\Utility\ConfigurationUtility;

class ShopService implements SingletonInterface
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
     * @return Shop[]
     */
    public function findAll()
    {
        $api = $this->getClient();

        $result = $api->get('shops?limit=1000');

        try {
            $serializer = SerializerFactory::createDefaultSerializer();

            $halfShops = $serializer->denormalize($result['data'], Shop::class . '[]');

            $shops = [];
            foreach ($halfShops as $shop) {
                /** @var Shop $shop */
                $shops[] = $this->find($shop->getId());
            }

            return $shops;
        } catch (\Exception $exception) {
            return [];
        }
    }

    /**
     * @param int $id
     *
     * @return Shop
     */
    public function find(int $id)
    {
        $client = $this->getClient();

        $result = $client->get(sprintf('shops/%d', $id));

        try {
            $serializer = SerializerFactory::createDefaultSerializer();

            return $serializer->denormalize($result['data'], Shop::class);
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
