<?php

namespace Forkmodule;

/**
 * Message class
 *
 * This class will output messages to the user, while running the script.
 */
class Message
{
    /**
     * @var string The message we want to send
     */
    protected $message;

    /**
     * @var string The type of message we want to send
     */
    protected $type;

    /**
     * Constructor Method
     *
     * @param string $message The message we want to send
     * @param string $type    The type of message we want to send
     */
    public function __construct($message, $type = 'normal') {
        $this->message = (string) $message;
        $this->type = (string) $type;

        $this->send();
    }

    /**
     * Output a formatted string
     */
    protected function send() {
        switch ($this->type) {
            case 'welcome':
                echo "\033[1;31m".$this->message."\033[0m\n";
                break;

            case 'title':
                echo "\n--> \033[0;32m".$this->message."\033[0m\n";
                break;

            case 'notice':
                echo "\033[0;36m".$this->message."\033[0m\n";
                break;

            case 'error':
                echo "\033[0;31m".$this->message."\033[0m\n";
                break;

            case 'normal':
            default:
                echo $this->message."\n";
                break;
        }
    }
}