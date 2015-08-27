<?php

namespace Backend\Modules\{{ moduleNameSafe }}\Actions;

{% if action in ['add', 'edit', 'delete'] %}
use Backend\Core\Engine\Form;
use Backend\Core\Engine\Meta;
{% endif %}
{% if action in ['index', 'add', 'edit', 'delete'] %}
use Backend\Core\Engine\Base\Action{{ actionSafe }};
{% else %}
use Backend\Core\Engine\Base\Action;
use Backend\Core\Engine\Form;
{% endif %}
{% if action in ['index'] %}
use Backend\Core\Engine\DataGridArray;
use Backend\Core\Engine\DataGridFunctions;
{% endif %}
use Backend\Core\Engine\Language;
use Backend\Core\Engine\Model as BackendModel;
use Backend\Modules\{{ moduleNameSafe }}\Engine\Model;

/**
 * Backend {{ moduleName }} {{ action }} action
 */
{% if action in ['index', 'add', 'edit', 'delete'] %}
class {{ actionSafe }} extends Action{{ actionSafe }}
{% else %}
class {{ actionSafe }} extends Action
{% endif %}
{
    public function execute()
    {
        parent::execute();
{% if action in ['edit', 'delete'] %}

        $this->id = $this->getParameter('id', 'int');
{% endif %}
{% if action == 'delete' %}
        $item = Model::get($this->id);
        if (empty($item)) {
            $this->redirect(BackendModel::createURLForAction('Index') . '&report=non-existing');
        }

        Model::delete($this->id);
{% endif %}

{% if action == 'index' %}
        $this->loadDataGrids();
{% elseif action in ['add', 'edit'] %}
{% if action == 'edit' %}
        $this->getData();
{% endif %}
        $this->handleForm();
{% endif %}
{% if action != 'delete' %}

        $this->parse();
        $this->display();
{% else %}
        // redirect
        $this->redirect(BackendModel::createURLForAction('Index') . '&report={{ action }}{% if action == 'delete' %}d{% endif %}');
{% endif %}
    }
{% if action == 'index' %}

    protected function loadDataGrids()
    {
        // create datagrid
        $this->dataGrid = new DataGridArray(Model::getAll());

        // add buttons
        $editURL = BackendModel::createURLForAction('Edit') . '&id=[id]';
        $this->dataGrid->addColumn(
            'edit',
            null,
            Language::lbl('Edit'),
            $editURL,
            Language::lbl('Edit')
        );
{% if meta %}
        $this->dataGrid->setColumnURL('title', $editURL);
{% endif %}

        // hide unnecessary columns
        $hiddenColumns = array({% if meta %}'meta_id'{% endif %});
        $this->dataGrid->setColumnsHidden($hiddenColumns);
    }
{% elseif action in ['add', 'edit'] %}
{% if action == 'edit' %}

    protected function getData()
    {
        $this->record = Model::get($this->id);

        // validate
        if (empty($this->record)) {
            $this->redirect(BackendModel::createURLForAction('Index') . '&error=non-existing');
        }
    }
{% endif %}

    protected function handleForm()
    {
        // create the form
        $form = new Form('{{ action }}');

        // add fields
{% if meta %}
        $fieldTitle = $form->addText('title', {% if action == 'edit' %}$this->record['title']{% else %}null{% endif %}, 255, 'inputText title', 'inputTextError title');
{% endif %}
{% if tags and action in ['add', 'edit'] %}
        $fieldTags = $form->addText('tags', {% if action == 'edit' %}$this->record['tags']{% else %}null{% endif %}, null, 'inputText tagBox', 'inputTextError tagBox');
{% endif %}
{% if meta %}

        // meta
{% if action == 'add' %}
        $meta = new Meta($form, null, 'title', true);
{% elseif action == 'edit' %}
        $meta = new Meta($form, $this->record['meta_id'], 'title', true);

        // set callback for generating a unique URL
        $meta->setUrlCallback('Backend\Modules\{{ moduleNameSafe }}\Engine\Model', 'getURL', array($this->record['id']));
{% endif %}
{% endif %}

        // submitted?
        if ($form->isSubmitted()) {
            // check fields
{% if meta %}
            $meta->validate();
            $fieldTitle->isFilled(Language::err('FieldIsRequired'));
{% endif %}

            // correct?
            if ($form->isCorrect()) {
                // build item
                $item = array();
{% if action == 'edit' %}
                $item['id'] = $this->id;
{% endif %}
{% if meta %}
                $item['title'] = $fieldTitle->getValue();
                $item['meta_id'] = $meta->save();
{% endif %}
{% if tags %}

                $tags = $fieldTags->getValue();
{% endif %}

                // save
{% if action in ['add', 'edit'] %}
                {% if action == 'add' %}$id = {% endif %}Model::{% if action == 'add' %}create{% endif %}{% if action == 'edit' %}update{% endif %}($item{% if tags %}, $tags{% endif %});
{% endif %}

                // redirect
                $redirectURL = BackendModel::createURLForAction('Index');
{% if action in ['add', 'edit'] %}
                $redirectURL .= '&highlight=row-' . {% if action == 'add' %}$id{% elseif action == 'edit' %}$this->record['id']{% endif %};
{% endif %}
                $redirectURL .= '&report={{ action }}ed';
                $this->redirect($redirectURL);
            }
        }

        $form->parse($this->tpl);
    }
{% endif %}
{% if action != 'delete' %}

    protected function parse()
    {
        parent::parse();
{% if action == 'index' %}
        $this->tpl->assign('dataGrid', (string) $this->dataGrid->getContent());
{% elseif action in ['add', 'edit'] and meta %}
        // get url
        $url = BackendModel::getURLForBlock($this->URL->getModule(), 'Detail');
        $url404 = BackendModel::getURL(404);

        // parse additional variables
        if ($url404 != $url) {
            $this->tpl->assign('detailURL', SITE_URL . $url);
        }
{% if action == 'edit' %}

        $this->tpl->assign('item', $this->record);
{% endif %}
{% endif %}
    }
{% endif %}
}
