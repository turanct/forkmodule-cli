<?php
namespace Backend\Modules\Jelmer\Widgets;

use Backend\Core\Engine\Base\Widget as BackendBaseWidget;

/**
 * Backend Jelmer test widget
 */
class Test extends BackendBaseWidget
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
