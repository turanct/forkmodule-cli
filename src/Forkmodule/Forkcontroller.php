<?php

namespace Forkmodule;

/**
 * Forkcontroller class
 */
abstract class Forkcontroller
{
    /**
     * @var \Twig
     */
    protected $twig;

    /**
     * @var Configuration The configuration object
     */
    protected $config;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $safeName;

    /**
     * @var array
     */
    protected $tplVars;

    /**
     * Constructor Method
     *
     * @param Twig          $twig   The template renderer
     * @param Configuration $config The configuration object
     * @param string        $name   The action name
     */
    public function __construct($twig, $config, $name)
    {
        // Assign
        $this->twig = $twig;
        $this->config = $config;
        $this->name = (string) $name;

        // Create a safe action name
        $this->safeName = (string) new SafeName($this->name);

        // Create an array of template variables
        $this->tplVars = array(
            'moduleName' => $this->config->getModuleName(),
            'moduleNameSafe' => $this->config->getModuleNameSafe(),
            'action' => $this->name,
            'actionSafe' => $this->safeName,
            'widget' => $this->name,
            'widgetSafe' => $this->safeName,
            'meta' => $this->config->getMeta(),
        );
    }

    /**
     * Create method
     */
    abstract public function create();
}
