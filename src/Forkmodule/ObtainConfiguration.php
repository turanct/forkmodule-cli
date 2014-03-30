<?php

namespace Forkmodule;

/**
 * ObtainConfiguration command
 *
 * This class will try to obtain the configuration options from the user
 */
class ObtainConfiguration
{
    /**
     * Constructor Method
     *
     * @param array $argv The command line arguments
     */
    public function __construct($argv)
    {
        $moduleName = $this->getModuleName($argv);
        $forkDir = $this->getForkDir();

        $this->checkDirectories($forkDir, $moduleName);

        list($frontendActions, $frontendWidgets, $backendActions, $backendWidgets) = $this->getActions();

        list($meta, $tags, $searchable) = $this->getOptions();

        $this->configuration = new Configuration(
            $forkDir,
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
    }

    /**
     * Get the module name
     *
     * @param array $argv The command line arguments
     *
     * @return string The module name
     */
    protected function getModuleName($argv)
    {
        if (isset($argv[1]) && trim($argv[1]) !== '') {
            // Did we get a module name on the command line?
            $moduleName = mb_strtolower(trim($argv[1]));
        } else {
            // Ask for it, if we didn't get it
            $question = new Question('Name of the module:');

            if ($question->getAnswer() !== '') {
                $moduleName = mb_strtolower($question->getAnswer());
            } else {
                $moduleName = 'demo';
            }
        }

        return $moduleName;
    }

    /**
     * Get the fork directory
     *
     * @return string The fork directory
     */
    protected function getForkDir()
    {
        // Current directory
        $wd = getcwd();
        $forkDir = '';

        // Is this a forkcms directory? Or any of the above directories?
        while (empty($forkDir) && $wd !== '/') {
            // Is this a forkcms directory?
            if (is_dir($wd . '/frontend/modules') && is_dir($wd . '/backend/modules')) {
                $forkDir = $wd;
            } else {
                $wd = dirname($wd);
            }
        }

        return $forkDir;
    }

    /**
     * Check if the directories are valid
     *
     * @param string $forkDir    The fork directory
     * @param string $moduleName The module name
     */
    protected function checkDirectories($forkDir, $moduleName)
    {
        // Did we find a directory?
        if (empty($forkDir)) {
            new Message('This is not a forkcms directory.', 'error');
            exit;
        }

        // Check if the module exists
        if (
            is_dir($forkDir . '/frontend/modules/' . $moduleName)
            || is_dir($forkDir . '/backend/modules/' . $moduleName)
        ) {
            new Message('A module with this name already exists.', 'error');
            exit;
        }
    }

    /**
     * Get all action names
     *
     * @return array A list of actions [frontendActions, frontendWidgets, backendActions, backendWidgets]
     */
    protected function getActions()
    {
        $actionList = array();
        foreach (array('frontend', 'backend') as $application) {
            foreach (array('actions', 'widgets') as $controller) {
                $actionListCurrent = array();
                $answer = 'index';

                while (!empty($answer)) {
                    $question = new Question('Create '.$application.' '.$controller.' (Empty answer to continue):');
                    $answer = $question->getAnswer();
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
     * @return array A list of options [meta, tags, searchable]
     */
    protected function getOptions()
    {
        $question = new Question('Do you want to use Meta/SEO in your module? (Y/n)');
        $meta = (strtoupper($question->getAnswer()) !== 'N') ? true : false;

        $question = new Question('Do you want to use tags in your module? (Y/n)');
        $tags = (strtoupper($question->getAnswer()) !== 'N') ? true : false;

        $question = new Question('Do you want to make your module searchable? (Y/n)');
        $searchable = (strtoupper($question->getAnswer()) !== 'N') ? true : false;

        return array($meta, $tags, $searchable);
    }

    /**
     * Get configuration object
     *
     * @return Configuration The configuration object
     */
    public function getConfiguration()
    {
        return $this->configuration;
    }
}
