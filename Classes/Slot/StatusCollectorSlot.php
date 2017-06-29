<?php

namespace DPN\SwConnect\Slot;

use Doctrine\Common\Collections\ArrayCollection;

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
            'value' => 'https://api.example.com/api',
            'status' => 'normal',
            'priority' => 200,
        ]);
    }

    /**
     * @return string
     */
    protected function getShopwareVersion()
    {
        return '5.2.2';
    }
}
