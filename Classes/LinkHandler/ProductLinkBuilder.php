<?php
declare(strict_types=1);
namespace DPN\SwConnect\LinkHandler;

use DPN\SwConnect\Domain\Model\Article;
use DPN\SwConnect\Service\ProductService;
use TYPO3\CMS\Core\Cache\CacheManager;
use TYPO3\CMS\Core\Cache\Frontend\FrontendInterface;
use TYPO3\CMS\Core\SingletonInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Frontend\Typolink\AbstractTypolinkBuilder;

class ProductLinkBuilder extends AbstractTypolinkBuilder implements SingletonInterface
{
    const URL_CACHE_LIFETIME = 600;

    /**
     * @var CacheManager
     */
    protected $cacheManager;

    /**
     * @var FrontendInterface
     */
    protected $cache;

    /**
     * Should be implemented by all subclasses to return an array with three parts:
     * - URL
     * - Link Text (can be modified)
     * - Target (can be modified)
     *
     * @param array $linkDetails parsed link details by the LinkService
     * @param string $linkText the link text
     * @param string $target the target to point to
     * @param array $conf the TypoLink configuration array
     * @return array an array with three parts (URL, Link Text, Target)
     */
    public function build(array &$linkDetails, string $linkText, string $target, array $conf): array
    {
        $productId = $linkDetails['id'];

        $seoUrl = '';
        if (!$this->cacheManager instanceof CacheManager) {
            $this->cacheManager = GeneralUtility::makeInstance(CacheManager::class);
            $this->cache = $this->cacheManager->getCache('sw_connect_seourl');
        }
        if ($this->cache->has((string) $productId)) {
            $seoUrl = $this->cache->get($productId);
        } else {
            $productService = GeneralUtility::makeInstance(ObjectManager::class)->get(ProductService::class);

            $product = $productService->findOne((int)$productId);
            if (!$product instanceof Article) {
                return [];
            }

            $seoUrl = $product->getMainDetail()->getSeoUrl();
            $this->cache->set($productId, $seoUrl, ['seo_url'], self::URL_CACHE_LIFETIME);
        }

        return [
            $seoUrl,
            $linkText,
            $target,
        ];
    }
}
