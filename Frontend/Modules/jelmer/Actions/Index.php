<?php

namespace Frontend\Modules\Jelmer\Actions;

use Common\Form;
use Frontend\Core\Engine\Base\Block as FrontendBaseBlock;
use Frontend\Core\Engine\Language as FL;
use Frontend\Core\Engine\Model as FrontendModel;
use Frontend\Core\Engine\Navigation as FrontendNavigation;
use Frontend\Modules\Jelmer\Engine\Model;

/**
 * Frontend Jelmer index action
 */
class Index extends FrontendBaseBlock
{
    /**
     * @var array All items
     */
    protected $items;

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
        $this->items = Model::getAll();
    }

    /**
     * Parse the data into the template
     */
    protected function parse()
    {
        // Breadcrumbs
        $this->breadcrumb->addElement(
            \SpoonFilter::ucfirst(FL::lbl('Jelmer')),
            FrontendNavigation::getURLForBlock('Jelmer', 'Index')
        );

        // Assign items
        $this->tpl->assign('items', $this->items);
    }
}
