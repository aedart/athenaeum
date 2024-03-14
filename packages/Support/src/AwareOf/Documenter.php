<?php

namespace Aedart\Support\AwareOf;

use Aedart\Contracts\Support\Helpers\Config\ConfigAware;
use Aedart\Support\AwareOf\Partials\TwigPartial;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Support\Arr;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class Documenter implements ConfigAware
{
    use TwigPartial;

    /**
     * Template for markdown document
     *
     * @var string
     */
    protected string $docsTemplate = 'docs.md.twig';

    /**
     * Generator constructor.
     *
     * @param Repository|null $configuration [optional]
     */
    public function __construct(Repository|null $configuration = null)
    {
        $this
            ->setConfig($configuration)
            ->setupTwig();
    }

    /**
     * Generates a single markdown file for the given aware-of
     * components
     *
     * @param array $awareOfComponents [optional]
     * @param bool $force [optional] If true, then existing file is overwritten
     *
     * @throws LoaderError  When the template cannot be found
     * @throws SyntaxError  When an error occurred during compilation
     * @throws RuntimeError When an error occurred during rendering
     */
    public function makeDocs(array $awareOfComponents = [], bool $force = false)
    {
        $destination = $this->getConfig()->get('docs-output', false);
        if (!$destination || empty($awareOfComponents)) {
            return;
        }

        // Make template data
        $data = [
            'components' => $this->format($awareOfComponents)
        ];

        //dd($data);

        $this->generateFile($this->docsTemplate, $destination, $data, $force);
    }

    /*****************************************************************
     * Internals
     ****************************************************************/

    /**
     * Formats given list of "aware-of" components
     *
     * @param array $awareOfComponents
     *
     * @return array
     */
    protected function format(array $awareOfComponents): array
    {
        $output = [];
        foreach ($awareOfComponents as $component) {
            // Make key (index
            $letter = strtoupper(substr($component['propertyName'], 0, 1));
            $index = $letter . '.' . $component['propertyName'] . '.' . $component['dataType'];

            // Store component acc. to index
            Arr::set($output, $index, [
                'description' => $component['propertyDescription'],
                'interface' => $component['interfaceNamespace'] . '\\' . $component['interfaceClassName'],
                'trait' => $component['traitNamespace'] . '\\' . $component['traitClassName'],
            ]);
        }

        ksort($output);

        return $output;
    }
}
