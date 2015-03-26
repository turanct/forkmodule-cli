<?php

namespace Backend\Modules\Jelmer;

use Backend\Core\Engine\Base\Config as BackendBaseConfig;

/**
 * Backend Jelmer config
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
