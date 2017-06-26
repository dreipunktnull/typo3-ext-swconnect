<?php

namespace DPN\SwConnect\Media;

use DPN\SwConnect\Domain\Model\Image;
use DPN\SwConnect\Service\ImageService;
use TYPO3\CMS\Core\Resource\File;
use TYPO3\CMS\Core\Resource\Folder;
use TYPO3\CMS\Core\Resource\Index\MetaDataRepository;
use TYPO3\CMS\Core\Resource\OnlineMedia\Helpers\AbstractOnlineMediaHelper;
use TYPO3\CMS\Core\Resource\OnlineMedia\Helpers\OnlineMediaHelperRegistry;
use TYPO3\CMS\Core\Resource\ResourceFactory;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Object\ObjectManager;

class ShopwareImageHelper extends AbstractOnlineMediaHelper
{
    /**
     * @param Image $image
     * @return NULL|File
     */
    public static function transformImageToFile(Image $image)
    {
        $targetFolderIdentifier = '1:/user_upload';
        $targetFolder = null;

        if ($targetFolderIdentifier) {
            try {
                $targetFolder = ResourceFactory::getInstance()->getFolderObjectFromCombinedIdentifier($targetFolderIdentifier);
            } catch (\Exception $e) {
                $targetFolder = null;
            }
        }

        $url = sprintf('shopware://%s/%s.%s', $image->getMediaId(), $image->getPath(), $image->getExtension());

        return OnlineMediaHelperRegistry::getInstance()
            ->transformUrlToFile($url, $targetFolder, ['shopware']);
    }

    /**
     * Try to transform given URL to a File
     *
     * @param string $url
     * @param Folder $targetFolder
     * @return File|NULL
     */
    public function transformUrlToFile($url, Folder $targetFolder)
    {
        $components = parse_url($url);

        $file = $this->findExistingFileByOnlineMediaId($url, $targetFolder, $this->extension);
        if ($file === null) {
            $file = $this->createNewFile(
                $targetFolder,
                sprintf('%s.%s', $components['host'], $this->extension),
                $url
            );

            MetaDataRepository::getInstance()->createMetaDataRecord($file->getUid(), $this->getMetaData($file));
        }

        return $file;
    }

    /**
     * Get public url
     *
     * Return NULL if you want to use core default behaviour
     *
     * @param File $file
     * @param bool $relativeToCurrentScript
     * @return string|NULL
     */
    public function getPublicUrl(File $file, $relativeToCurrentScript = false)
    {
        $url = $this->getOnlineMediaId($file);
        try {
            $components = parse_url($url);
            if ($components['scheme'] !== 'shopware') {
                throw new \InvalidArgumentException('No valid shopware file identifier');
            }

            $imageId = $components['host'];
            $objectManager = $this->getObjectManager();
            $imageService = $objectManager->get(ImageService::class);

            $imageFromApi = $imageService->find($imageId);
            $imageFromApi->getDescription();

            return $imageFromApi->getPath();
        } catch (\Exception $exception) {
            return '';
        }
    }

    /**
     * Get local absolute file path to preview image
     *
     * Return an empty string when no preview image is available
     *
     * @param File $file
     * @return string
     */
    public function getPreviewImage(File $file)
    {
        $url = $this->getOnlineMediaId($file);
        $metadata = MetaDataRepository::getInstance()->findByFile($file);
        if ($metadata && array_key_exists('tx_swconnect_url', $metadata) && $metadata['tx_swconnect_url'] !== '') {
            $imageUrl = $metadata['tx_swconnect_url'];
            $temporaryFileName = $this->getTempFolderPath() . 'shopware_' . md5($url) . '.jpg';
            if (!file_exists($temporaryFileName)) {
                $previewImage = GeneralUtility::getUrl($imageUrl);
                if ($previewImage !== false) {
                    file_put_contents($temporaryFileName, $previewImage);
                    GeneralUtility::fixPermissions($temporaryFileName);
                }
            }
            return $temporaryFileName;
        }

        return '';
    }

    /**
     * Get meta data for OnlineMedia item
     *
     * See $GLOBALS[TCA][sys_file_metadata][columns] for possible fields to fill/use
     *
     * @param File $file
     * @return array with metadata
     */
    public function getMetaData(File $file)
    {
        $url = $this->getOnlineMediaId($file);
        try {
            $components = parse_url($url);
            if ($components['scheme'] !== 'shopware') {
                throw new \InvalidArgumentException('No valid shopware file identifier');
            }

            $imageId = $components['host'];
            $objectManager = $this->getObjectManager();
            $imageService = $objectManager->get(ImageService::class);

            $imageFromApi = $imageService->find($imageId);
            $imageFromApi->getDescription();

            return [
                'width' => (int)$imageFromApi->getWidth(),
                'height' => (int)$imageFromApi->getHeight(),
                'description' => (int)$imageFromApi->getDescription(),
                'tx_swconnect_url' => $imageFromApi->getPath(),
            ];
        } catch (\Exception $exception) {
            return [];
        }
    }

    /**
     * @return object|ObjectManager
     */
    protected function getObjectManager()
    {
        return GeneralUtility::makeInstance(ObjectManager::class);
    }
}
