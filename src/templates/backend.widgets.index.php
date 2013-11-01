<?php
/**
 * Backend {{ moduleName }} {{ widget }} widget
 */
class Backend{{ moduleName|capitalize }}Widget{{ widget }} extends BackendBaseWidget
{
	/**
	 * Execute the widget
	 */
	public function execute()
	{
		$this->setColumn('middle');
		$this->setPosition(0);
		$this->loadData();
		$this->parse();
		$this->display();
	}

	/**
	 * Load the data
	 */
	private function loadData()
	{

	}

	/**
	 * Parse into template
	 */
	private function parse()
	{

	}
}
