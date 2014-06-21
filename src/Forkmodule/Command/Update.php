<?php

namespace Forkmodule\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class Update extends Command
{
    /**
     * @var \Forkmodule\Service\Update Update service
     */
    protected $update;

    /**
     * Constructor
     *
     * @param string                     $name   The name for this command
     * @param \Forkmodule\Service\Update $update Update service
     */
    public function __construct($name, \Forkmodule\Service\Update $update)
    {
        parent::__construct($name);

        $this->update = $update;
    }

    /**
     * Execute method
     *
     * @param InputInterface  $input  The input
     * @param OutputInterface $output The output
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->update->run();
    }
}
