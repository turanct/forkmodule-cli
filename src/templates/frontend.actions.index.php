<?php
/**
 * Frontend {{ moduleName }} {{ action }} action
 */
class Frontend{{ moduleNameSafe }}{{ actionSafe }} extends FrontendBaseBlock
{
{% if action == 'detail' %}
    /**
     * Slug of current item
     *
     * @var string
     */
    protected $slug;

    /**
     * Current item
     *
     * @var array
     */
    protected $item;

{% endif %}
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
{% if action == 'detail' %}
        // Get slug
        $this->slug = $this->URL->getParameter(1);
        if ($this->slug === null) {
            $this->redirect(FrontendNavigation::getURL(404));
        }

        // Get item
{% if meta %}
        $this->item = Frontend{{ moduleNameSafe }}Model::getByURL($this->slug);
{% else %}
        $this->item = Frontend{{ moduleNameSafe }}Model::get($this->slug);
{% endif %}
        if (empty($this->item)) {
            $this->redirect(FrontendNavigation::getURL(404));
        }
{% endif %}
    }

    /**
     * Parse the data into the template
     */
    protected function parse()
    {
        // Breadcrumbs
        $this->breadcrumb->addElement(
            SpoonFilter::ucfirst(FL::lbl('{{ moduleNameSafe }}')),
            FrontendNavigation::getURLForBlock('{{ moduleName }}', 'index')
        );
{% if action != 'index' %}
        $this->breadcrumb->addElement(
            SpoonFilter::ucfirst(FL::lbl('{{ actionSafe }}')),
            FrontendNavigation::getURLForBlock('{{ moduleName }}', '{{ action }}')
        );
{% endif %}
{% if action == 'detail' %}
{% if meta %}

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
            SITE_URL . FrontendNavigation::getURLForBlock('{{ moduleName }}', 'detail') . '/' . $this->item['url'],
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
{% endif %}

        // Assign item
        $this->tpl->assign('item', $this->item);
{% endif %}
    }
}
