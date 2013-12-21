<?php
/**
 * Frontend {{ moduleName }} {{ widget }} widget
 */
class Frontend{{ moduleName|capitalize }}Widget{{ widget|capitalize }} extends FrontendBaseWidget
{
    /**
     * Execute the extra
     *
     * @return void
     */
    public function execute()
    {
        parent::execute();
        $this->loadTemplate();
        $this->parse();
    }

    /**
     * Parse
     *
     * @return void
     */
    protected function parse()
    {

    }
}
