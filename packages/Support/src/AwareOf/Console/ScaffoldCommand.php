<?php

namespace Aedart\Support\AwareOf\Console;

use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputOption;

/**
 * Scaffold Command
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\AwareOf\Console
 */
class ScaffoldCommand extends CommandBase
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
            ->setDescription('Creates a configuration file that can e used by the "create" command')
            ->addOption('output', 'o', InputOption::VALUE_OPTIONAL, 'Directory where to create configuration file', getcwd())
            ->setHelp($this->formatHelp());
    }

    /*****************************************************************
     * Run Command
     ****************************************************************/

    /**
     * {@inheritdoc}
     */
    public function runCommand(): int|null
    {
        $target = __DIR__ . '/../../../configs/aware-of-properties.php';
        $output = $this->input->getOption('output');

        // Add trailing slash if needed
        if (!Str::endsWith($output, DIRECTORY_SEPARATOR)) {
            $output .= DIRECTORY_SEPARATOR;
        }

        // Abort if config file already exists
        $destination = $output . 'aware-of-properties.php';
        if (file_exists($destination)) {
            $this->output->warning($destination . ' already exists. Aborting!');
            return 1;
        }

        // Create nested directories, if required
        if (mkdir($output, 0755, true) === false) {
            $this->output->error('unable to create directory: ' . $output);
            return 2;
        }

        // Copy the configuration file
        if (copy($target, $destination) === false) {
            $this->output->error('unable to copy scaffold into ' . $output);
            return 2;
        }

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
    protected function formatHelp(): string
    {
        return <<<EOT
Creates a configuration file that can e used by the "create" command

Usage:

<info>dto:scaffold scaffold</info>

You can optionally also specify the output directory where the configuration file
should be created.

<info>dto:scaffold --output configs/dto</info>

EOT;
    }
}
