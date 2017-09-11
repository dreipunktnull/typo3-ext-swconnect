<?php

namespace DPN\SwConnect\Backend\ToolbarItems;

use Doctrine\Common\Collections\ArrayCollection;
use TYPO3\CMS\Backend\Toolbar\ToolbarItemInterface;
use TYPO3\CMS\Core\Authentication\BackendUserAuthentication;
use TYPO3\CMS\Core\Page\PageRenderer;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Extbase\SignalSlot\Dispatcher;
use TYPO3\CMS\Fluid\View\StandaloneView;

class SwConnectToolbarItem implements ToolbarItemInterface
{
    const SIGNAL_COLLECT_STATUS = 'collectStatus';

    /**
     * Checks whether the user has access to this toolbar item
     * @TODO: Split into two methods a permission method and a "hasContent" or similar
     *
     * @return bool TRUE if user has access, FALSE if not
     */
    public function checkAccess()
    {
        return true;
    }

    /**
     * Render "item" part of this toolbar
     *
     * @return string Toolbar item HTML
     */
    public function getItem()
    {
        if ($this->hasDropDown()) {
            return $this->getFluidTemplateObject('SwConnectToolbarItem.html')->render();
        }
    }

    /**
     * TRUE if this toolbar item has a collapsible drop down
     *
     * @return bool
     */
    public function hasDropDown()
    {
        $backendUser = $this->getBackendUser();
        if ($backendUser->isAdmin()) {
            return true;
        }

        return false;
    }

    /**
     * Render "drop down" part of this toolbar
     *
     * @return string Drop down HTML
     */
    public function getDropDown()
    {
        $reports = new ArrayCollection();

        $dispatcher = GeneralUtility::makeInstance(ObjectManager::class)->get(Dispatcher::class);
        $dispatcher->dispatch(__CLASS__, static::SIGNAL_COLLECT_STATUS, ['reports' => $reports]);
        $reports = $this->sortReportsByPriority($reports);

        $view = $this->getFluidTemplateObject('SwConnectToolbarItemDropdown.html');
        $view->assign('reports', $reports);

        return $view->render();
    }

    /**
     * Returns an array with additional attributes added to containing <li> tag of the item.
     *
     * Typical usages are additional css classes and data-* attributes, classes may be merged
     * with other classes needed by the framework. Do NOT set an id attribute here.
     *
     * array(
     *     'class' => 'my-class',
     *     'data-foo' => '42',
     * )
     *
     * @return array List item HTML attributes
     */
    public function getAdditionalAttributes()
    {
        return [];
    }

    /**
     * Position relative to others
     *
     * @return int
     */
    public function getIndex()
    {
        return 50;
    }

    /**
     * Returns the current BE user.
     *
     * @return BackendUserAuthentication
     */
    protected function getBackendUser()
    {
        return $GLOBALS['BE_USER'];
    }

    /**
     * @return PageRenderer
     * @throws \InvalidArgumentException
     */
    protected function getPageRenderer()
    {
        return GeneralUtility::makeInstance(PageRenderer::class);
    }

    /**
     * Returns a new standalone view, shorthand function
     *
     * @param string $filename Which templateFile should be used.
     * @return StandaloneView
     * @throws \InvalidArgumentException
     */
    protected function getFluidTemplateObject(string $filename): StandaloneView
    {
        $view = GeneralUtility::makeInstance(StandaloneView::class);
        $view->setLayoutRootPaths(['EXT:sw_connect/Resources/Private/Layouts']);
        $view->setPartialRootPaths(['EXT:sw_connect/Resources/Private/Partials/ToolbarItems']);
        $view->setTemplateRootPaths(['EXT:sw_connect/Resources/Private/Templates/ToolbarItems']);

        $view->setTemplate($filename);

        $view->getRequest()->setControllerExtensionName('SwConnect');
        return $view;
    }

    private function sortReportsByPriority(ArrayCollection $reports) : ArrayCollection
    {
        $iterator = $reports->getIterator();
        $iterator->uasort(function ($a, $b) {
            return ($a['priority'] < $b['priority']) ? -1 : 1;
        });

        return new ArrayCollection(iterator_to_array($iterator));
    }
}
