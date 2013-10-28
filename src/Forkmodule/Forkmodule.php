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
	 * @var string
	 */
	protected $name;



	/**
	 * Constructor Method
	 *
	 * @param \Pimple   $app    The app container
	 * @param string    $name   The name of the module
	 */
	public function __construct($app, $name) {
		// Assign
		$this->app = $app;
		$this->name = (string) $name;

		// Create the directory structure
		$this->create();
	}


	/**
	 * Create method
	 */
	protected function create() {

	}
}