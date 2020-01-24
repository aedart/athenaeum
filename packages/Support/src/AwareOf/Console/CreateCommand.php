<?php

namespace Aedart\Support\AwareOf\Console;

use Aedart\Support\AwareOf\Documenter;
use Aedart\Support\AwareOf\Generator;
use Aedart\Support\Helpers\Config\ConfigTrait;
use Illuminate\Config\Repository;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

/**
 * Create Command
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\AwareOf\Console
 */
class CreateCommand extends CommandBase
{
    use ConfigTrait;

    /**
     * The "aware-of" generator
     *
     * @var Generator
     */
    protected Generator $generator;

    /**
     * The "aware-of" documenter
     *
     * @var Documenter
     */
    protected Documenter $documenter;

    /*****************************************************************
     * Command Configuration
     ****************************************************************/

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('dto:create')
            ->setDescription('Generates a series of aware-of components, based on given configuration')
            ->addArgument('config', InputArgument::REQUIRED, 'Path to php configuration file')
            ->addOption('force', 'f', InputOption::VALUE_NONE, 'Force overwrite existing aware-of components')
            ->setHelp($this->formatHelp());
    }

    /*****************************************************************
     * Run Command
     ****************************************************************/

    /**
     * {@inheritdoc}
     */
    public function runCommand(): ?int
    {
        $this->output->title('Creating Aware-Of Properties');

        $this
            ->loadConfiguration()
            ->setupGenerator()
            ->setupDocumenter()
            ->build();

        $this->output->success('done');

        return 0;
    }

    /*****************************************************************
     * Internals
     ****************************************************************/

    /**
     * Builds the aware-of components
     *
     * @throws \Throwable
     */
    protected function build()
    {
        // Get list of components to build
        $list = $this->getConfig()->get('aware-of-properties', []);

        // Create new process bar
        $this->output->progressStart(count($list) + 1);

        // Build each aware-of component
        $awareOfComponents = [];
        foreach ($list as $component){
            $result = $this->buildAwareOfComponent($component);
            $awareOfComponents[] = $result;

            // Debug
            $this->debug($result);

            $this->output->progressAdvance();
        }

        // Build markdown doc(s)
        $this->buildDocs($awareOfComponents);
        $this->output->progressAdvance();

        // Complete the progress bar
        $this->output->progressFinish();
    }

    /**
     * Generates the given "aware-of" component
     *
     * @param array $component
     *
     * @throws \Throwable
     *
     * @return array
     */
    protected function buildAwareOfComponent(array $component) : array
    {
        // Get the force flag, if set
        $force = $this->input->getOption('force');

        return $this->generator->generate($component, $force);
    }

    /**
     * Generates markdown documentation for given "aware-of" components.
     *
     * NOTE: Only if "docs-output" config set !
     *
     * @param array $awareOfComponents [optional]
     *
     * @throws \Throwable
     */
    protected function buildDocs(array $awareOfComponents = [])
    {
        // Get the force flag, if set
        $force = $this->input->getOption('force');

        $this->documenter->makeDocs($awareOfComponents, $force);
    }

    /**
     * Load the configuration
     *
     * @return self
     *
     * @throws InvalidArgumentException If path is invalid
     */
    protected function loadConfiguration()
    {
        $path = $this->input->getArgument('config');
        if( ! file_exists($path)){
            throw new InvalidArgumentException($path . ' is an invalid path. Configuration file does not exist');
        }

        // Load the configuration file
        /** @var array $content */
        $content = require $path;

        // Set repository
        $this->setConfig(new Repository($content));

        return $this;
    }

    /**
     * Setup the "aware-of" generator
     *
     * @return self
     */
    protected function setupGenerator()
    {
        $this->generator = new Generator($this->getConfig());

        return $this;
    }

    /**
     * Setup the "aware-of" documenter
     *
     * @return self
     */
    protected function setupDocumenter()
    {
        $this->documenter = new Documenter($this->getConfig());

        return $this;
    }

    /**
     * Outputs given component, if verbose
     *
     * @param array $awareOfComponentData
     */
    protected function debug(array $awareOfComponentData = [])
    {
        if($this->output->isVerbose()){
            $this->output->newLine();
            $this->output->text(var_export($awareOfComponentData, true));
            $this->output->newLine();
        }
    }

    /**
     * Formats and returns this commands help text
     *
     * @return string
     */
    protected function formatHelp()
    {
        return <<<EOT
Generates a series of aware-of components, based on given configuration

Usage:

<info>dto:create my-dto-list.php</info>

Force Flag:

If you set the force flag, then all existing interfaces and traits are overwritten.
This also applies to the generated markdown documentation!

<info>dto:create aware-of-properties.php --force</info>

EOT;
    }
}
