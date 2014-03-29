<?php

namespace Forkmodule;

/**
 * Question class
 *
 * This class will ask Questions to the user, while running the script.
 */
class Question extends Message
{
    /**
     * @var string The user's answer to this question
     */
    protected $answer;

    /**
     * Constructor Method
     *
     * @param string $question The message we want to send
     * @param string $type     The type of message we want to send
     */
    public function __construct($question, $type = 'notice')
    {
        parent::__construct($question, $type);

        $this->listen();
    }

    /**
     * Listen to the user's answer
     */
    protected function listen()
    {
        $this->answer = stream_get_line(STDIN, 1024, PHP_EOL);
        $this->answer = trim($this->answer);
    }

    /**
     * Get the user's answer to this question
     *
     * @return string The user's answer to this question
     */
    public function getAnswer()
    {
        return $this->answer;
    }
}
