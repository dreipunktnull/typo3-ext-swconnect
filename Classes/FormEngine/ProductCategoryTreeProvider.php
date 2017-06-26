<?php

namespace DPN\SwConnect\FormEngine;

use TYPO3\CMS\Core\Tree\TableConfiguration\DatabaseTreeDataProvider;

class ProductCategoryTreeProvider extends DatabaseTreeDataProvider
{
    /**
     * @var \TYPO3\CMS\Core\Authentication\BackendUserAuthentication
     */
    protected $backendUserAuthentication;

    /**
     * Required constructor
     *
     * @param array $configuration TCA configuration
     */
    public function __construct(array $configuration)
    {
        $this->backendUserAuthentication = $GLOBALS['BE_USER'];
    }
}
