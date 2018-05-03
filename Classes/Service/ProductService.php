<?php

namespace DPN\SwConnect\Service;

use DPN\SwConnect\Client\ShopwareClient;
use DPN\SwConnect\Domain\Model\Article;
use DPN\SwConnect\Serialization\SerializerFactory;
use TYPO3\CMS\Core\Log\LogManager;
use TYPO3\CMS\Core\SingletonInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extensionmanager\Utility\ConfigurationUtility;

class ProductService implements SingletonInterface
{
    const CATEGORY_MODE_OR = 'OR';

    /**
     * @var \TYPO3\CMS\Core\Log\Logger
     */
    protected $logger;

    /**
     * @var ConfigurationUtility
     */
    private $configurationUtility;

    /**
     * @var UnitService
     */
    private $unitService;

    /**
     * @param ConfigurationUtility $configurationUtility
     * @param UnitService $unitService
     */
    public function __construct(ConfigurationUtility $configurationUtility, UnitService $unitService)
    {
        $this->configurationUtility = $configurationUtility;

        $this->logger = GeneralUtility::makeInstance(LogManager::class)->getLogger(__CLASS__);
        $this->unitService = $unitService;
    }

    public function count()
    {
        $api = $this->getClient();

        $result = $api->get('articles');

        return $result['total'];
    }

    /**
     * @param int $id
     * @return Article
     */
    public function findOne(int $id)
    {
        $api = $this->getClient();

        $result = $api->get(sprintf('articles/%s', $id));

        try {
            $serializer = SerializerFactory::createDefaultSerializer();

            if (empty($result['data'])) {
                throw new \RuntimeException('No valid product from API');
            }

            /** @var Article $article */
            $article = $serializer->denormalize($result['data'], Article::class);
            $unitId = $article->getMainDetail()->getUnitId();
            if ($unitId !== null) {
                $unit = $this->unitService->findOne($unitId);
                $article->getMainDetail()->setUnit($unit);
            }
            $article->setRecord($result['data']);

            return $article;
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
     * @param array $arguments
     * @return Article[]
     */
    public function findAll(array $arguments = [])
    {
        $api = $this->getClient();

        $result = $api->get('articles', $arguments);

        try {
            $serializer = SerializerFactory::createDefaultSerializer();

            /** @var Article $hydratedObject */
            $hydratedObjects = $serializer->denormalize($result['data'], Article::class . '[]');

            foreach ($hydratedObjects as $idx =>  $hydratedObject) {
                $hydratedObject->setRecord($result['data'][$idx]);
            }

            return $hydratedObjects;
        } catch (\Exception $exception) {
            $this->logger->critical($exception->getMessage(), [
                'result' => $result,
                'code' => $exception->getCode(),
                'file' => $exception->getFile(),
                'line' => $exception->getLine(),
                'data' => $result['data'],
            ]);

            return [];
        }
    }

    /**
     * @param array $settings
     * @param string $mode
     * @return array
     */
    public function findByCategories(array $settings, $mode = self::CATEGORY_MODE_OR)
    {
        $api = $this->getClient();

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
            'filter' => $filters,
        ]);

        if (false === is_array($result['data'])) {
            return [];
        }

        try {
            $serializer = SerializerFactory::createDefaultSerializer();

            return $serializer->denormalize($result['data'], Article::class . '[]');
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
     * @param array $settings
     * @param array $ids
     * @return Article[]
     */
    public function findByIds(array $settings, array $ids)
    {
        $ids = array_filter($ids);

        $limit = (int)$settings['limit'];

        $articles = [];
        if (count($ids) > 0) {
            foreach ($ids as $id) {
                $cachedArticle = $this->findOne($id);
                if ($cachedArticle !== null) {
                    $articles[] = $cachedArticle;
                }
            }
        }

        return $articles;
    }

    /**
     * @return ShopwareClient
     */
    protected function getClient(): ShopwareClient
    {
        $extConf = $this->configurationUtility->getCurrentConfiguration('sw_connect');
        $api = new ShopwareClient($extConf['api_url']['value'], $extConf['api_user']['value'], $extConf['api_secret']['value']);

        return $api;
    }
}
