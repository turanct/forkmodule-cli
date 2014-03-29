<?php

namespace Forkmodule;

/**
 * SafeName class
 *
 * This class will create a fork Camel Case name.
 */
class SafeName
{
    /**
     * @var string The snake case name
     */
    protected $snakeCase;

    /**
     * @var string The camel case name
     */
    protected $camelCase;

    /**
     * Constructor Method
     *
     * @param string $snake The snake case name
     */
    public function __construct($snake) {
        $this->snakeCase = (string) $snake;
        $this->camelCase = $this->convertToCamelCase($this->snakeCase);
    }

    /**
     * Convert a string to camel case
     *
     * @param string $snakeCase The snake case name
     */
    protected function convertToCamelCase($snakeCase) {
        $parts = explode('_', $snakeCase);
        $UppercaseParts = array_map('ucfirst', $parts);
        $camelCase = implode($UppercaseParts);

        return $camelCase;
    }

    /**
     * Convert to string
     *
     * @return string The safename/fork camel case string
     */
    public function __toString() {
        return $this->camelCase;
    }
}
