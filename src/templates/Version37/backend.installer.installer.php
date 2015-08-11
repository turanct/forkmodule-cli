<?php

namespace Backend\Modules\{{ moduleNameSafe }}\Installer;

use Backend\Core\Installer\ModuleInstaller;

/**
 * Backend {{ moduleName }} installer
 */
class Installer extends ModuleInstaller
{
    /**
     * Install the module
     */
    public function install()
    {
        // load install.sql
        $this->importSQL(__DIR__ . '/Data/install.sql');

        // add module
        $this->addModule('{{ moduleName }}');

        // import locale
        $this->importLocale(__DIR__ . '/Data/locale.xml');

        // set navigation
        $navigationModulesId = $this->setNavigation(null, 'Modules');
        $navigation{{ moduleNameSafe }}Id = $this->setNavigation($navigationModulesId, '{{ moduleNameSafe }}', '{{ moduleName|lower }}/index');

{% for action in backendActions %}
{% if action.name == 'Index' %}
        $this->setNavigation(
            $navigation{{ moduleNameSafe }}Id,
            'Overview',
            '{{ moduleName|lower }}/{{ action.name|lower }}',
            array(
{% for otheraction in backendActions %}
{% if otheraction.name in ['Add', 'Edit', 'Delete'] %}
                '{{ moduleName|lower }}/{{ otheraction.name|lower }}',
{% endif %}
{% endfor %}
            )
        );
{% elseif action.name not in ['Index', 'Add', 'Edit', 'Delete', 'Settings'] %}
        $this->setNavigation($navigation{{ moduleNameSafe }}Id, '{{ action.safe|lower }}', '{{ moduleName|lower }}/{{ action.name|lower }}');
{% elseif action.name == 'Settings' %}
        $navigationSettingsId = $this->setNavigation(null, 'Settings');
        $navigationModulesId = $this->setNavigation($navigationSettingsId, 'Modules');
        $this->setNavigation($navigationModulesId, '{{ moduleNameSafe }}', '{{ moduleName|lower }}/settings');
{% endif %}
{% endfor %}

        // set rights for admin
        $this->setModuleRights(1, '{{ moduleName }}');
{% for action in backendActions %}
        $this->setActionRights(1, '{{ moduleName }}', '{{ action.name }}');
{% endfor %}
        // set rights for users
        $this->setModuleRights(2, '{{ moduleName }}');
{% for action in backendActions %}
        $this->setActionRights(2, '{{ moduleName }}', '{{ action.name }}');
{% endfor %}

{% if backendWidgets %}

        // insert backend widgets
        $widgetSettings = array(
            'column' => 'right',
            'position' => 1,
            'hidden' => false,
            'present' => true
        );

{% for widget in backendWidgets %}
        $this->insertDashboardWidget('{{ moduleName }}', '{{ widget.name }}', $widgetSettings);
{% endfor %}

{% endif %}
{% if frontendActions or frontendWidgets %}
        // insert extras
        $id = $this->insertExtra('{{ moduleName }}', 'block', '{{ moduleNameSafe }}', null, null, 'N', 1000);

{% endif %}
{% for widget in frontendWidgets %}
        $this->insertExtra('{{ moduleName }}', 'widget', '{{ widget.safe }}', '{{ widget.name }}', null, 'N', 1001);
{% endfor %}
    }
}
