<?php

/*****************************************************************
 * DTO Properties Helpers
 ****************************************************************/

use Aedart\Contracts\Utils\DataTypes;

if( ! function_exists('awareOfProperty')){

    /**
     * Returns an array of configuration that allows a generator
     * to build an "aware-of property" component
     *
     * @param string $property Name of property
     * @param string $description Description of property
     * @param string $dataType [optional] Property scalar data type
     * @param string $inputArgName [optional] Name of property input argument (for setter method)
     * @param string $traitNamespace [optional] Namespace for aware-of trait implementation
     * @param string $interfaceNamespace [optional] Namespace for aware-of interface implementation
     * @param string $author [optional] Author name
     * @param string $email [optional] Author's email
     * @param string|null $outputLocation [optional] Output location, e.g. 'src/'.
     *                                     If null given, then current working directory is used
     *
     * @return array
     */
    function awareOfProperty(
        string $property,
        string $description,
        string $dataType = DataTypes::STRING_TYPE,
        string $inputArgName = 'value',
        string $traitNamespace = 'Acme\\Strings',
        string $interfaceNamespace = 'Acme\\Contracts\\Strings',
        string $author = 'John Doe',
        string $email = 'john.doe@example.org',
        ?string $outputLocation = null
    ) : array
    {
        // Set output if needed
        $outputLocation = $outputLocation ?? getcwd();

        // Return data structure
        return [
            'output'                => $outputLocation,
            'property'              => $property,
            'type'                  => $dataType,
            'description'           => $description,
            'inputArgName'          => $inputArgName,
            'traitNamespace'        => $traitNamespace,
            'interfaceNamespace'    => $interfaceNamespace,
            'author'                => $author,
            'email'                 => $email
        ];
    }
}
