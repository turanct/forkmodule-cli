<?php
namespace Forkmodule;

/**
 * Forkmodule class
 */
class Forkmodule {
	/**
	 * @var \Pimple
	 */
	protected $app;



	/**
	 * Constructor Method
	 *
	 * @param \Pimple   $app    The app container
	 */
	public function __construct($app) {
		// Assign
		$this->app = $app;

		// Create the directory structure
		$this->frontend();
		$this->backend();
	}


	/**
	 * Create the frontend directories & files
	 */
	protected function frontend() {
		/**
		 * Directories
		 */
		$this->app['output']('Creating frontend directories.', 'title');

		$this->app['module.dir.frontend'] = $this->app['forkdir'] . '/frontend/modules/' . $this->app['module.name'] . '/';
		mkdir($this->app['module.dir.frontend']);

		$directories = array(
			'actions',
			'engine',
			'layout',
			'layout/templates',
			'layout/widgets',
			'widgets',
		);

		foreach ($directories as $directory) {
			mkdir($this->app['module.dir.frontend'] . $directory);
		}


		/**
		 * Files
		 */
		$content = $this->app['twig']->render('frontend.config.php', array('moduleName' => $this->app['module.name'], 'moduleNameSafe' => $this->app['module.name.safe']));
		file_put_contents($this->app['module.dir.frontend'] . 'config.php', $content);

		$content = $this->app['twig']->render('frontend.engine.model.php', array('moduleName' => $this->app['module.name'], 'moduleNameSafe' => $this->app['module.name.safe']));
		file_put_contents($this->app['module.dir.frontend'] . 'engine/model.php', $content);

		foreach ($this->app['frontend.actions'] as $action) {
			$currentAction = new Frontend\Action($this->app, $action);
			$currentAction->create();
		}

		foreach ($this->app['frontend.widgets'] as $widget) {
			$currentWidget = new Frontend\Widget($this->app, $widget);
			$currentWidget->create();
		}
	}


	/**
	 * Create the backend directories & files
	 */
	protected function backend() {
		/**
		 * Directories
		 */
		$this->app['output']('Creating backend directories.', 'title');

		$this->app['module.dir.backend'] = $this->app['forkdir'] . '/backend/modules/' . $this->app['module.name'] . '/';
		mkdir($this->app['module.dir.backend']);

		$directories = array(
			'actions',
			'ajax',
			'engine',
			'installer',
			'installer/data',
			'js',
			'layout',
			'layout/templates',
			'layout/widgets',
			'widgets',
		);

		foreach ($directories as $directory) {
			mkdir($this->app['module.dir.backend'] . $directory);
		}


		/**
		 * Files
		 */
		$content = $this->app['twig']->render('backend.config.php', array('moduleName' => $this->app['module.name'], 'moduleNameSafe' => $this->app['module.name.safe']));
		file_put_contents($this->app['module.dir.backend'] . 'config.php', $content);

		$content = $this->app['twig']->render('backend.engine.model.php', array('moduleName' => $this->app['module.name'], 'moduleNameSafe' => $this->app['module.name.safe'], 'tags' => $this->app['settings.tags']));
		file_put_contents($this->app['module.dir.backend'] . 'engine/model.php', $content);

		$installerData = array(
			'moduleName' => $this->app['module.name'],
			'moduleNameSafe' => $this->app['module.name.safe'],
			'backendActions' => $this->app['backend.actions'],
			'backendWidgets' => $this->app['backend.widgets'],
			'frontendActions' => $this->app['frontend.actions'],
			'frontendWidgets' => $this->app['frontend.widgets'],
		);

		$content = $this->app['twig']->render('backend.installer.installer.php', $installerData);
		file_put_contents($this->app['module.dir.backend'] . 'installer/installer.php', $content);

		$content = $this->app['twig']->render('backend.installer.data.locale.xml', $installerData);
		file_put_contents($this->app['module.dir.backend'] . 'installer/data/locale.xml', $content);

		$content = $this->app['twig']->render('backend.installer.data.install.sql', array('moduleName' => $this->app['module.name'], 'moduleNameSafe' => $this->app['module.name.safe']));
		file_put_contents($this->app['module.dir.backend'] . 'installer/data/install.sql', $content);

		foreach ($this->app['backend.actions'] as $action) {
			$currentAction = new Backend\Action($this->app, $action);
			$currentAction->create();
		}

		foreach ($this->app['backend.widgets'] as $widget) {
			$currentWidget = new Backend\Widget($this->app, $action);
			$currentWidget->create();
		}
	}
}
