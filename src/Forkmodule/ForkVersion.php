<?php

namespace Forkmodule;

use Forkmodule\Service\Twig;

/**
 * ForkVersion interface
 */
interface ForkVersion
{
    /**
     * Find the fork directory
     *
     * @param string $cwd The current working directory
     *
     * @throws NoForkDirectory when we're not currently in a fork directory
     *
     * @return string The fork directory
     */
    public function getForkDirectory($cwd);

    /**
     * Guard against already existing module
     *
     * @param string $forkDirectory The fork directory where we'll look for the module
     * @param string $moduleName    The module name
     *
     * @throws ModuleAlreadyExists when the module already exists
     */
    public function moduleExists($forkDirectory, $moduleName);

    /**
     * Get the forkmodule adapter for this version (factory)
     *
     * @param Twig          $twig   The template renderer
     * @param Configuration $config The configuration object
     *
     * @return Forkmodule
     */
    public function getAdapter(Twig $twig, Configuration $config);
}

