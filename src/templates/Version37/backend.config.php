<?php

namespace Backend\Modules\{{ moduleNameSafe }};

use Backend\Core\Engine\Base\Config as BackendBaseConfig;

/**
 * Backend {{ moduleName }} config
 */
class Config extends BackendBaseConfig
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
