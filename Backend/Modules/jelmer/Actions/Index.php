<?php

namespace Backend\Modules\Jelmer\Actions;

use Backend\Core\Engine\Base\ActionIndex as BackendBaseActionIndex;
use Backend\Core\Engine\DataGridArray as BackendDataGridArray;
use Backend\Core\Engine\DataGridFunctions as BackendDataGridFunctions;
use Backend\Core\Engine\Language as BL;
use Backend\Core\Engine\Model as BackendModel;
use Backend\Modules\Jelmer\Engine\Model;

/**
 * Backend Jelmer index action
 */
class Index extends BackendBaseActionIndex
{
    /**
     * Execute the action
     */
    public function execute()
    {
        parent::execute();

        $this->loadDataGrids();

        $this->parse();
        $this->display();
    }

    /**
     * Loads the datagrids
     */
    protected function loadDataGrids()
    {
        // Create datagrid
        $this->dataGrid = new BackendDataGridArray(Model::getAll());

        // Add buttons
        $editURL = BackendModel::createURLForAction('edit') . '&id=[id]';
        $this->dataGrid->addColumn(
            'edit',
            null,
            BL::lbl('Edit'),
            $editURL,
            BL::lbl('Edit')
        );
        $this->dataGrid->setColumnURL('title', $editURL);

        // Hide unnecessary columns
        $hiddenColumns = array('meta_id');
        $this->dataGrid->setColumnsHidden($hiddenColumns);
    }

    /**
     * Parse method
     */
    protected function parse()
    {
        parent::parse();
        $this->tpl->assign('dataGrid', ($this->dataGrid->getNumResults() != 0) ? $this->dataGrid->getContent() : false);
    }
}
