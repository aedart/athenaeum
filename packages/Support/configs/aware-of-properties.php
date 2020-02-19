<?php

use Aedart\Contracts\Utils\DataTypes;

return [
    /*****************************************************************
     * Aware-Of Properties Generator Configuration
     ****************************************************************/

    /*
     * Author and email
     */
    'author' => 'John Doe',
    'email' => 'john.doe@example.org',

    /*
     * Location where files are to be generated
     *
     * E.g. Psr-4 namespace location
     */
    'output' => 'src/',

    /*****************************************************************
     * Templates location
     ****************************************************************/

    /*
     * If none is given, then default twig templates are used
     *
     * @var string|array
     */
    //'templates-path' => '',

    /*****************************************************************
     * Documentation
     ****************************************************************/

    /*
     * Location where a markdown file is to be generated.
     * Omit if no document should be generated.
     *
     * @var string
     */
    //'docs-output' => 'docs/aware-of-properties.md',

    /*****************************************************************
     * Namespaces to use
     ****************************************************************/

    'namespaces' => [

        /*
         * Vendor namespace to apply on all generated
         * namespaces.
         */
        'vendor' => 'Acme\\',

        /*
         * Namespaces for interfaces
         */
        'interfaces' => [

            /*
             * Vendor namespace overwrite for interfaces
             */
            //'vendor' => 'Acme\\PackageA\\',

            /*
             * Prefix for all interfaces
             */
            'prefix' => 'Contracts\\',

            /**
             * Path overwrite for interfaces
             *
             * Uses "output" if not given
             */
            //'output'  => 'package/Contracts/src/',

            /*
             * Namespaces for various data types
             */
            DataTypes::STRING_TYPE => 'Strings\\',
            DataTypes::INT_TYPE => 'Integers\\',
            DataTypes::FLOAT_TYPE => 'Floats\\',
            DataTypes::BOOL_TYPE => 'Booleans\\',
            DataTypes::ARRAY_TYPE => 'Arrays\\',
            DataTypes::CALLABLE_TYPE => 'Callables\\',
            DataTypes::ITERABLE_TYPE => 'Iterators\\',
            DataTypes::MIXED_TYPE => 'Mixed\\',
            DataTypes::DATE_TIME_TYPE => 'Dates\\',
        ],

        /*
         * Namespaces for interfaces
         */
        'traits' => [

            /*
             * Vendor namespace overwrite for traits
             */
            //'vendor' => 'Acme\\PackageB\\',

            /*
             * Prefix for all traits
             */
            'prefix' => 'Traits\\',

            /**
             * Path overwrite for traits
             *
             * Uses "output" if not given
             */
            //'output'  => 'package/Support/src/',

            /*
             * Namespaces for various data types
             */
            DataTypes::STRING_TYPE => 'Strings\\',
            DataTypes::INT_TYPE => 'Integers\\',
            DataTypes::FLOAT_TYPE => 'Floats\\',
            DataTypes::BOOL_TYPE => 'Booleans\\',
            DataTypes::ARRAY_TYPE => 'Arrays\\',
            DataTypes::CALLABLE_TYPE => 'Callables\\',
            DataTypes::ITERABLE_TYPE => 'Iterators\\',
            DataTypes::MIXED_TYPE => 'Mixed\\',
            DataTypes::DATE_TIME_TYPE => 'Dates\\',
        ],
    ],

    /*****************************************************************
     * List of Aware-Of Components to generate
     ****************************************************************/

    'aware-of-properties' => [

        //stringProperty('name', 'Name of a person', 'name'),
        //stringProperty('description', 'Description of something', 'description'),
        //integerProperty('age', 'Age of a person', 'years'),
    ]
];
