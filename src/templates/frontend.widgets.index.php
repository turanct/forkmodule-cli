<?php
/**
 * Frontend {{ moduleName }} {{ widget }} widget
 */
class Frontend{{ moduleName|capitalize }}Widget{{ widget|capitalize }} extends FrontendBaseWidget
{
    /**
     * Execute the extra
     */
    public function execute()
    {
        parent::execute();
        $this->loadTemplate();
        $this->parse();
    }

    /**
     * Parse
     */
    protected function parse()
    {

    }
}
