<?php
namespace Forkmodule\Frontend;

use \Forkmodule\Forkcontroller;

/**
 * Frontend Action class
 */
class Action extends Forkcontroller {
	/**
	 * Create method
	 */
	public function create() {
		$content = $this->app['twig']->render('frontend.actions.index.php', array('moduleName' => $this->app['module.name'], 'action' => $this->name));
		file_put_contents($this->app['module.dir.frontend'] . 'actions/'.$this->name.'.php', $content);

		$content = $this->app['twig']->render('frontend.layout.templates.index.tpl', array('moduleName' => $this->app['module.name'], 'action' => $this->name));
		file_put_contents($this->app['module.dir.frontend'] . 'layout/templates/'.$this->name.'.tpl', $content);
	}
}