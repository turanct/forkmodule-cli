<?php

namespace Forkmodule\Version36\Frontend;

use \Forkmodule\Forkcontroller;

/**
 * Frontend Action class
 */
class Action extends Forkcontroller
{
    /**
     * Create method
     */
    public function create()
    {
        $content = $this->twig->render(
            'frontend.actions.index.php',
            $this->tplVars
        );
        file_put_contents(
            $this->moduleDir . '/actions/' . $this->name . '.php',
            $content
        );

        $content = $this->twig->render(
            'frontend.layout.templates.index.tpl',
            $this->tplVars
        );
        file_put_contents(
            $this->moduleDir . '/layout/templates/' . $this->name . '.tpl',
            $content
        );
    }
}
