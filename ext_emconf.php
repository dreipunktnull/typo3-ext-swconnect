<?php

$EM_CONF[$_EXTKEY] = [
    'title' => 'Shopware Connector',
    'description' => 'TYPO3 CMS Shopware 5 Connector',
    'category' => 'fe',
    'version' => '0.0.1',
    'state' => 'stable',
    'author' => 'Cedric Ziel',
    'author_email' => 'ziel@dreipunktnull.com',
    'author_company' => 'dreipunktnull',
    'constraints' =>
        [
            'depends' =>
                [
                    'typo3' => '8.7.0-8.7.99',
                    'php' => '7.0.0-0.0.0',
                    'multilevel_cache' => '1.0.0-1.99.99',
                ],
        ],
];
