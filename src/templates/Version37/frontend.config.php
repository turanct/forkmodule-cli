<?php

namespace Frontend\Modules\{{ moduleNameSafe }};

use Frontend\Core\Engine\Base\Config as BaseConfig;

/**
 * Frontend {{ moduleName }} config
 */
class Config extends BaseConfig
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
