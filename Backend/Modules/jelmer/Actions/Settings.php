<?php

namespace Backend\Modules\Jelmer\Actions;

use Backend\Core\Engine\Base\Action as BackendBaseAction;
use Backend\Core\Engine\Form as BackendForm;
use Backend\Core\Engine\Language as BL;
use Backend\Core\Engine\Model as BackendModel;
use Backend\Modules\Jelmer\Engine\Model;

/**
 * Backend Jelmer settings action
 */
class Settings extends BackendBaseAction
{
    /**
     * Execute the action
     */
    public function execute()
    {
        parent::execute();


        $this->parse();
        $this->display();
    }

    /**
     * Parse method
     */
    protected function parse()
    {
        parent::parse();
    }
}
