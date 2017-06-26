<?php

namespace DPN\SwConnect\Service;

use DPN\SwConnect\Client\ShopwareClient;
use DPN\SwConnect\Domain\Model\Article;
use DPN\SwConnect\Serialization\SerializerFactory;
use TYPO3\CMS\Core\SingletonInterface;
use TYPO3\CMS\Extensionmanager\Utility\ConfigurationUtility;

class ProductService implements SingletonInterface
{
    const CATEGORY_MODE_OR = 'OR';

    /**
     * @var ConfigurationUtility
     */
    private $configurationUtility;

    /**
     * @param ConfigurationUtility $configurationUtility
     */
    public function __construct(ConfigurationUtility $configurationUtility)
    {
        $this->configurationUtility = $configurationUtility;
    }

    public function findAll()
    {
        $extConf = $this->configurationUtility->getCurrentConfiguration('sw_connect');
        $api = new ShopwareClient($extConf['api_url']['value'], $extConf['api_user']['value'], $extConf['api_secret']['value']);

        $result = $api->get('articles', ['limit' => 100]);

        return $result['data'];
    }

    /**
     * @param array $settings
     * @param string $mode
     * @return array
     */
    public function findByCategories(array $settings, $mode = self::CATEGORY_MODE_OR)
    {
        $extConf = $this->configurationUtility->getCurrentConfiguration('sw_connect');
        $api = new ShopwareClient($extConf['api_url']['value'], $extConf['api_user']['value'], $extConf['api_secret']['value']);

        $filters = [];

        $categories = explode(',', $settings['categories']);
        $categories = array_filter($categories);

        if (count($categories) > 0) {
            foreach ($categories as $category) {
                $filters[] = ['property' => 'category.id', 'value' => $category, 'operator' => $mode];
            }

            if ((bool)$settings['onlyActive'] === true) {
                $filters[] = ['property' => 'active', 'value' => 1];
            }
        }

        $result = $api->get('articlesByCategory', [
            'limit' => (int)$settings['limit'],
            'filter' => $filters
        ]);

        if (false === is_array($result['data'])) {
            return [];
        }

        try {
            $serializer = SerializerFactory::createDefaultSerializer();
            $des = $serializer->denormalize($result['data'], Article::class . '[]');
        } catch (\Exception $exception) {
            return [];
        }

        return $des;
    }
}
