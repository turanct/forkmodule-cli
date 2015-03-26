<?php

namespace Backend\Modules\Jelmer\Actions;

use Backend\Core\Engine\Form as BackendForm;
use Backend\Core\Engine\Meta as BackendMeta;
use Backend\Core\Engine\Base\ActionEdit as BackendBaseActionEdit;
use Backend\Core\Engine\Language as BL;
use Backend\Core\Engine\Model as BackendModel;
use Backend\Modules\Jelmer\Engine\Model;

/**
 * Backend Jelmer edit action
 */
class Edit extends BackendBaseActionEdit
{
    /**
     * Execute the action
     */
    public function execute()
    {
        parent::execute();

        $this->id = $this->getParameter('id', 'int');

        $this->getData();
        $this->handleForm();

        $this->parse();
        $this->display();
    }

    /**
     * Get data
     */
    protected function getData()
    {
        $this->record = Model::get($this->id);

        // Validate
        if (empty($this->record)) {
            $this->redirect(BackendModel::createURLForAction('index') . '&error=non-existing');
        }
    }

    /**
     * Handle form
     */
    protected function handleForm()
    {
        // Create the form
        $form = new BackendForm('edit');

        // Add fields
        $fieldTitle = $form->addText('title', $this->record['title'], 255, 'inputText title', 'inputTextError title');
        $fieldTags = $form->addText('tags', $this->record['tags'], null, 'inputText tagBox', 'inputTextError tagBox');

        // Meta
        $meta = new BackendMeta($form, $this->record['meta_id'], 'title', true);

        // Set callback for generating a unique URL
        $meta->setUrlCallback('Backend\Modules\Jelmer\Engine\Model', 'getURL', array($this->record['id']));

        // Submitted?
        if ($form->isSubmitted()) {
            // Check fields
            $meta->validate();
            $fieldTitle->isFilled(BL::err('FieldIsRequired'));

            // Correct?
            if ($form->isCorrect()) {
                // Build item
                $item = array();
                $item['id'] = $this->id;
                $item['title'] = $fieldTitle->getValue();
                $item['meta_id'] = $meta->save();

                $tags = $fieldTags->getValue();

                // Save
                Model::update($item, $tags);

                // Redirect
                $redirectURL = BackendModel::createURLForAction('index');
                $redirectURL .= '&highlight=row-' . $this->record['id'];
                $redirectURL .= '&report=edited';
                $this->redirect($redirectURL);
            }
        }

        $form->parse($this->tpl);
    }

    /**
     * Parse method
     */
    protected function parse()
    {
        parent::parse();
        // Get url
        $url = BackendModel::getURLForBlock($this->URL->getModule(), 'detail');
        $url404 = BackendModel::getURL(404);

        // Parse additional variables
        if ($url404 != $url) {
            $this->tpl->assign('detailURL', SITE_URL . $url);
        }

        $this->tpl->assign('item', $this->record);
    }
}
