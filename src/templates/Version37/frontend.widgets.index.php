<?php

namespace Frontend\Modules\{{ moduleName }}\Widgets;

use Frontend\Core\Engine\Base\Widget as FrontendBaseWidget;

/**
 * Frontend {{ moduleName }} {{ widget }} widget
 */
class {{ widgetSafe }} extends FrontendBaseWidget
{
    public function execute()
    {
        parent::execute();
        $this->loadTemplate();
        $this->getData();
        $this->parse();
    }

    protected function getData()
    {

    }

    protected function parse()
    {

    }
}
