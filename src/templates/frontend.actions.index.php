<?php
/**
 * Frontend {{ moduleName }} {{ action }} action
 */
class Frontend{{ moduleName|capitalize }}{{ action|capitalize }} extends FrontendBaseBlock
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
        $this->getData();
        $this->parse();
    }


    /**
     * Load the data, don't forget to validate the incoming data
     *
     * @return void
     */
    protected function getData()
    {
{% if action == 'detail' %}
        // Get slug
        $this->slug = $this->URL->getParameter(1);
        if ($this->slug === null) {
            $this->redirect(FrontendNavigation::getURL(404));
        }

        // Get item
        $this->item = Frontend{{ moduleName|capitalize }}Model::getByURL($this->slug);
        if (empty($this->item)) {
            $this->redirect(FrontendNavigation::getURL(404));
        }
{% endif %}
    }


    /**
     * Parse the data into the template
     *
     * @return void
     */
    protected function parse()
    {
        // Breadcrumbs
        $this->breadcrumb->addElement(
            SpoonFilter::ucfirst(FL::lbl('{{ moduleName|capitalize }}')),
            FrontendNavigation::getBackendURLForBlock('index', '{{ moduleName }}')
        );
{% if action != 'index' %}
        $this->breadcrumb->addElement(
            SpoonFilter::ucfirst(FL::lbl('{{ action|capitalize }}')),
            FrontendNavigation::getBackendURLForBlock('{{ action }}', '{{ moduleName }}')
        );
{% endif %}
{% if action == 'detail' %}

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

        // Assign item
        $this->tpl->assign('item', $this->item);
{% endif %}
    }
}
