<?php

namespace Backend\Modules\Jelmer\Actions;

use Backend\Core\Engine\Form as BackendForm;
use Backend\Core\Engine\Meta as BackendMeta;
use Backend\Core\Engine\Base\ActionDelete as BackendBaseActionDelete;
use Backend\Core\Engine\Language as BL;
use Backend\Core\Engine\Model as BackendModel;
use Backend\Modules\Jelmer\Engine\Model;

/**
 * Backend Jelmer delete action
 */
class Delete extends BackendBaseActionDelete
{
    /**
     * Execute the action
     */
    public function execute()
    {
        parent::execute();

        $this->id = $this->getParameter('id', 'int');

        Model::delete($this->id);

        // Redirect
        $this->redirect(BackendModel::createURLForAction('index') . '&report=deleted');
    }
}
