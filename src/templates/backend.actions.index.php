<?php
/**
 * Backend {{ moduleName }} {{ action }} action
 */
{% if action in ['index', 'add', 'edit', 'delete'] %}
class Backend{{ moduleName|capitalize }}{{ action|capitalize }} extends BackendBaseAction{{ action|capitalize }}
{% else %}
class Backend{{ moduleName|capitalize }}{{ action|capitalize }} extends BackendBaseAction
{% endif %}
{
    /**
     * Execute the action
     */
    public function execute()
    {
        parent::execute();

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
     */
    private function loadDataGrids()
    {

    }
{% elseif action in ['add', 'edit'] %}
    /**
     * Load form
     */
    public function loadForm()
    {
        // Create the form
        $this->frm = new BackendForm('{{ action }}');

        // Add fields
    }


    /**
     * Validate form
     */
    public function validateForm()
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


    /**
     * Parse method
     */
    protected function parse()
    {
        parent::parse();
    }
}
