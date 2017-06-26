<?php

namespace DPN\SwConnect\Slot;

use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Resource\FileInterface;
use TYPO3\CMS\Core\Resource\FolderInterface;
use TYPO3\CMS\Core\Resource\Index\MetaDataRepository;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class ResourceStorageSlots
{
    /**
     * Adds required mimetype information to newly added .shopware
     * files.
     * @param FileInterface $file
     * @param FolderInterface $targetFolder
     */
    public function postProcessAddedFiles($file, $targetFolder)
    {
        if ($file->getExtension() !== 'shopware') {
            return;
        }

        $metadata = MetaDataRepository::getInstance()->findByFile($file);
        $realExtension = end(explode('.', $metadata['tx_swconnect_url']));
        $mimeType = 'text/plain';
        switch ($realExtension) {
            case 'png':
                $mimeType = 'image/png';
                break;
            case 'jpg':
                $mimeType = 'image/jpg';
                break;
            default:
                break;
        }

        GeneralUtility::makeInstance(ConnectionPool::class)
            ->getConnectionForTable('sys_file')
            ->update('sys_file', ['mime_type' => $mimeType], ['identifier' => $file->getIdentifier()], [\TYPO3\CMS\Core\Database\Connection::PARAM_STR])
        ;
    }
}
