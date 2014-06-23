<?php
namespace Forkmodule;

/**
 * Forkmodule class
 */
class Forkmodule
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
    public function __construct($twig, $config)
    {
        // Assign
        $this->twig = $twig;
        $this->config = $config;

        // Create the directory structure
        $this->frontend();
        $this->backend();
    }

    /**
     * Create the frontend directories & files
     */
    protected function frontend()
    {
        /**
         * Directories
         */
        mkdir($this->config->getModuleDirFrontend());

        $directories = array(
            'actions',
            'engine',
            'layout',
            'layout/templates',
            'layout/widgets',
            'widgets',
        );

        foreach ($directories as $directory) {
            mkdir($this->config->getModuleDirFrontend() . '/' . $directory);
        }


        /**
         * Files
         */
        $content = $this->twig->render(
            'frontend.config.php',
            $this->getTplVars()
        );
        file_put_contents($this->config->getModuleDirFrontend() . '/config.php', $content);

        $content = $this->twig->render(
            'frontend.engine.model.php',
            $this->getTplVars()
        );
        file_put_contents($this->config->getModuleDirFrontend() . '/engine/model.php', $content);

        foreach ($this->config->getFrontendActions() as $action) {
            $currentAction = new Frontend\Action($this->twig, $this->config, $action);
            $currentAction->create();
        }

        foreach ($this->config->getFrontendWidgets() as $widget) {
            $currentWidget = new Frontend\Widget($this->twig, $this->config, $widget);
            $currentWidget->create();
        }
    }

    /**
     * Create the backend directories & files
     */
    protected function backend()
    {
        /**
         * Directories
         */
        mkdir($this->config->getModuleDirBackend());

        $directories = array(
            'actions',
            'ajax',
            'engine',
            'installer',
            'installer/data',
            'js',
            'layout',
            'layout/templates',
            'layout/widgets',
            'widgets',
        );

        foreach ($directories as $directory) {
            mkdir($this->config->getModuleDirBackend() . '/' . $directory);
        }


        /**
         * Files
         */
        $content = $this->twig->render(
            'backend.config.php',
            $this->getTplVars()
        );
        file_put_contents($this->config->getModuleDirBackend() . '/config.php', $content);

        $content = $this->twig->render(
            'backend.engine.model.php',
            $this->getTplVars()
        );
        file_put_contents($this->config->getModuleDirBackend() . '/engine/model.php', $content);

        $content = $this->twig->render(
            'backend.installer.installer.php',
            $this->getTplVars()
        );
        file_put_contents($this->config->getModuleDirBackend() . '/installer/installer.php', $content);

        $content = $this->twig->render(
            'backend.installer.data.locale.xml',
            $this->getTplVars()
        );
        file_put_contents($this->config->getModuleDirBackend() . '/installer/data/locale.xml', $content);

        $content = $this->twig->render(
            'backend.installer.data.install.sql',
            $this->getTplVars()
        );
        file_put_contents($this->config->getModuleDirBackend() . '/installer/data/install.sql', $content);

        foreach ($this->config->getBackendActions() as $action) {
            $currentAction = new Backend\Action($this->twig, $this->config, $action);
            $currentAction->create();
        }

        foreach ($this->config->getBackendWidgets() as $widget) {
            $currentWidget = new Backend\Widget($this->twig, $this->config, $action);
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
                'name' => $value,
                'safe' => (string) new SafeName($value),
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
            'moduleName' => $this->config->getModuleName(),
            'moduleNameSafe' => $this->config->getModuleNameSafe(),
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
