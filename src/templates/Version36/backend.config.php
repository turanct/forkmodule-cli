<?php
/**
 * Backend {{ moduleName }} config
 */
class Backend{{ moduleNameSafe }}Config extends BackendBaseConfig
{
    /**
     * The default action
     *
     * @var    string
     */
    protected $defaultAction = 'Index';

    /**
     * The disabled actions
     *
     * @var    array
     */
    protected $disabledActions = array();
}
