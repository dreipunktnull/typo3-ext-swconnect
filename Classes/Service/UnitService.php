<?php

namespace DPN\SwConnect\Service;

use DPN\SwConnect\Client\ShopwareClient;
use DPN\SwConnect\Domain\Model\Unit;
use DPN\SwConnect\Serialization\SerializerFactory;
use TYPO3\CMS\Core\SingletonInterface;
use TYPO3\CMS\Extensionmanager\Utility\ConfigurationUtility;

class UnitService implements SingletonInterface
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

    public function findAll()
    {
        $result = $this->getClient()
            ->get('units');

        if (false === is_array($result['data'])) {
            return [];
        }

        try {
            $serializer = SerializerFactory::createDefaultSerializer();

            return $serializer->denormalize($result['data'], Unit::class . '[]');
        } catch (\Exception $exception) {
            return [];
        }
    }

    /**
     * Finds one unit by its id.
     *
     * @param int $id
     * @return Unit
     */
    public function findOne(int $id)
    {
        $result = $this->getClient()
            ->get(sprintf('units/%s', $id));

        if (false === is_array($result['data'])) {
            return null;
        }

        try {
            $serializer = SerializerFactory::createDefaultSerializer();

            $unit = $serializer->denormalize($result['data'], Unit::class);
            return $unit;
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
