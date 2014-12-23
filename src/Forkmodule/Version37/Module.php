<?php

namespace Forkmodule\Version37;

use Forkmodule\Forkmodule;
use Twig_Environment;
use Forkmodule\Configuration;
use Forkmodule\SafeName;

class Module implements Forkmodule
{
    /**
     * @var \Twig
     */
    protected $twig;

    /**
     * @var Configuration
     */
    protected $config;

    /**
     * Constructor Method
     *
     * @param Twig          $twig   The template renderer
     * @param Configuration $config The configuration object
     */
    public function __construct(Twig_Environment $twig, Configuration $config)
    {
        // Assign
        $this->twig = $twig;
        $this->config = $config;
    }

    /**
     * Create the frontend directories & files
     */
    public function frontend()
    {
        $frontendDirectory = $this->config->getForkDir() . '/frontend/modules/';
        $frontendDirectory .= ucfirst($this->config->getModuleName());

        /**
         * Directories
         */
        mkdir($frontendDirectory);

        $directories = array(
            'Actions',
            'Engine',
            'Layout',
            'Layout/Templates',
            'Layout/Widgets',
            'Widgets',
        );

        foreach ($directories as $directory) {
            mkdir($frontendDirectory . '/' . $directory);
        }


        /**
         * Files
         */
        $content = $this->twig->render(
            'frontend.config.php',
            $this->getTplVars()
        );
        file_put_contents($frontendDirectory . '/Config.php', $content);

        $content = $this->twig->render(
            'frontend.engine.model.php',
            $this->getTplVars()
        );
        file_put_contents($frontendDirectory . '/Engine/Model.php', $content);

        foreach ($this->config->getFrontendActions() as $action) {
            $currentAction = new Frontend\Action($this->twig, $this->config, $action, $frontendDirectory, $this->getTplVars());
            $currentAction->create();
        }

        foreach ($this->config->getFrontendWidgets() as $widget) {
            $currentWidget = new Frontend\Widget($this->twig, $this->config, $widget, $frontendDirectory, $this->getTplVars());
            $currentWidget->create();
        }
    }

    /**
     * Create the backend directories & files
     */
    public function backend()
    {
        $backendDirectory = $this->config->getForkDir() . '/Backend/Modules/';
        $backendDirectory .= ucfirst($this->config->getModuleName());

        /**
         * Directories
         */
        mkdir($backendDirectory);

        $directories = array(
            'Actions',
            'Ajax',
            'Engine',
            'Installer',
            'Installer/Data',
            'Js',
            'Layout',
            'Layout/Templates',
            'Layout/Widgets',
            'Widgets',
        );

        foreach ($directories as $directory) {
            mkdir($backendDirectory . '/' . $directory);
        }


        /**
         * Files
         */
        $content = $this->twig->render(
            'backend.config.php',
            $this->getTplVars()
        );
        file_put_contents($backendDirectory . '/Config.php', $content);

        $content = $this->twig->render(
            'backend.info.xml',
            $this->getTplVars()
        );
        file_put_contents($backendDirectory . '/info.xml', $content);

        $content = $this->twig->render(
            'backend.engine.model.php',
            $this->getTplVars()
        );
        file_put_contents($backendDirectory . '/Engine/Model.php', $content);

        $content = $this->twig->render(
            'backend.installer.installer.php',
            $this->getTplVars()
        );
        file_put_contents($backendDirectory . '/Installer/Installer.php', $content);

        $content = $this->twig->render(
            'backend.installer.data.locale.xml',
            $this->getTplVars()
        );
        file_put_contents($backendDirectory . '/Installer/Data/locale.xml', $content);

        $content = $this->twig->render(
            'backend.installer.data.install.sql',
            $this->getTplVars()
        );
        file_put_contents($backendDirectory . '/Installer/Data/install.sql', $content);

        foreach ($this->config->getBackendActions() as $action) {
            $currentAction = new Backend\Action($this->twig, $this->config, $action, $backendDirectory, $this->getTplVars());
            $currentAction->create();
        }

        foreach ($this->config->getBackendWidgets() as $widget) {
            $currentWidget = new Backend\Widget($this->twig, $this->config, $widget, $backendDirectory, $this->getTplVars());
            $currentWidget->create();
        }
    }

    /**
     * Get safe names for an array of controllers
     *
     * @param array $controllers An array of controller names
     *
     * @return array
     */
    protected function safeNames($controllers)
    {
        foreach ($controllers as $key => $value) {
            $controllers[$key] = array(
                'name' => ucfirst($value),
                'safe' => ucfirst((string) new SafeName($value)),
            );
        }

        return $controllers;
    }

    /**
     * Method to get template variables
     *
     * @return array An array of template variables
     */
    public function getTplVars()
    {
        // Create an array of template variables
        $tplVars = array(
            'moduleName' => ucfirst($this->config->getModuleName()),
            'moduleNameSafe' => ucfirst($this->config->getModuleNameSafe()),
            'backendActions' => $this->safeNames($this->config->getBackendActions()),
            'backendWidgets' => $this->safeNames($this->config->getBackendWidgets()),
            'frontendActions' => $this->safeNames($this->config->getFrontendActions()),
            'frontendWidgets' => $this->safeNames($this->config->getFrontendWidgets()),
            'tags' => $this->config->getTags(),
            'meta' => $this->config->getMeta(),
            'searchable' => $this->config->getSearchable(),
        );

        return $tplVars;
    }
}
