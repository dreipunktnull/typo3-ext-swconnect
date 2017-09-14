<?php

namespace DPN\SwConnect\Controller;

use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

abstract class AbstractController extends ActionController
{
    /**
     * Injects the configuration manager, retrieves the plugin settings from it, saves
     * the plugin settings in $this->settings, merges / overrides the Typoscript settings
     * with FlexForm settings and saves the result in $this->settings['merged']
     *
     * @see http://nerdcenter.de/extbase-typoscript-flexform-settings/
     *
     * @param ConfigurationManagerInterface $configurationManager
     * @return void
     **/
    public function injectConfigurationManager(ConfigurationManagerInterface $configurationManager)
    {
        $this->configurationManager = $configurationManager;

        $settings = $this->configurationManager->getConfiguration(ConfigurationManagerInterface::CONFIGURATION_TYPE_SETTINGS);
        if (isset($settings['override']) && is_array($settings['override'])) {
            $overrides = $settings['override'];
            unset($settings['override']);
            $settings['merged'] = array_merge($settings, $overrides);
        }
        $this->settings = $settings;
    }
}
