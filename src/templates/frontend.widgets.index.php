<?php
/**
 * Frontend {{ moduleName }} {{ widget }} widget
 */
class Frontend{{ moduleNameSafe }}Widget{{ widgetSafe }} extends FrontendBaseWidget
{
    /**
     * Execute the extra
     */
    public function execute()
    {
        parent::execute();
        $this->loadTemplate();
        $this->getData();
        $this->parse();
    }

    /**
     * Load the data, don't forget to validate the incoming data
     */
    protected function getData()
    {

    }

    /**
     * Parse
     */
    protected function parse()
    {

    }
}
