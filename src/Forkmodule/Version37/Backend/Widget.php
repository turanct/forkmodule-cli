<?php

namespace Forkmodule\Version37\Backend;

use \Forkmodule\Forkcontroller;

/**
 * Backend Widget class
 */
class Widget extends Forkcontroller
{
    /**
     * Create method
     */
    public function create()
    {
        $content = $this->twig->render(
            'backend.widgets.index.php',
            $this->tplVars
        );
        file_put_contents(
            $this->moduleDir . '/Widgets/' . ucfirst($this->name) . '.php',
            $content
        );

        $content = $this->twig->render(
            'backend.layout.widgets.index.tpl',
            $this->tplVars
        );
        file_put_contents(
            $this->moduleDir . '/Layout/Widgets/' . ucfirst($this->name) . '.tpl',
            $content
        );
    }
}
