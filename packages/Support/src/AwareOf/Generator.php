<?php

namespace Aedart\Support\AwareOf;

use Aedart\Contracts\Support\Helpers\Config\ConfigAware;
use Aedart\Support\AwareOf\Partials\TwigPartial;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Support\Str;
use Throwable;

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
    use TwigPartial;

    /**
     * Template for interface
     *
     * @var string
     */
    protected string $interfaceTemplate = 'interface.php.twig';

    /**
     * Template for trait
     *
     * @var string
     */
    protected string $traitTemplate = 'trait.php.twig';

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
     * Generate the given component
     *
     * @param array $component [optional]
     * @param bool $force [optional] If true, then existing file is overwritten
     *
     * @throws Throwable
     *
     * @return array Data about the generated aware-of component
     */
    public function generate(array $component = [], bool $force = false): array
    {
        // Abort if nothing given
        if (empty($component)) {
            return [];
        }

        // Format the various template variables
        $property = $this->property($component['property']);
        $propertyMethod = $this->propertyMethod($property);
        $propertyInDescription = $this->propertyInDescription($property);
        $propertyInTitle = $this->propertyInTitle($property);
        $type = $this->type($component['type']);
        $description = $this->description($component['description']);
        $input = $this->inputArgument($component['inputArgName']);

        $interfaceNamespace = $this->interfaceNamespace($type);
        $interfaceClass = $this->interfaceClass($property);
        $interfaceFile = $this->interfaceFileLocation($interfaceClass, $interfaceNamespace);

        $traitNamespace = $this->traitNamespace($type);
        $traitClass = $this->traitClass($property);
        $traitFile = $this->traitFileLocation($traitClass, $traitNamespace);

        $author = $this->author();
        $email = $this->email();

        // Format context array for template
        $data = [
            'interfaceNamespace' => $interfaceNamespace,
            'interfaceClassName' => $interfaceClass,
            'interfaceFile' => $interfaceFile,
            'interfaceTemplate' => $this->interfaceTemplate,
            'traitNamespace' => $traitNamespace,
            'traitClassName' => $traitClass,
            'traitFile' => $traitFile,
            'traitTemplate' => $this->traitTemplate,
            'title' => $propertyInTitle,
            'dataType' => $type,
            'coreProperty' => $property,
            'propertyName' => $propertyMethod,
            'propertyDescription' => $description,
            'propertyInDescription' => $propertyInDescription,
            'inputArgument' => $input,
            'author' => $author,
            'email' => $email
        ];

        // Generate interface and trait
        $this->generateFile($this->interfaceTemplate, $interfaceFile, $data, $force);
        $this->generateFile($this->traitTemplate, $traitFile, $data, $force);

        // Return the generated data
        return $data;
    }

    /*****************************************************************
     * Internals
     ****************************************************************/

    /**
     * Formats the "core" property name
     *
     * @param string $name Name of property
     *
     * @return string
     */
    protected function property(string $name): string
    {
        return lcfirst(Str::studly(trim($name)));
    }

    /**
     * Formats the property to be used within a "method name" context
     *
     * @param string $name
     *
     * @return string
     */
    protected function propertyMethod(string $name): string
    {
        return ucfirst($name);
    }

    /**
     * Formats the property to be used within a "descriptive" context
     *
     * @param string $property
     *
     * @return string
     */
    protected function propertyInDescription(string $property): string
    {
        $property = Str::snake($property);
        return str_replace('_', ' ', $property);
    }

    /**
     * Formats the property to be used within a "title" context
     *
     * @param string $property
     *
     * @return string
     */
    protected function propertyInTitle(string $property): string
    {
        return ucfirst($this->propertyInDescription($property));
    }

    /**
     * Formats the given data type
     *
     * @param string $type
     *
     * @return string
     */
    protected function type(string $type): string
    {
        return trim($type);
    }

    /**
     * Formats the given description
     *
     * @param string $description
     *
     * @return string
     */
    protected function description(string $description): string
    {
        return trim(ucfirst($description));
    }

    /**
     * Formats the given input argument name
     *
     * @param string $name
     *
     * @return string
     */
    protected function inputArgument(string $name): string
    {
        return lcfirst(Str::studly(trim($name)));
    }

    /**
     * Computes namespace for the aware-of interface implementation
     *
     * @param string $type
     *
     * @return string
     */
    protected function interfaceNamespace(string $type): string
    {
        $config = $this->getConfig();

        $vendor = $this->interfaceVendorNamespace();
        $prefix = $config->get('namespaces.interfaces.prefix', 'Contracts\\');
        $typeNamespace = $this->interfaceTypeNamespace($type);

        return Str::replaceLast('\\', '', $vendor . $prefix . $typeNamespace);
    }

    /**
     * Computes namespace for the aware-of trait implementation
     *
     * @param string $type
     *
     * @return string
     */
    protected function traitNamespace(string $type): string
    {
        $config = $this->getConfig();

        $vendor = $this->traitVendorNamespace();
        $prefix = $config->get('namespaces.traits.prefix', 'Traits\\');
        $typeNamespace = $this->traitTypeNamespace($type);

        return Str::replaceLast('\\', '', $vendor . $prefix . $typeNamespace);
    }

    /**
     * Returns the "type" sub-namespace for an "aware-of" interface component
     *
     * @param string $type
     *
     * @return string
     */
    protected function interfaceTypeNamespace(string $type): string
    {
        return $this->getConfig()->get('namespaces.interfaces.' . $type, '');
    }

    /**
     * Returns the "type" sub-namespace for an "aware-of" trait component
     *
     * @param string $type
     *
     * @return string
     */
    protected function traitTypeNamespace(string $type): string
    {
        return $this->getConfig()->get('namespaces.traits.' . $type, '');
    }

    /**
     * Formats the interface class name, based on property's name
     *
     * @param string $property
     *
     * @return string
     */
    protected function interfaceClass(string $property): string
    {
        return ucfirst($property) . 'Aware';
    }

    /**
     * Formats the trait class name, based on property's name
     *
     * @param string $property
     *
     * @return string
     */
    protected function traitClass(string $property): string
    {
        return ucfirst($property) . 'Trait';
    }

    /**
     * Computes the file location for given interface file
     *
     * @param string $class Class name
     * @param string $namespace Class namespace
     *
     * @return string
     */
    protected function interfaceFileLocation(string $class, string $namespace): string
    {
        $vendor = $this->interfaceVendorNamespace();
        $outputDirectory = $this->interfaceOutputDirectory();

        return $this->fileLocation($class, $namespace, $vendor, $outputDirectory);
    }

    /**
     * Computes the file location for given trait file
     *
     * @param string $class Class name
     * @param string $namespace Class namespace
     *
     * @return string
     */
    protected function traitFileLocation(string $class, string $namespace): string
    {
        $vendor = $this->traitVendorNamespace();
        $outputDirectory = $this->traitOutputDirectory();

        return $this->fileLocation($class, $namespace, $vendor, $outputDirectory);
    }

    /**
     * Computes the file location for given interface or trait file
     *
     * @param string $class Class name
     * @param string $namespace Class namespace
     * @param string $vendor Specific vendor namespace
     * @param string $outputDirectory Output directory
     *
     * @return string
     */
    protected function fileLocation(
        string $class,
        string $namespace,
        string $vendor,
        string $outputDirectory
    ): string {
        $class .= '.php';
        $namespace = str_replace($vendor, '', $namespace);
        $destination = $outputDirectory . str_replace('\\', DIRECTORY_SEPARATOR, $namespace);

        return $destination . DIRECTORY_SEPARATOR . $class;
    }

    /**
     * Returns the author
     *
     * @return string
     */
    protected function author(): string
    {
        return $this->getConfig()->get('author', 'John Doe');
    }

    /**
     * Returns author's email
     *
     * @return string
     */
    protected function email(): string
    {
        return $this->getConfig()->get('email', 'john.doe@example.org');
    }

    /**
     * Returns the vendor namespace
     *
     * @return string
     */
    protected function vendor(): string
    {
        return $this->getConfig()->get('namespaces.vendor', 'Acme\\');
    }

    /**
     * Returns the output directory
     *
     * @return string
     */
    protected function outputDirectory(): string
    {
        return $this->getConfig()->get('output', 'src/');
    }

    /**
     * Returns the vendor namespace for interfaces
     *
     * @return string Specific namespace or defaults to vendor namespace
     */
    protected function interfaceVendorNamespace(): string
    {
        return $this->getConfig()->get(
            'namespaces.interfaces.vendor',
            $this->vendor()
        );
    }

    /**
     * Returns the vendor namespace for traits
     *
     * @return string Specific namespace or defaults to vendor namespace
     */
    protected function traitVendorNamespace(): string
    {
        return $this->getConfig()->get(
            'namespaces.traits.vendor',
            $this->vendor()
        );
    }

    /**
     * Returns output directory for interfaces
     *
     * @see outputDirectory
     *
     * @return string Specific or defaults to output directory
     */
    protected function interfaceOutputDirectory(): string
    {
        return $this->getConfig()->get(
            'namespaces.interfaces.output',
            $this->outputDirectory()
        );
    }

    /**
     * Returns output directory for traits
     *
     * @see outputDirectory
     *
     * @return string Specific or defaults to output directory
     */
    protected function traitOutputDirectory(): string
    {
        return $this->getConfig()->get(
            'namespaces.traits.output',
            $this->outputDirectory()
        );
    }
}
