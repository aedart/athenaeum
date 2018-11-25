<?php

namespace Aedart\Console;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputOption;

/**
 * Aware Of Scaffold Command
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Console
 */
class AwareOfScaffoldCommand extends CommandBase
{
    /*****************************************************************
     * Command Configuration
     ****************************************************************/

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('dto:scaffold')
            ->setDescription('Creates a configuration file that can e used by the "dto:create-aware-of" command')
            ->addOption('output', 'o', InputOption::VALUE_OPTIONAL, 'Directory where to create configuration file', getcwd())
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
        $fs = new Filesystem();
        $target = __DIR__ . '/../../configs/aware-of-properties.php';
        $output = $this->input->getOption('output');

        // Add trailing slash if needed
        if( ! Str::endsWith($output, DIRECTORY_SEPARATOR)){
            $output .= DIRECTORY_SEPARATOR;
        }

        // Abort if config file already exists
        $destination = $output . 'aware-of-properties.php';
        if($fs->exists($destination)){
            $this->output->warning($destination . ' already exists. Aborting!');
            return 1;
        }

        // Create nested directories, if required
        $fs->makeDirectory($output, 0755, true);

        // Copy the configuration file
        $fs->copy($target, $destination);
        $this->output->success('Created ' . $destination);

        return 0;
    }

    /*****************************************************************
     * Internals
     ****************************************************************/

    /**
     * Formats and returns this commands help text
     *
     * @return string
     */
    protected function formatHelp()
    {
        return <<<EOT
Creates a configuration file that can e used by the "dto:create-aware-of" command

Usage:

<info>php athenaeum dto:scaffold</info>

You can optionally also specify the output directory where the configuration file
should be created.

<info>php athenaeum dto:scaffold --output configs/dto</info>

EOT;
    }
}