<?php

namespace DPN\SwConnect\Service;

use DPN\SwConnect\Client\ShopwareClient;
use DPN\SwConnect\Domain\Model\Category;
use DPN\SwConnect\Serialization\SerializerFactory;
use TYPO3\CMS\Core\Log\LogManager;
use TYPO3\CMS\Core\SingletonInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extensionmanager\Utility\ConfigurationUtility;

class CategoryService implements SingletonInterface
{
    /**
     * @var ConfigurationUtility
     */
    protected $configurationUtility;

    /**
     * @var \TYPO3\CMS\Core\Log\Logger
     */
    protected $logger;

    /**
     * @param ConfigurationUtility $configurationUtility
     */
    public function __construct(ConfigurationUtility $configurationUtility)
    {
        $this->configurationUtility = $configurationUtility;

        $this->logger = GeneralUtility::makeInstance(LogManager::class)->getLogger(__CLASS__);
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
     * @return Category[]
     */
    public function findChildrenByParentId(int $id)
    {
        $api = $this->getClient();

        $filters = [
            ['property' => 'parentId', 'value' => $id]
        ];

        $result = $api->get('categories', [
            'limit' => 1000,
            'filter' => $filters,
        ]);

        if (false === is_array($result['data'])) {
            return [];
        }

        try {
            $serializer = SerializerFactory::createDefaultSerializer();

            return $serializer->denormalize($result['data'], Category::class . '[]');
        } catch (\Exception $exception) {

            $this->logger->critical($exception->getMessage(), [
                'code' => $exception->getCode(),
                'file' => $exception->getFile(),
                'line' => $exception->getLine(),
                'data' => $result['data'],
            ]);

            return [];
        }
    }

    /**
     * @param int $uid
     * @return Category
     */
    public function findById(int $uid)
    {
        $api = $this->getClient();

        $result = $api->get(sprintf('categories/%s', $uid), [
            'limit' => 1000,
        ]);

        if (false === is_array($result['data'])) {
            return null;
        }

        if (array_key_exists('0', $result['data'])) {
            unset($result['data']['0']);
        }

        try {
            $serializer = SerializerFactory::createDefaultSerializer();

            return $serializer->denormalize($result['data'], Category::class);
        } catch (\Exception $exception) {

            $this->logger->critical($exception->getMessage(), [
                'code' => $exception->getCode(),
                'file' => $exception->getFile(),
                'line' => $exception->getLine(),
                'data' => $result['data'],
            ]);

            return null;
        }
    }

    /**
     * @return ShopwareClient
     */
    private function getClient(): ShopwareClient
    {
        $extConf = $this->configurationUtility->getCurrentConfiguration('sw_connect');
        $api = new ShopwareClient($extConf['api_url']['value'], $extConf['api_user']['value'], $extConf['api_secret']['value']);
        return $api;
    }
}
