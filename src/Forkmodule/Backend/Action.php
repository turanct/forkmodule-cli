<?php
namespace Forkmodule\Backend;

use \Forkmodule\Forkcontroller;

/**
 * Backend Action class
 */
class Action extends Forkcontroller {
	/**
	 * Create method
	 */
	public function create() {
		$content = $this->app['twig']->render(
			'backend.actions.index.php',
			array(
				'moduleName' => $this->app['module.name'],
				'moduleNameSafe' => $this->app['module.name.safe'],
				'action' => $this->name,
				'actionSafe' => $this->safeName,
				'meta' => $this->app['settings.meta'],
			)
		);
		file_put_contents($this->app['module.dir.backend'] . 'actions/'.$this->name.'.php', $content);

		if ($this->name != 'delete') {
			$templateFile = ($this->name == 'index') ? 'index' : 'action';
			$content = $this->app['twig']->render(
				'backend.layout.templates.'.$templateFile.'.tpl',
				array(
					'moduleName' => $this->app['module.name'],
					'moduleNameSafe' => $this->app['module.name.safe'],
					'action' => $this->name,
					'actionSafe' => $this->safeName,
					'meta' => $this->app['settings.meta'],
				)
			);
			file_put_contents($this->app['module.dir.backend'] . 'layout/templates/'.$this->name.'.tpl', $content);
		}
	}
}
