<?php

namespace DPN\SwConnect\Slot;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * Every slot to add a status message to the backend
 * status indicator should implement this interface.
 */
interface StatusCollectorSlotInterface
{
    /**
     * Called by the Dispatcher. To add a Status Item, use
     * the following code:
     *
     * $reports->add([
     *   'iconIdentifier' => 'my-icon-identifier',
     *   'title'          => 'My Title',
     *   'titleAddition'  => null,
     *   'value'          => 'super nice value',
     *   'status'         => 'success', // success, warning, info
     *   'priority'       => 100,
     * ]);
     *
     * The priority index manipulates the order of
     * appearance.
     *
     * @param ArrayCollection $reports
     */
    public function collect(ArrayCollection $reports);
}
