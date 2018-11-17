<?php

namespace Aedart\Console;

use Aedart\Support\Helpers\Config\ConfigTrait;
use Illuminate\Config\Repository;
use InvalidArgumentException;
use Symfony\Component\Console\Input\InputArgument;
use Twig_Environment;
use Twig_Loader_Filesystem;

/**
 * Create Aware Of Properties Command
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Console
 */
class CreateAwareOfCommand extends CommandBase
{
    use ConfigTrait;

    /**
     * Twig Template Engine
     *
     * @var Twig_Environment
     */
    protected $twig;

    /*****************************************************************
     * Command Configuration
     ****************************************************************/

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('dto:create-aware-of')
            ->setDescription('Generates a series of aware-of components, based on given configuration')
            ->addArgument('config', InputArgument::REQUIRED, 'Path to php configuration file')
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
            ->setupTwig()
            ->build();

        $this->output->success('done');

        return 0;
    }

    /*****************************************************************
     * Internals
     ****************************************************************/

    /**
     * Builds the aware-of components
     */
    protected function build()
    {
        // Get list of components to build
        $list = $this->getConfig()->get('aware-of-properties', []);

        // Create new process bar
        $this->output->progressStart(count($list));

        // Build each aware-of component
        foreach ($list as $component){
            $this->buildAwareOfComponent($component);
            $this->output->progressAdvance();
        }

        // Complete the progress bar
        $this->output->progressFinish();
    }

    // TODO: incomplete!
    protected function buildAwareOfComponent(array $component)
    {
        // TODO: Puhh... lots of things that need to happen here...
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
     * Setup the twig template engine
     *
     * @return self
     */
    protected function setupTwig()
    {
        $path = $this->getConfig()->get('templates-path', $this->defaultTemplatesPath());

        // Create new loader for twig
        $loader = new Twig_Loader_Filesystem($path);

        // Create twig engine
        $this->twig = new Twig_Environment($loader, $this->twigEngineOptions());

        return $this;
    }

    /**
     * Returns twig template engine options
     *
     * @return array
     */
    protected function twigEngineOptions() : array
    {
        return [
            'debug'                 => true,
            'strict_variables'      => true,
        ];
    }

    /**
     * Returns the default path to the twig templates directory
     *
     * @return string
     */
    protected function defaultTemplatesPath() : string
    {
        return __DIR__ . '../../resources/templates/aware-of-component';
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

<info>php athenaeum dto:create-aware-of my-dto-list.php</info>

EOT;
    }
}
