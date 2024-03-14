<?php

/*****************************************************************
 * DTO Properties Helpers
 ****************************************************************/

use Aedart\Contracts\Utils\DataTypes;

if (!function_exists('awareOfProperty')) {
    /**
     * Returns an array of configuration that allows a generator
     * to build an "aware-of property" component
     *
     * @param string $property Name of property
     * @param string $description Description of property
     * @param string $dataType [optional] Property data type. Defaults to "string" if none given.
     * @param string|null $inputArgName [optional] Name of property input argument (for setter method).
     *                                  If null given, then input argument name is the same as the property
     *
     * @return array
     */
    function awareOfProperty(
        string $property,
        string $description,
        string $dataType = DataTypes::STRING_TYPE,
        string|null $inputArgName = null
    ): array {
        $inputArgName = $inputArgName ?? $property;

        // Return data structure
        return [
            'property' => $property,
            'type' => $dataType,
            'description' => $description,
            'inputArgName' => $inputArgName,
        ];
    }
}

if (!function_exists('stringProperty')) {
    /**
     * Returns "string" aware-of property configuration
     *
     * @see awareOfProperty()
     *
     * @param string $name Name of property
     * @param string $description Description of property
     * @param string|null $inputName [optional] Name of property input argument (for setter method).
     *                                  If null given, then input argument name is the same as the property
     *
     * @return array
     */
    function stringProperty(string $name, string $description, string|null $inputName = null): array
    {
        return awareOfProperty(
            $name,
            $description,
            DataTypes::STRING_TYPE,
            $inputName
        );
    }
}

if (!function_exists('integerProperty')) {
    /**
     * Returns "integer" aware-of property configuration
     *
     * @see awareOfProperty()
     *
     * @param string $name Name of property
     * @param string $description Description of property
     * @param string|null $inputName [optional] Name of property input argument (for setter method).
     *                                  If null given, then input argument name is the same as the property
     *
     * @return array
     */
    function integerProperty(string $name, string $description, string|null $inputName = null): array
    {
        return awareOfProperty(
            $name,
            $description,
            DataTypes::INT_TYPE,
            $inputName
        );
    }
}

if (!function_exists('floatProperty')) {
    /**
     * Returns "float" aware-of property configuration
     *
     * @see awareOfProperty()
     *
     * @param string $name Name of property
     * @param string $description Description of property
     * @param string|null $inputName [optional] Name of property input argument (for setter method).
     *                                  If null given, then input argument name is the same as the property
     *
     * @return array
     */
    function floatProperty(string $name, string $description, string|null $inputName = null): array
    {
        return awareOfProperty(
            $name,
            $description,
            DataTypes::FLOAT_TYPE,
            $inputName
        );
    }
}

if (!function_exists('booleanProperty')) {
    /**
     * Returns "boolean" aware-of property configuration
     *
     * @see awareOfProperty()
     *
     * @param string $name Name of property
     * @param string $description Description of property
     * @param string|null $inputName [optional] Name of property input argument (for setter method).
     *                                  If null given, then input argument name is the same as the property
     *
     * @return array
     */
    function booleanProperty(string $name, string $description, string|null $inputName = null): array
    {
        return awareOfProperty(
            $name,
            $description,
            DataTypes::BOOL_TYPE,
            $inputName
        );
    }
}

if (!function_exists('arrayProperty')) {
    /**
     * Returns "array" aware-of property configuration
     *
     * @see awareOfProperty()
     *
     * @param string $name Name of property
     * @param string $description Description of property
     * @param string|null $inputName [optional] Name of property input argument (for setter method).
     *                                  If null given, then input argument name is the same as the property
     *
     * @return array
     */
    function arrayProperty(string $name, string $description, string|null $inputName = null): array
    {
        return awareOfProperty(
            $name,
            $description,
            DataTypes::ARRAY_TYPE,
            $inputName
        );
    }
}

if (!function_exists('callableProperty')) {
    /**
     * Returns "callable" aware-of property configuration
     *
     * @see awareOfProperty()
     *
     * @param string $name Name of property
     * @param string $description Description of property
     * @param string|null $inputName [optional] Name of property input argument (for setter method).
     *                                  If null given, then input argument name is the same as the property
     *
     * @return array
     */
    function callableProperty(string $name, string $description, string|null $inputName = null): array
    {
        return awareOfProperty(
            $name,
            $description,
            DataTypes::CALLABLE_TYPE,
            $inputName
        );
    }
}

if (!function_exists('iterableProperty')) {
    /**
     * Returns "iterable" aware-of property configuration
     *
     * @see awareOfProperty()
     *
     * @param string $name Name of property
     * @param string $description Description of property
     * @param string|null $inputName [optional] Name of property input argument (for setter method).
     *                                  If null given, then input argument name is the same as the property
     *
     * @return array
     */
    function iterableProperty(string $name, string $description, string|null $inputName = null): array
    {
        return awareOfProperty(
            $name,
            $description,
            DataTypes::ITERABLE_TYPE,
            $inputName
        );
    }
}

if (!function_exists('mixedProperty')) {
    /**
     * Returns "mixed" aware-of property configuration
     *
     * @see awareOfProperty()
     *
     * @param string $name Name of property
     * @param string $description Description of property
     * @param string|null $inputName [optional] Name of property input argument (for setter method).
     *                                  If null given, then input argument name is the same as the property
     *
     * @return array
     */
    function mixedProperty(string $name, string $description, string|null $inputName = null): array
    {
        return awareOfProperty(
            $name,
            $description,
            DataTypes::MIXED_TYPE,
            $inputName
        );
    }
}

if (!function_exists('dateTimeProperty')) {
    /**
     * Returns "DateTime" aware-of property configuration
     *
     * @see awareOfProperty()
     *
     * @param string $name Name of property
     * @param string $description Description of property
     * @param string|null $inputName [optional] Name of property input argument (for setter method).
     *                                  If null given, then input argument name is the same as the property
     *
     * @return array
     */
    function dateTimeProperty(string $name, string $description, string|null $inputName = null): array
    {
        return awareOfProperty(
            $name,
            $description,
            DataTypes::DATE_TIME_TYPE,
            $inputName
        );
    }
}
