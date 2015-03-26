<?php

namespace Frontend\Modules\Jelmer\Widgets;

use Frontend\Core\Engine\Base\Widget as FrontendBaseWidget;

/**
 * Frontend Jelmer widget widget
 */
class Widget extends FrontendBaseWidget
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
