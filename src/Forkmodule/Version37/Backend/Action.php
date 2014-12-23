<?php

namespace Forkmodule\Version37\Backend;

use Forkmodule\Forkcontroller;

/**
 * Backend Action class
 */
class Action extends Forkcontroller
{
    /**
     * Create method
     */
    public function create()
    {
        $content = $this->twig->render(
            'backend.actions.index.php',
            $this->tplVars
        );
        file_put_contents(
            $this->moduleDir . '/Actions/' . ucfirst($this->name) . '.php',
            $content
        );

        if ($this->name != 'delete') {
            $templateFile = ($this->name == 'index') ? 'index' : 'action';
            $content = $this->twig->render(
                'backend.layout.templates.' . $templateFile . '.tpl',
                $this->tplVars
            );
            file_put_contents(
                $this->moduleDir . '/Layout/Templates/' . ucfirst($this->name) . '.tpl',
                $content
            );
        }
    }
}
