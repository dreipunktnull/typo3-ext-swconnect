<?php

namespace DPN\SwConnect\Slot;

use Doctrine\Common\Collections\ArrayCollection;
use DPN\SwConnect\Service\VersionService;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Extensionmanager\Utility\ConfigurationUtility;

/**
 * Main System Status Collector.
 */
class StatusCollectorSlot implements StatusCollectorSlotInterface
{
    /**
     * {@inheritdoc}
     */
    public function collect(ArrayCollection $reports)
    {
        $reports->add([
            'iconIdentifier' => 'actions-system-extension-configure',
            'title' => 'Shopware Version',
            'titleAddition' => null,
            'value' => $this->getShopwareVersion(),
            'status' => 'normal',
            'priority' => 100,
        ]);

        $reports->add([
            'iconIdentifier' => 'actions-system-extension-configure',
            'title' => 'API URL',
            'titleAddition' => null,
            'value' => $this->getShopwareApiUrl(),
            'status' => 'normal',
            'priority' => 200,
        ]);
    }

    /**
     * @return string
     */
    protected function getShopwareVersion()
    {
        $objectManager = GeneralUtility::makeInstance(ObjectManager::class);
        $versionService = $objectManager->get(VersionService::class);

        $version = $versionService->getVersion();
        if ($version === null) {
            return 'error retrieving version information';
        }

        return $version->getVersion();
    }

    /**
     * @return string
     */
    private function getShopwareApiUrl(): string
    {
        $configurationUtility = GeneralUtility::makeInstance(ConfigurationUtility::class);

        $extConf = $configurationUtility->getCurrentConfiguration('sw_connect');
        return $extConf['api_url']['value'] ?? '-';
    }
}
