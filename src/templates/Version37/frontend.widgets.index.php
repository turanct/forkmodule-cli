<?php

namespace Frontend\Modules\{{ moduleName }}\Widgets;

use Frontend\Core\Engine\Base\Widget as FrontendBaseWidget;

/**
 * Frontend {{ moduleName }} {{ widget }} widget
 */
class {{ widgetSafe }} extends FrontendBaseWidget
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
