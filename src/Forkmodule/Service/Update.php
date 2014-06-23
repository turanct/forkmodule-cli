<?php

namespace Forkmodule\Service;

/**
 * Update service
 */
class Update
{
    /**
     * @var string The basedir of the forkmodule installation
     */
    protected $basedir;

    /**
     * Constructor
     *
     * @param string $basedir The basedir of the forkmodule installation
     */
    public function __construct($basedir)
    {
        $this->basedir = (string) $basedir;
    }

    /**
     * Run method
     *
     * This methods runs an update on the repository
     */
    public function run()
    {
        passthru('cd ' . realpath($this->basedir) . ' && git pull origin master && curl -sS https://getcomposer.org/installer | php && php composer.phar install && git remote update && cd -');
    }
}
