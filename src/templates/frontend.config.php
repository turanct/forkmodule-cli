<?php
/**
 * Frontend {{ moduleName }} config
 */
class Frontend{{ moduleNameSafe|capitalize }}Config extends FrontendBaseConfig
{
    /**
     * The default action
     *
     * @var    string
     */
    protected $defaultAction = 'index';

    /**
     * The disabled actions
     *
     * @var    array
     */
    protected $disabledActions = array();
}
