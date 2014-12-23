<?php

namespace Forkmodule\Service;

use Twig_Loader_Filesystem;
use Twig_Environment;

/**
 * Twig servce
 *
 * This class provides a builder for the Twig template environment
 */
class Twig
{
    /**
     * @var string The template directory path
     */
    protected $templateDir;

    /**
     * @var bool Debug mode on?
     */
    protected $debug;

    /**
     * Constructor
     *
     * @var string $templateDir The template directory path
     * @param bool $debug       Should debug mode be on?
     */
    public function __construct($templateDir, $debug = true)
    {
        $this->templateDir = (string) $templateDir;
        $this->debug = (bool) $debug;
    }

    /**
     * Get the template rendering engine
     *
     * @param string $templateVersion The template version directory
     *
     * @return Twig_Environment The twig environment
     */
    public function getTemplateEngine($templateVersion)
    {
        $loader = new Twig_Loader_Filesystem($this->templateDir . '/' . $templateVersion);
        $templateEngine = new Twig_Environment($loader, array('debug' => $this->debug));

        return $templateEngine;
    }
}
