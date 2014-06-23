<?php

namespace Forkmodule\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;
use Forkmodule\Service\Twig;
use Forkmodule\Configuration;
use Forkmodule\SafeName;
use Forkmodule\Forkmodule;

class Create extends Command
{
    /**
     * @var string The current working directory
     */
    protected $workingDirectory;

    /**
     * @var \Twig_Environment Twig service
     */
    protected $twig;

    /**
     * Constructor
     *
     * @param string $name             The name for this command
     * @param string $workingDirectory The current working directory
     * @param Twig   $twig             Twig service
     */
    public function __construct($name, $workingDirectory, Twig $twig)
    {
        parent::__construct($name);

        $this->workingDirectory = $workingDirectory;
        $this->twig = $twig->getTemplateEngine();

        $this->addArgument('name', InputArgument::OPTIONAL, 'Name of the module');
    }

    /**
     * Execute method
     *
     * @param InputInterface  $input  The input
     * @param OutputInterface $output The output
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // Create title color
        $titleStyle = new OutputFormatterStyle('red', null, array('bold'));
        $output->getFormatter()->setStyle('title', $titleStyle);

        // Get the question helper
        $helper = $this->getHelperSet()->get('question');

        // Welcome
        $output->writeln('<title>Forkmodule</title>' . "\n");
        $output->writeln('--> <info>Initializing...</info>' . "\n");

        // Get fork dir
        $forkDirectory = $this->getForkDirectory($this->workingDirectory);

        if (empty($forkDirectory)) {
            throw new \InvalidArgumentException('This is not a fork directory');
        }

        // Get module name
        $moduleName = $input->getArgument('name');
        if (!$moduleName) {
            $question = new Question('<question>Name of the module:</question>' . "\n", 'demo');
            $moduleName = $helper->ask($input, $output, $question);
        }

        // Check if module exists
        if (
            is_dir($forkDirectory . '/frontend/modules/' . $moduleName)
            || is_dir($forkDirectory . '/backend/modules/' . $moduleName)
        ) {
            throw new \InvalidArgumentException('A module with this name already exists');
        }

        // Get actions
        list($frontendActions, $frontendWidgets, $backendActions, $backendWidgets) = $this->getActions(
            $input, $output, $helper
        );

        // Get options
        list($meta, $tags, $searchable) = $this->getOptions(
            $input, $output, $helper
        );

        // Create configuration object
        $configuration = new Configuration(
            $forkDirectory,
            $moduleName,
            (string) new SafeName($moduleName),
            $meta,
            $tags,
            $searchable,
            $frontendActions,
            $frontendWidgets,
            $backendActions,
            $backendWidgets
        );

        // Summary
        $output->writeln('--> <info>Summary</info>');
        $output->writeln('Module name:    ' . $configuration->getModuleName());
        $output->writeln('Fork directory: ' . $configuration->getForkDir());

        $question = new ConfirmationQuestion('<question>Is this info correct?</question> (Y/n)' . "\n", true);
        if (!$helper->ask($input, $output, $question)) {
            return;
        }

        // Create module
        $output->writeln('--> <info>Creating directory structure...</info>' . "\n");
        $output->writeln('--> <info>Creating frontend directories.</info>' . "\n");
        $output->writeln('--> <info>Creating backend directories.</info>' . "\n");
        $forkmodule = new Forkmodule($this->twig, $configuration);
    }

    /**
     * Get fork directory, starting from a given working directory
     *
     * @param string $workingDirectory The given working directory
     *
     * @return string The path to the fork directory
     */
    protected function getForkDirectory($workingDirectory)
    {
        $forkDir = '';

        // Is this a forkcms directory? Or any of the above directories?
        while (empty($forkDir) && $workingDirectory !== '/') {
            // Is this a forkcms directory?
            if (is_dir($workingDirectory . '/frontend/modules') && is_dir($workingDirectory . '/backend/modules')) {
                $forkDir = $workingDirectory;
            } else {
                $workingDirectory = dirname($workingDirectory);
            }
        }

        return $forkDir;
    }

    /**
     * Get all action names
     *
     * @param InputInterface  $input  The input
     * @param OutputInterface $output The output
     * @param mixed           $helper The question helper
     *
     * @return array A list of actions [frontendActions, frontendWidgets, backendActions, backendWidgets]
     */
    protected function getActions(InputInterface $input, OutputInterface $output, $helper)
    {
        $actionList = array();
        foreach (array('frontend', 'backend') as $application) {
            foreach (array('actions', 'widgets') as $controller) {
                $actionListCurrent = array();
                $answer = 'index';

                while (!empty($answer)) {
                    $question = new Question('<question>Create ' . $application . ' ' . $controller . '</question> (Empty answer to continue):' . "\n", '');
                    $answer = $helper->ask($input, $output, $question);

                    if ($answer !== '') {
                        $actionListCurrent = array_merge($actionListCurrent, array(mb_strtolower($answer)));
                    }
                }

                $actionList[] = $actionListCurrent;
            }
        }

        return $actionList;
    }

    /**
     * Get options
     *
     * @param InputInterface  $input  The input
     * @param OutputInterface $output The output
     * @param mixed           $helper The question helper
     *
     * @return array A list of options [meta, tags, searchable]
     */
    protected function getOptions(InputInterface $input, OutputInterface $output, $helper)
    {
        $question = new ConfirmationQuestion('<question>Do you want to use Meta/SEO in your module?</question> (Y/n)' . "\n", true);
        $meta = $helper->ask($input, $output, $question);

        $question = new ConfirmationQuestion('<question>Do you want to use tags in your module?</question> (Y/n)' . "\n", true);
        $tags = $helper->ask($input, $output, $question);

        $question = new ConfirmationQuestion('<question>Do you want to make your module searchable?</question> (Y/n)' . "\n", true);
        $searchable = $helper->ask($input, $output, $question);

        return array($meta, $tags, $searchable);
    }
}
