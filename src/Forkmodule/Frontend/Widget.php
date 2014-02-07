<?php
namespace Forkmodule\Frontend;

use \Forkmodule\Forkcontroller;

/**
 * Frontend Widget class
 */
class Widget extends Forkcontroller {
	/**
	 * Create method
	 */
	public function create() {
		$content = $this->app['twig']->render(
			'frontend.widgets.index.php',
			array(
				'moduleName' => $this->app['module.name'],
				'moduleNameSafe' => $this->app['module.name.safe'],
				'widget' => $this->name,
				'widgetSafe' => $this->safeName,
				'meta' => $this->app['settings.meta'],
			)
		);
		file_put_contents($this->app['module.dir.frontend'] . 'widgets/'.$this->name.'.php', $content);

		$content = $this->app['twig']->render(
			'frontend.layout.widgets.index.tpl',
			array(
				'moduleName' => $this->app['module.name'],
				'moduleNameSafe' => $this->app['module.name.safe'],
				'widget' => $this->name,
				'widgetSafe' => $this->safeName,
				'meta' => $this->app['settings.meta'],
			)
		);
		file_put_contents($this->app['module.dir.frontend'] . 'layout/widgets/'.$this->name.'.tpl', $content);
	}
}
