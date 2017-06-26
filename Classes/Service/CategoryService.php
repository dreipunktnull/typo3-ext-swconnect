<?php

namespace DPN\SwConnect\Service;

use DPN\SwConnect\Client\ShopwareClient;
use TYPO3\CMS\Core\SingletonInterface;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;
use TYPO3\CMS\Extensionmanager\Utility\ConfigurationUtility;

class CategoryService implements SingletonInterface
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
        $extConf = $this->configurationUtility->getCurrentConfiguration('sw_connect');
        $api = new ShopwareClient($extConf['api_url']['value'], $extConf['api_user']['value'], $extConf['api_secret']['value']);

        $result = $api->get('categories?limit=1000');

        return $result['data'];
    }
}
