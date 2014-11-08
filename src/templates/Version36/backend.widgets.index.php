<?php
/**
 * Backend {{ moduleName }} {{ widget }} widget
 */
class Backend{{ moduleNameSafe }}Widget{{ widgetSafe }} extends BackendBaseWidget
{
    /**
     * Execute the widget
     */
    public function execute()
    {
        $this->setColumn('middle');
        $this->setPosition(0);
        $this->loadData();
        $this->parse();
        $this->display();
    }

    /**
     * Load the data
     */
    protected function loadData()
    {

    }

    /**
     * Parse into template
     */
    protected function parse()
    {

    }
}
