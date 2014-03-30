#!/usr/bin/env php
<?php
// Require the composer autoloader
require_once(__DIR__ . '/vendor/autoload.php');

// Create new pimple instance
$app = new Pimple();


// Set template directory
$app['themedir'] = __DIR__ . '/src/templates';


/**
 * Services
 */
// Create shared twig filesystem loader
$app['twig.loader'] = $app->share(function() use ($app) {
    return new Twig_Loader_Filesystem($app['themedir']);
});

// Create shared twig template engine
$app['twig'] = $app->share(function() use ($app) {
    return new Twig_Environment($app['twig.loader'], array('debug' => true));
});

// Create forkmodule object
$app['forkmodule'] = $app->protect(function() use ($app) {
    return new Forkmodule\Forkmodule($app['twig'], $app['configuration']);
});


/**
 * Output method
 */
$app['output'] = $app->protect(function($string, $mode = 'normal') use ($app) {
    new Forkmodule\Message($string, $mode);
});


/**
 * Initialize the application
 */
$app['init'] = $app->protect(function() use ($app, $argv) {
    /**
     * Get command line arguments
     */
    // Should we update?
    if (isset($argv[1]) && $argv[1] == '--update') {
        // Update
        $app['update']();

        // Stop executing
        exit;
    }

    $obtainConfiguration = new Forkmodule\ObtainConfiguration($argv);
    $app['configuration'] = $obtainConfiguration->getConfiguration();

    /**
     * Create a summary
     */
    $app['output']('Summary', 'title');
    $app['output']('Module name:    ' . $app['configuration']->getModuleName(), 'normal');
    $app['output']('Fork directory: ' . $app['configuration']->getForkDir(), 'normal');

    $question = new Forkmodule\Question('Is this info correct? (Y/n)');
    if (strtoupper($question->getAnswer()) === 'N') {
        $app['output']('Aborting...', 'error');
        exit;
    }
});


/**
 * Update the application
 */
$app['update'] = $app->protect(function() use ($app) {
    // Passthrough the update command
    passthru('cd ' . realpath(__DIR__) . ' && git pull origin master && git remote update && cd -');
});


/**
 * Main
 */
$app['run'] = $app->protect(function() use ($app) {
    // Output welcome message
    $app['output']('Forkmodule', 'welcome');

    // Initialize
    $app['output']('Initializing...', 'title');
    $app['init']();

    // Create the module
    $app['output']('Creating directory structure...', 'title');
    $app['forkmodule']();
});


/**
 * Run the main routine
 */
$app['run']();
