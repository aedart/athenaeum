<?php

namespace Aedart\Support\AwareOf;

use Aedart\Contracts\Support\Helpers\Config\ConfigAware;
use Aedart\Support\Helpers\Config\ConfigTrait;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Support\Str;
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
     * Template for interface
     *
     * @var string
     */
    protected $interfaceTemplate = 'interface.php.twig';

    /**
     * Template for trait
     *
     * @var string
     */
    protected $traitTemplate = 'trait.php.twig';

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

    /**
     * Generate the given component
     *
     * @param array $component [optional]
     *
     * @throws \Throwable
     */
    public function generate(array $component = [])
    {
        // Abort if nothing given
        if(empty($component)){
            return;
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
        $interfaceFile = $this->fileLocation($interfaceClass, $interfaceNamespace);

        $traitNamespace = $this->traitNamespace($type);
        $traitClass = $this->traitClass($property);
        $traitFile = $this->fileLocation($traitClass, $traitNamespace);

        $author = $this->author();
        $email = $this->email();

        // Format context array for template
        $data = [
            'interfaceNamespace'    => $interfaceNamespace,
            'interfaceClassName'    => $interfaceClass,
            'interfaceFile'         => $interfaceFile,
            'interfaceTemplate'     => $this->interfaceTemplate,
            'traitNamespace'        => $traitNamespace,
            'traitClassName'        => $traitClass,
            'traitFile'             => $traitFile,
            'traitTemplate'         => $this->traitTemplate,
            'title'                 => $propertyInTitle,
            'dataType'              => $type,
            'coreProperty'          => $property,
            'propertyName'          => $propertyMethod,
            'propertyDescription'   => $description,
            'propertyInDescription' => $propertyInDescription,
            'inputArgument'         => $input,
            'author'                => $author,
            'email'                 => $email
        ];

        // Generate interface and trait
        $this->generateFile($this->interfaceTemplate, $interfaceFile, $data);
        $this->generateFile($this->traitTemplate, $traitFile, $data);
    }

    /*****************************************************************
     * Internals
     ****************************************************************/

    /**
     * Generate file
     *
     * @param string $template Path to template
     * @param string $destination File destination, including filename
     * @param array $data Template data to render
     *
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    protected function generateFile(string $template, string $destination, array $data)
    {
        // Abort if file already exists
        if(file_exists($destination)){
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
    protected function prepareOutputDirectory(string $filePath)
    {
        $directory = pathinfo($filePath, PATHINFO_DIRNAME);
        if(is_dir($directory)){
            return;
        }

        @mkdir($directory, 0755, true);
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
        return __DIR__ . '/../../../resources/templates/aware-of-component/';
    }

    /**
     * Formats the "core" property name
     *
     * @param string $name Name of property
     *
     * @return string
     */
    protected function property(string $name) : string
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
    protected function propertyMethod(string $name) : string
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
    protected function propertyInDescription(string $property) : string
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
    protected function propertyInTitle(string $property) : string
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
    protected function type(string $type) : string
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
    protected function description(string $description) : string
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
    protected function inputArgument(string $name) : string
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
    protected function interfaceNamespace(string $type) : string
    {
        $config = $this->getConfig();

        $vendor = $this->vendor();
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
    protected function traitNamespace(string $type) : string
    {
        $config = $this->getConfig();

        $vendor = $this->vendor();
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
    protected function interfaceTypeNamespace(string $type) : string
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
    protected function traitTypeNamespace(string $type) : string
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
    protected function interfaceClass(string $property) : string
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
    protected function traitClass(string $property) : string
    {
        return ucfirst($property) . 'Trait';
    }

    /**
     * Computes the file location for given interface or trait file
     *
     * @param string $class Class name
     * @param string $namespace Class namespace
     *
     * @return string
     */
    protected function fileLocation(string $class, string $namespace) : string
    {
        $class = $class . '.php';
        $namespace = str_replace($this->vendor(), '', $namespace);
        $destination = $this->outputDirectory() . str_replace('\\', DIRECTORY_SEPARATOR, $namespace);

        return $destination . DIRECTORY_SEPARATOR . $class;
    }

    /**
     * Returns the author
     *
     * @return string
     */
    protected function author() : string
    {
        return $this->getConfig()->get('author', 'John Doe');
    }

    /**
     * Returns author's email
     *
     * @return string
     */
    protected function email() : string
    {
        return $this->getConfig()->get('email', 'john.doe@example.org');
    }

    /**
     * Returns the vendor namespace
     *
     * @return string
     */
    protected function vendor() : string
    {
        return $this->getConfig()->get('vendor', 'Acme\\');
    }

    /**
     * Returns the output directory
     *
     * @return string
     */
    protected function outputDirectory() : string
    {
        return $this->getConfig()->get('output', 'src/');
    }
}
