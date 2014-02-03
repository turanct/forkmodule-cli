<?php
/**
 * Backend {{ moduleName }} {{ action }} action
 */
{% if action in ['index', 'add', 'edit', 'delete'] %}
class Backend{{ moduleNameSafe }}{{ action|capitalize }} extends BackendBaseAction{{ action|capitalize }}
{% else %}
class Backend{{ moduleNameSafe }}{{ action|capitalize }} extends BackendBaseAction
{% endif %}
{
    /**
     * Execute the action
     *
     * @return void
     */
    public function execute()
    {
        parent::execute();

{% if action in ['edit', 'delete'] %}
        $this->id = $this->getParameter('id', 'int');
{% endif %}

{% if action == 'index' %}
        $this->loadDataGrids();
{% elseif action in ['add', 'edit'] %}
        $this->loadForm();
        $this->validateForm();
{% endif %}
        $this->parse();
        $this->display();
    }
{% if action == 'index' %}


    /**
     * Loads the datagrids
     *
     * @return void
     */
    protected function loadDataGrids()
    {
        // Create datagrid
        $this->dataGrid = new BackendDataGridDB($query, $params);

        // Add buttons
        $this->dataGrid->addColumn(
            'edit',
            null,
            BL::lbl('Edit'),
            BackendModel::createURLForAction('edit') . '&id=[id]',
            BL::lbl('Edit')
        );
    }
{% elseif action in ['add', 'edit'] %}


    /**
     * Load form
     *
     * @return void
     */
    protected function loadForm()
    {
        // Create the form
        $this->frm = new BackendForm('{{ action }}');

        // Add fields

        // Meta
{% if action == 'add' %}
        $this->meta = new BackendMeta($this->frm, null, 'title', true);
{% elseif action == 'edit' %}
        $this->meta = new BackendMeta($this->frm, $this->record['meta_id'], 'title', true);

        // Set callback for generating a unique URL
        $this->meta->setUrlCallback('Backend{{ moduleNameSafe }}Model', 'getURL', array($this->record['id']));
{% endif %}
    }


    /**
     * Validate form
     *
     * @return void
     */
    protected function validateForm()
    {
        // Submitted?
        if ($this->frm->isSubmitted()) {
            // Check fields

            // Correct?
            if ($this->frm->isCorrect()) {
                // Build item

                // Save

                // Redirect
                $this->redirect(BackendModel::createURLForAction('index') . '&report={{ action }}ed');
            }
        }
    }
{% endif %}
{% if action != 'delete' %}


    /**
     * Parse method
     *
     * @return void
     */
    protected function parse()
    {
        parent::parse();
{% if action == 'index' %}
        $this->tpl->assign('dataGrid', ($this->dataGrid->getNumResults() != 0) ? $this->dataGrid->getContent() : false);
{% elseif action in ['add', 'edit'] %}
        // Get url
        $url = BackendModel::getURLForBlock($this->URL->getModule(), 'detail');
        $url404 = BackendModel::getURL(404);

        // Parse additional variables
        if ($url404 != $url) {
            $this->tpl->assign('detailURL', SITE_URL . $url);
        }
{% endif %}
    }
{% endif %}
}
