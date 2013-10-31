<?php
namespace Forkmodule\Backend;

use \Forkmodule\Forkcontroller;

/**
 * Backend Widget class
 */
class Widget extends Forkcontroller {
	/**
	 * Create method
	 */
	public function create() {
		$content = $this->app['twig']->render('backend.widgets.index.php', array('moduleName' => $this->app['module.name'], 'widget' => $this->name));
		file_put_contents($this->app['module.dir.backend'] . 'widgets/'.$this->name.'.php', $content);

		$content = $this->app['twig']->render('backend.layout.widgets.index.tpl', array('moduleName' => $this->app['module.name'], 'widget' => $this->name));
		file_put_contents($this->app['module.dir.backend'] . 'layout/widgets/'.$this->name.'.tpl', $content);
	}
}
