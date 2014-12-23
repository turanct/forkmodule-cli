<?php

namespace Forkmodule;

/**
 * Configuration class
 *
 * This class will keep track of the configuration for our module
 */
class Configuration
{
    /**
     * @var string The Fork directory
     */
    protected $forkDir;

    /**
     * @var string The module name
     */
    protected $moduleName;

    /**
     * @var string The module safe name
     */
    protected $moduleNameSafe;

    /**
     * @var bool Should the module implement Meta?
     */
    protected $meta;

    /**
     * @var bool Should the module implement Tags?
     */
    protected $tags;

    /**
     * @var bool Should the module implement Search?
     */
    protected $searchable;

    /**
     * @var array An array of frontend actions
     */
    protected $frontendActions;

    /**
     * @var array An array of frontend widgets
     */
    protected $frontendWidgets;

    /**
     * @var array An array of backend actions
     */
    protected $backendActions;

    /**
     * @var array An array of backend widgts
     */
    protected $backendWidgets;

    /**
     * Constructor method
     *
     * @param string $forkDir         The Fork directory
     * @param string $moduleName      The module name
     * @param string $moduleNameSafe  The module safe name
     * @param bool   $meta            Should the module implement Meta?
     * @param bool   $tags            Should the module implement Tags?
     * @param bool   $searchable      Should the module implement Search?
     * @param array  $frontendActions An array of frontend actions
     * @param array  $frontendWidgets An array of frontend widgets
     * @param array  $backendActions  An array of backend actions
     * @param array  $backendWidgets  An array of backend widgts
     */
    public function __construct(
        $forkDir,
        $moduleName,
        $moduleNameSafe,
        $meta,
        $tags,
        $searchable,
        $frontendActions,
        $frontendWidgets,
        $backendActions,
        $backendWidgets
    ) {
        $this->forkDir = $forkDir;
        $this->moduleName = $moduleName;
        $this->moduleNameSafe = $moduleNameSafe;
        $this->meta = $meta;
        $this->tags = $tags;
        $this->searchable = $searchable;
        $this->frontendActions = $frontendActions;
        $this->frontendWidgets = $frontendWidgets;
        $this->backendActions = $backendActions;
        $this->backendWidgets = $backendWidgets;
    }

    /**
     * Getter for forkDir
     *
     * @return string The Fork directory
     */
    public function getForkDir()
    {
        return $this->forkDir;
    }

    /**
     * Getter for moduleName
     *
     * @return string The module name
     */
    public function getModuleName()
    {
        return $this->moduleName;
    }

    /**
     * Getter for moduleNameSafe
     *
     * @return string The module safe name
     */
    public function getModuleNameSafe()
    {
        return $this->moduleNameSafe;
    }

    /**
     * Getter for meta
     *
     * @return bool Should the module implement Meta?
     */
    public function getMeta()
    {
        return $this->meta;
    }

    /**
     * Getter for tags
     *
     * @return bool Should the module implement Tags?
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * Getter for searchable
     *
     * @return bool Should the module implement Search?
     */
    public function getSearchable()
    {
        return $this->searchable;
    }

    /**
     * Getter for frontend actions
     *
     * @return array An array of frontend actions
     */
    public function getFrontendActions()
    {
        return $this->frontendActions;
    }

    /**
     * Getter for frontend widgets
     *
     * @return array An array of frontend widgets
     */
    public function getFrontendWidgets()
    {
        return $this->frontendWidgets;
    }

    /**
     * Getter for backend actions
     *
     * @return array An array of backend actions
     */
    public function getBackendActions()
    {
        return $this->backendActions;
    }

    /**
     * Getter for backend widgts
     *
     * @return array An array of backend widgts
     */
    public function getBackendWidgets()
    {
        return $this->backendWidgets;
    }
}
