<?php

namespace DPN\SwConnect\LinkHandler;

use DPN\SwConnect\Domain\Model\Article;
use DPN\SwConnect\Service\ProductService;
use TYPO3\CMS\Backend\Form\Element\InputLinkElement;
use TYPO3\CMS\Core\Imaging\Icon;
use TYPO3\CMS\Core\Imaging\IconFactory;
use TYPO3\CMS\Core\LinkHandling\LinkHandlingInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Recordlist\Controller\AbstractLinkBrowserController;

class ProductLinkHandler implements LinkHandlingInterface
{
    /**
     * @var string
     */
    protected $identifier;

    /**
     * @var array
     */
    protected $configuration;

    /**
     * Initializes the handler.
     *
     * @param AbstractLinkBrowserController $linkBrowser
     * @param string $identifier
     * @param array $configuration Page TSconfig
     */
    public function initialize(AbstractLinkBrowserController $linkBrowser, $identifier, array $configuration)
    {
        $this->identifier = $identifier;
        $this->configuration = $configuration;
    }

    /**
     * Returns a string interpretation of the link href query from objects, something like
     *
     *  - t3://page?uid=23&my=value#cool
     *  - https://www.typo3.org/
     *  - t3://file?uid=13
     *  - t3://folder?storage=2&identifier=/my/folder/
     *  - mailto:mac@safe.com
     *
     * array of data -> string
     *
     * @param array $parameters
     * @return string
     */
    public function asString(array $parameters): string
    {
        return sprintf('t3://shopware-product?%s', http_build_query([
            'shop' => $parameters['shop'] ?? '',
            'id' => $parameters['id'],
        ]));
    }

    /**
     * Returns a array with data interpretation of the link href from parsed query parameters of urn
     * representation.
     *
     * array of strings -> array of data
     *
     * @param array $data
     * @return array
     */
    public function resolveHandlerData(array $data): array
    {
        $productId = $data['id'];
        $productService = GeneralUtility::makeInstance(ObjectManager::class)->get(ProductService::class);

        $product = $productService->findOne((int)$productId);
        if (!$product instanceof Article) {
            return ['id' => ''];
        }

        $product->getMainDetail()->getSeoUrl();

        return ['id' => $data['id']];
    }

    /**
     * @param array $linkData
     * @param array $linkParts
     * @param array $data
     * @param InputLinkElement $element
     *
     * @return array
     */
    public function getFormData($linkData, $linkParts, $data, InputLinkElement $element)
    {
        $iconFactory = GeneralUtility::makeInstance(IconFactory::class);

        $objectManager = GeneralUtility::makeInstance(ObjectManager::class);
        $productService = $objectManager->get(ProductService::class);
        $product = $productService->findOne($linkData['id']);

        $shopwareIcon = $iconFactory->getIcon('swconnect-article', Icon::SIZE_SMALL)->render();

        if (null === $product) {
            return [
                'text' => sprintf('unable to find product with ID %s', $linkData['id']),
                'icon' => $shopwareIcon,
            ];
        }

        return [
            'text' => sprintf('%s [%s:%d]', $product->getName(), 'ID', $linkData['id']),
            'icon' => $shopwareIcon
        ];
    }
}
