<?php

namespace Aedart\Support\AwareOf\Partials;

use Aedart\Support\Helpers\Config\ConfigTrait;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;
use Twig\Loader\FilesystemLoader;

/**
 * Twig Template Engine Partial
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\AwareOf\Partials
 */
trait TwigPartial
{
    use ConfigTrait;

    /**
     * Twig Template Engine
     *
     * @var Environment|null
     */
    protected Environment|null $twig;

    /**
     * Setup the twig template engine
     *
     * @return self
     */
    public function setupTwig(): static
    {
        $path = $this->getConfig()->get('templates-path', $this->defaultTemplatesPath());

        // Create new loader for twig
        $loader = new FilesystemLoader($path);

        // Create twig engine
        $this->twig = new Environment($loader, $this->twigEngineOptions());

        return $this;
    }

    /**
     * Generate file
     *
     * @param string $template Path to template
     * @param string $destination File destination, including filename
     * @param array $data Template data to render
     * @param bool $force [optional] If true, then existing file is overwritten
     *
     * @throws LoaderError  When the template cannot be found
     * @throws SyntaxError  When an error occurred during compilation
     * @throws RuntimeError When an error occurred during rendering
     */
    public function generateFile(string $template, string $destination, array $data, bool $force = false)
    {
        // Remove existing file, if force flag set
        if ($force && file_exists($destination)) {
            unlink($destination);
        } elseif (file_exists($destination)) {
            // Otherwise abort if file exists...
            return;
        }

        // Prepare destination; create directories if needed
        $this->prepareOutputDirectory($destination);

        // Render template
        $content = $this->twig->render($template, $data);

        // Finally, write the file
        file_put_contents($destination, $content, FILE_APPEND | LOCK_EX);
    }

    /**
     * Creates nested directories for the given file path
     *
     * @param string $filePath
     */
    public function prepareOutputDirectory(string $filePath)
    {
        $directory = pathinfo($filePath, PATHINFO_DIRNAME);
        if (is_dir($directory)) {
            return;
        }

        @mkdir($directory, 0755, true);
    }

    /**
     * Returns twig template engine options
     *
     * @return array
     */
    public function twigEngineOptions(): array
    {
        return [
            'debug' => true,
            'strict_variables' => true,
        ];
    }

    /**
     * Returns the default path to the twig templates directory
     *
     * @return string
     */
    public function defaultTemplatesPath(): string
    {
        return __DIR__ . '/../../../resources/templates/aware-of-component/';
    }
}
