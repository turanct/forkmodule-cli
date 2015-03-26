<?php

namespace Backend\Modules\Jelmer\Actions;

use Backend\Core\Engine\Form as BackendForm;
use Backend\Core\Engine\Meta as BackendMeta;
use Backend\Core\Engine\Base\ActionAdd as BackendBaseActionAdd;
use Backend\Core\Engine\Language as BL;
use Backend\Core\Engine\Model as BackendModel;
use Backend\Modules\Jelmer\Engine\Model;

/**
 * Backend Jelmer add action
 */
class Add extends BackendBaseActionAdd
{
    /**
     * Execute the action
     */
    public function execute()
    {
        parent::execute();

        $this->handleForm();

        $this->parse();
        $this->display();
    }

    /**
     * Handle form
     */
    protected function handleForm()
    {
        // Create the form
        $form = new BackendForm('add');

        // Add fields
        $fieldTitle = $form->addText('title', null, 255, 'inputText title', 'inputTextError title');
        $fieldTags = $form->addText('tags', null, null, 'inputText tagBox', 'inputTextError tagBox');

        // Meta
        $meta = new BackendMeta($form, null, 'title', true);

        // Submitted?
        if ($form->isSubmitted()) {
            // Check fields
            $meta->validate();
            $fieldTitle->isFilled(BL::err('FieldIsRequired'));

            // Correct?
            if ($form->isCorrect()) {
                // Build item
                $item = array();
                $item['title'] = $fieldTitle->getValue();
                $item['meta_id'] = $meta->save();

                $tags = $fieldTags->getValue();

                // Save
                $id = Model::create($item, $tags);

                // Redirect
                $redirectURL = BackendModel::createURLForAction('index');
                $redirectURL .= '&highlight=row-' . $id;
                $redirectURL .= '&report=added';
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
    }
}
