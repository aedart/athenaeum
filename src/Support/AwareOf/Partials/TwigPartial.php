<?php

namespace Aedart\Support\AwareOf\Partials;

use Aedart\Support\Helpers\Config\ConfigTrait;
use Twig_Environment;
use Twig_Loader_Filesystem;

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
     * @var Twig_Environment
     */
    protected $twig;

    /**
     * Setup the twig template engine
     *
     * @return self
     */
    public function setupTwig()
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
    public function twigEngineOptions() : array
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
    public function defaultTemplatesPath() : string
    {
        return __DIR__ . '/../../../../resources/templates/aware-of-component/';
    }
}