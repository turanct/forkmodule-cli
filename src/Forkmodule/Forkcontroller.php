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
     * @var string
     */
    protected $moduleDir;

    /**
     * @var array
     */
    protected $tplVars;

    /**
     * Constructor Method
     *
     * @param Twig          $twig      The template renderer
     * @param Configuration $config    The configuration object
     * @param string        $name      The action name
     * @param string        $moduleDir The module directory
     * @param array         $tplVars   The template variables
     */
    public function __construct($twig, $config, $name, $moduleDir, array $tplVars)
    {
        // Assign
        $this->twig = $twig;
        $this->config = $config;
        $this->name = (string) $name;
        $this->moduleDir = (string) $moduleDir;

        // Create a safe action name
        $this->safeName = (string) new SafeName($this->name);

        // Create an array of template variables
        $this->tplVars = $tplVars;
        $this->tplVars['action'] = $this->name;
        $this->tplVars['actionSafe'] = $this->safeName;
        $this->tplVars['widget'] = $this->name;
        $this->tplVars['widgetSafe'] = $this->safeName;
    }

    /**
     * Create method
     */
    abstract public function create();
}
