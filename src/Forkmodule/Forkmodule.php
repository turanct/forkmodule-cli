<?php

namespace Forkmodule;

/**
 * Forkmodule interface
 */
interface Forkmodule
{
    /**
     * Create the frontend directories & files
     */
    public function frontend();

    /**
     * Create the backend directories & files
     */
    public function backend();
}
