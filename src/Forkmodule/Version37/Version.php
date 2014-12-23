<?php

namespace Forkmodule\Version37;

use Forkmodule\ForkVersion;
use Forkmodule\Service\Twig;
use Forkmodule\Configuration;
use Forkmodule\Exceptions\ModuleAlreadyExists;
use Forkmodule\Exceptions\NoForkDirectory;

/**
 * ForkVersion adapter
 */
class Version implements ForkVersion
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
    public function getForkDirectory($cwd)
    {
        $forkDir = '';

        // Is this a forkcms directory? Or any of the above directories?
        while (empty($forkDir) && $cwd !== '/') {
            // Is this a forkcms directory?
            if (basename($cwd) == 'src' && is_dir($cwd . '/Frontend/Modules') && is_dir($cwd . '/Backend/Modules')) {
                $forkDir = $cwd;
            } elseif (is_dir($cwd . '/src/Frontend/Modules') && is_dir($cwd . '/src/Backend/Modules')) {
                $forkDir = $cwd . '/src';
            } else {
                $cwd = dirname($cwd);
            }
        }

        if (empty($forkDir)) {
            throw new NoForkDirectory($cwd . ' is not a fork directory');
        }

        return $forkDir;
    }

    /**
     * Guard against already existing module
     *
     * @param string $forkDirectory The fork directory where we'll look for the module
     * @param string $moduleName    The module name
     *
     * @throws ModuleAlreadyExists when the module already exists
     */
    public function moduleExists($forkDirectory, $moduleName)
    {
        if (
            is_dir($forkDirectory . '/Frontend/Modules/' . $moduleName)
            || is_dir($forkDirectory . '/Backend/Modules/' . $moduleName)
        ) {
            throw new ModuleAlreadyExists('A module named ' . $moduleName . ' already exists');
        }
    }

    /**
     * Get the forkmodule adapter for this version (factory)
     *
     * @param Twig          $twig   The template renderer
     * @param Configuration $config The configuration object
     *
     * @return Forkmodule
     */
    public function getAdapter(Twig $twig, Configuration $config)
    {
        $twigEnvironment = $twig->getTemplateEngine('Version37');

        return new Module($twigEnvironment, $config);
    }
}
