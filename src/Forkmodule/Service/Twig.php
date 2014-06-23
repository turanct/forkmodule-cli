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
     * Constructor
     *
     * @var string $templateDir The template directory path
     */
    public function __construct($templateDir)
    {
        $this->templateDir = (string) $templateDir;
    }

    /**
     * Get the template rendering engine
     *
     * @param bool $debug Should debug mode be on?
     *
     * @return Twig_Environment The twig environment
     */
    public function getTemplateEngine($debug = true)
    {
        $loader = new Twig_Loader_Filesystem($this->templateDir);
        $templateEngine = new Twig_Environment($loader, array('debug' => $debug));

        return $templateEngine;
    }
}
