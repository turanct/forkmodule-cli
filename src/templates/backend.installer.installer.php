<?php
/**
 * Backend {{ moduleName }} installer
 */
class {{ moduleNameSafe }}Installer extends ModuleInstaller
{
    /**
     * Install the module
     *
     * @return void
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
        $navigation{{ moduleNameSafe }}Id = $this->setNavigation($navigationModulesId, '{{ moduleNameSafe }}', '{{ moduleName }}/index');

{% for action in backendActions %}
{% if action == 'index' %}
        $this->setNavigation(
            $navigation{{ moduleNameSafe }}Id,
            '{{ action|capitalize }}',
            '{{ moduleName }}/{{ action }}',
            array(
{% for otheraction in backendActions %}
{% if otheraction != 'index' %}
                '{{ moduleName }}/{{ otheraction }}',
{% endif %}
{% endfor %}
            )
        );
{% elseif action not in ['index', 'add', 'edit', 'delete'] %}
        $this->setNavigation($navigation{{ moduleNameSafe }}Id, '{{ action|capitalize }}', '{{ moduleName }}/{{ action }}');
{% endif %}
{% endfor %}

        // Set rights for admin
        $this->setModuleRights(1, '{{ moduleName }}');
{% for action in backendActions %}
        $this->setActionRights(1, '{{ moduleName }}', '{{ action }}');
{% endfor %}
        // Set rights for users
        $this->setModuleRights(2, '{{ moduleName }}');
{% for action in backendActions %}
        $this->setActionRights(2, '{{ moduleName }}', '{{ action }}');
{% endfor %}

{% if backendWidgets %}

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

{% endif %}

        // Insert extras
        $Id = $this->insertExtra('{{ moduleName }}', 'block', '{{ moduleNameSafe }}', null, null, 'N', 1000);

{% for widget in frontendWidgets %}
        $this->insertExtra('{{ moduleName }}', 'widget', '{{ widget|capitalize }}', '{{ widget }}', null, 'N', 1001);
{% endfor %}
    }
}
