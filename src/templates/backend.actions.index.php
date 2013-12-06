<?php
/**
 * Backend {{ moduleName }} {{ action }} action
 */
class Backend{{ moduleName|capitalize }}{{ action|capitalize }} extends BackendBaseAction
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
