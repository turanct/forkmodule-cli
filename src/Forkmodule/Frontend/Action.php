<?php
namespace Forkmodule\Frontend;

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
            $this->config->getModuleDirFrontend() . '/actions/'.$this->name.'.php',
            $content
        );

        $content = $this->twig->render(
            'frontend.layout.templates.index.tpl',
            $this->tplVars
        );
        file_put_contents(
            $this->config->getModuleDirFrontend() . '/layout/templates/'.$this->name.'.tpl',
            $content
        );
    }
}
