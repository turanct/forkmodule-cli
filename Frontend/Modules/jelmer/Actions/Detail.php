<?php

namespace Frontend\Modules\Jelmer\Actions;

use Common\Form;
use Frontend\Core\Engine\Base\Block as FrontendBaseBlock;
use Frontend\Core\Engine\Language as FL;
use Frontend\Core\Engine\Model as FrontendModel;
use Frontend\Core\Engine\Navigation as FrontendNavigation;
use Frontend\Modules\Jelmer\Engine\Model;

/**
 * Frontend Jelmer detail action
 */
class Detail extends FrontendBaseBlock
{
    /**
     * @var string Slug of current item
     */
    protected $slug;

    /**
     * @var array Current item
     */
    protected $item;

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
        // Get slug
        $this->slug = $this->URL->getParameter(1);
        if ($this->slug === null) {
            $this->redirect(FrontendNavigation::getURL(404));
        }

        // Get item
        $this->item = Model::getByURL($this->slug);
        if (empty($this->item)) {
            $this->redirect(FrontendNavigation::getURL(404));
        }
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
        $this->breadcrumb->addElement(
            \SpoonFilter::ucfirst(FL::lbl('Detail')),
            FrontendNavigation::getURLForBlock('Jelmer', 'detail')
        );

        // SEO
        $this->header->setPageTitle(
            $this->item['meta_title'],
            ($this->item['meta_title_overwrite'] == 'Y')
        );
        $this->header->addMetaDescription(
            $this->item['meta_description'],
            ($this->item['meta_description_overwrite'] == 'Y')
        );
        $this->header->addMetaKeywords(
            $this->item['meta_keywords'],
            ($this->item['meta_keywords_overwrite'] == 'Y')
        );

        // Open Graph-data: add images from content
        $this->header->extractOpenGraphImages($this->item['meta_description']);

        // Open Graph-data: add additional OpenGraph data
        $this->header->addOpenGraphData('title', $this->item['title'], true);
        $this->header->addOpenGraphData('type', 'article', true);
        $this->header->addOpenGraphData(
            'url',
            SITE_URL . FrontendNavigation::getURLForBlock('Jelmer', 'detail') . '/' . $this->item['url'],
            true
        );
        $this->header->addOpenGraphData(
            'site_name',
            FrontendModel::getModuleSetting('core', 'site_title_' . FRONTEND_LANGUAGE, SITE_DEFAULT_TITLE),
            true
        );
        $this->header->addOpenGraphData(
            'description',
            ($this->item['meta_description_overwrite'] == 'Y') ? $this->item['meta_description'] : $this->item['title'],
            true
        );

        // Assign item
        $this->tpl->assign('item', $this->item);
    }
}
