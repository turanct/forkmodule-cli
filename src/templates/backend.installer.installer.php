<?php
/**
 * Backend {{ moduleName }} installer
 */
class {{ moduleName|capitalize }}Installer extends ModuleInstaller
{
    /**
     * Install the module
     */
    public function install()
    {
        // Load install.sql
        $this->importSQL(__DIR__ . '/data/install.sql');


        // Add module
        $this->addModule('{{ moduleName }}');


        // Import locale
        $this->importLocale(__DIR__ . '/data/locale.xml');


        // Set navigation
        $navigationModulesId = $this->setNavigation(null, 'Modules');
        $navigation{{ moduleName|capitalize }}Id = $this->setNavigation($navigationModulesId, '{{ moduleName|capitalize }}', '{{ moduleName }}/index');

{% for action in backendActions %}
        $this->setNavigation($navigation{{ moduleName|capitalize }}Id, '{{ action|capitalize }}', '{{ moduleName }}/{{ action }}');
{% endfor %}

        // Set rights
        $this->setModuleRights(1, '{{ moduleName }}');
{% for action in backendActions %}
        $this->setActionRights(1, '{{ moduleName }}', '{{ action }}');
{% endfor %}


        // Insert backend widgets
        $widgetSettings = array(
            'column' => 'right',
            'position' => 1,
            'hidden' => false,
            'present' => true
        );

{% for widget in backendWidgets %}
        $this->insertDashboardWidget('{{ moduleName }}', '{{ widget }}', $widgetSettings);
{% endfor %}


        // Insert extras
        $Id = $this->insertExtra('{{ moduleName }}', 'block', '{{ moduleName|capitalize }}', null, null, 'N', 1000);

{% for widget in frontendWidgets %}
        $this->insertExtra('{{ moduleName }}', 'widget', '{{ widget|capitalize }}', '{{ widget }}', null, 'N', 1001);
{% endfor %}
    }
}
