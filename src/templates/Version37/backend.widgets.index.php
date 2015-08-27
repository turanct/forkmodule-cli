<?php
namespace Backend\Modules\{{ moduleNameSafe }}\Widgets;

use Backend\Core\Engine\Base\Widget;

/**
 * Backend {{ moduleName }} {{ widget }} widget
 */
class {{ widgetSafe }} extends Widget
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
