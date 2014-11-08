<?php

namespace Forkmodule;

use Forkmodule\Exceptions\UnknownVersion;

/**
 * ForkVersionFactory class
 *
 * This class will create a fork version, based on user input.
 */
class ForkVersionFactory
{
    /**
     * @var string The version map
     */
    protected $versions = array(
        '3.6' => '\\Forkmodule\\Version36\\Version',
        '3.7' => '\\Forkmodule\\Version37\\Version',
    );

    /**
     * Get version
     *
     * @param string $version The version we want
     *
     * @throws UnknownVersion when the version was not found
     *
     * @return ForkVersion The fork version
     */
    public function getVersion($version)
    {
        if (!isset($this->versions[$version])) {
            throw new UnknownVersion('Version ' . $version . ' is not supported');
        }

        $versionClass = $this->versions[$version];

        return new $versionClass;
    }
}
