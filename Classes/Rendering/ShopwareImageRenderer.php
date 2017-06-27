<?php

namespace DPN\SwConnect\Rendering;

use DPN\SwConnect\Service\ImageService;
use TYPO3\CMS\Core\Resource\FileInterface;
use TYPO3\CMS\Core\Resource\Index\MetaDataRepository;
use TYPO3\CMS\Core\Resource\Rendering\FileRendererInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3Fluid\Fluid\Core\ViewHelper\TagBuilder;

class ShopwareImageRenderer implements FileRendererInterface
{
    /**
     * Returns the priority of the renderer
     * This way it is possible to define/overrule a renderer
     * for a specific file type/context.
     *
     * For example create a video renderer for a certain storage/driver type.
     *
     * Should be between 1 and 100, 100 is more important than 1
     *
     * @return int
     */
    public function getPriority()
    {
        return 1;
    }

    /**
     * Check if given File(Reference) can be rendered
     *
     * @param FileInterface $file File or FileReference to render
     * @return bool
     */
    public function canRender(FileInterface $file)
    {
        return $file->getExtension() === 'shopware';
    }

    /**
     * Render for given File(Reference) HTML output
     *
     * @param FileInterface $file
     * @param int|string $width TYPO3 known format; examples: 220, 200m or 200c
     * @param int|string $height TYPO3 known format; examples: 220, 200m or 200c
     * @param array $options
     * @param bool $usedPathsRelativeToCurrentScript See $file->getPublicUrl()
     * @return string
     */
    public function render(FileInterface $file, $width, $height, array $options = [], $usedPathsRelativeToCurrentScript = false)
    {
        $objectManager = GeneralUtility::makeInstance(ObjectManager::class);

        $fileMetadataRepository = $objectManager->get(MetaDataRepository::class);
        $metaData = $fileMetadataRepository->findByFile($file);

        $tagBuilder = $objectManager->get(TagBuilder::class);
        $tagBuilder->reset();

        $tagBuilder->setTagName('img');

        if (array_key_exists('tx_swconnect_url', $metaData) && $metaData['tx_swconnect_url'] !== '') {
            $url = $metaData['tx_swconnect_url'];
        } else {
            $imageService = $objectManager->get(ImageService::class);
            $image = $imageService->find($file->getNameWithoutExtension());

            $url = $image->getPath();
        }

        foreach (['class'] as $attribute) {
            if (array_key_exists($attribute, $options)) {
                $tagBuilder->addAttribute($attribute, $options[$attribute]);
            }
        }

        $tagBuilder->addAttribute('src', $url);

        return $tagBuilder->render();
    }
}
