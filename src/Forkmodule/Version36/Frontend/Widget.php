<?php

namespace Forkmodule\Version36\Frontend;

use \Forkmodule\Forkcontroller;

/**
 * Frontend Widget class
 */
class Widget extends Forkcontroller
{
    /**
     * Create method
     */
    public function create()
    {
        $content = $this->twig->render(
            'frontend.widgets.index.php',
            $this->tplVars
        );
        file_put_contents(
            $this->moduleDir . '/widgets/' . $this->name . '.php',
            $content
        );

        $content = $this->twig->render(
            'frontend.layout.widgets.index.tpl',
            $this->tplVars
        );
        file_put_contents(
            $this->moduleDir . '/layout/widgets/' . $this->name . '.tpl',
            $content
        );
    }
}
