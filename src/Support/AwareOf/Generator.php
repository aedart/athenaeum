<?php

namespace Aedart\Support\AwareOf;

use Aedart\Contracts\Support\Helpers\Config\ConfigAware;
use Aedart\Support\Helpers\Config\ConfigTrait;
use Illuminate\Contracts\Config\Repository;
use Twig_Environment;
use Twig_Loader_Filesystem;

/**
 * Aware-Of Generator
 *
 * <br />
 *
 * Able to generate an "aware-of component", based on
 * a given set of configuration.
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\AwareOf
 */
class Generator implements ConfigAware
{
    use ConfigTrait;

    /**
     * Twig Template Engine
     *
     * @var Twig_Environment
     */
    protected $twig;

    /**
     * Generator constructor.
     *
     * @param Repository|null $configuration [optional]
     */
    public function __construct(?Repository $configuration = null)
    {
        $this
            ->setConfig($configuration)
            ->setupTwig();
    }

    // TODO
    public function generate(array $component = [])
    {

    }

    /*****************************************************************
     * Internals
     ****************************************************************/

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
}
