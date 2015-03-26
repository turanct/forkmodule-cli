<?php

namespace Frontend\Modules\Jelmer;

use Frontend\Core\Engine\Base\Config as FrontendBaseConfig;

/**
 * Frontend Jelmer config
 */
class Config extends FrontendBaseConfig
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
