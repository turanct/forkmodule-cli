<?php

namespace Backend\Modules\Jelmer\Installer;

use Backend\Core\Installer\ModuleInstaller;

/**
 * Backend Jelmer installer
 */
class Installer extends ModuleInstaller
{
    /**
     * Install the module
     */
    public function install()
    {
        // Load install.sql
        $this->importSQL(__DIR__ . '/Data/install.sql');

        // Add module
        $this->addModule('Jelmer');

        // Import locale
        $this->importLocale(__DIR__ . '/Data/locale.xml');

        // Set navigation
        $navigationModulesId = $this->setNavigation(null, 'Modules');
        $navigationJelmerId = $this->setNavigation($navigationModulesId, 'Jelmer', 'jelmer/index');

        $this->setNavigation(
            $navigationJelmerId,
            'Overview',
            'jelmer/index',
            array(
                'jelmer/add',
                'jelmer/edit',
                'jelmer/delete',
            )
        );
        $navigationSettingsId = $this->setNavigation(null, 'Settings');
        $navigationModulesId = $this->setNavigation($navigationSettingsId, 'Modules');
        $this->setNavigation($navigationModulesId, 'Jelmer', 'jelmer/settings');
        $this->setNavigation($navigationJelmerId, 'dummy', 'jelmer/dummy');

        // Set rights for admin
        $this->setModuleRights(1, 'Jelmer');
        $this->setActionRights(1, 'Jelmer', 'Index');
        $this->setActionRights(1, 'Jelmer', 'Add');
        $this->setActionRights(1, 'Jelmer', 'Edit');
        $this->setActionRights(1, 'Jelmer', 'Delete');
        $this->setActionRights(1, 'Jelmer', 'Settings');
        $this->setActionRights(1, 'Jelmer', 'Dummy');
        // Set rights for users
        $this->setModuleRights(2, 'Jelmer');
        $this->setActionRights(2, 'Jelmer', 'Index');
        $this->setActionRights(2, 'Jelmer', 'Add');
        $this->setActionRights(2, 'Jelmer', 'Edit');
        $this->setActionRights(2, 'Jelmer', 'Delete');
        $this->setActionRights(2, 'Jelmer', 'Settings');
        $this->setActionRights(2, 'Jelmer', 'Dummy');


        // Insert backend widgets
        $widgetSettings = array(
            'column' => 'right',
            'position' => 1,
            'hidden' => false,
            'present' => true
        );

        $this->insertDashboardWidget('Jelmer', 'Test', $widgetSettings);

        // Insert extras
        $id = $this->insertExtra('Jelmer', 'block', 'Jelmer', null, null, 'N', 1000);

        $this->insertExtra('Jelmer', 'widget', 'Widget', 'Widget', null, 'N', 1001);
    }
}
