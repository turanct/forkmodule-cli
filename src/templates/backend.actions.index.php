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

        $this->loadDataGrids();
        $this->parse();
        $this->display();
    }


    /**
     * Loads the datagrids
     */
    private function loadDataGrids()
    {

    }

    /**
     * Parse method
     */
    protected function parse()
    {
        parent::parse();
    }
}
