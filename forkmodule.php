#!/usr/bin/env php
<?php

require_once __DIR__ . '/vendor/autoload.php';

use Symfony\Component\Console\Application;


// Create new application
$application = new Application();

// Services
$twigService = new Forkmodule\Service\Twig(__DIR__ . '/src/templates');
$updateService = new Forkmodule\Service\Update(__DIR__);

// Add update command
$application->add(new Forkmodule\Command\Create('create', getcwd(), $twigService));
$application->add(new Forkmodule\Command\Update('update', $updateService));

// Default command
$application->setDefaultCommand('create');

// Run the application
$application->run();
