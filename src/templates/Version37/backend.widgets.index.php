<?php
namespace Backend\Modules\{{ moduleNameSafe }}\Widgets;

use Backend\Core\Engine\Base\Widget as BackendBaseWidget;

/**
 * Backend {{ moduleName }} {{ widget }} widget
 */
class {{ widgetSafe }} extends BackendBaseWidget
{
    public function execute()
    {
        $this->setColumn('middle');
        $this->setPosition(0);
        $this->loadData();
        $this->parse();
        $this->display();
    }

    protected function loadData()
    {

    }

    protected function parse()
    {

    }
}
