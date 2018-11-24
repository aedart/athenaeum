<?php

use Aedart\Contracts\Utils\DataTypes;

return [
    /*****************************************************************
     * Aware-Of Properties Generator Configuration
     ****************************************************************/

    /*
     * Author and email
     */
    'author'    => 'Alin Eugen Deac',
    'email'     => 'aedart@gmail.com',

    /*
     * Location where files are to be generated
     *
     * E.g. Psr-4 namespace location
     */
    'output'    => 'src/',

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
     * Namespaces to use
     ****************************************************************/

    'namespaces' => [

        /*
         * Vendor namespace to apply on all generated
         * namespaces.
         */
        'vendor' => 'Aedart\\',

        /*
         * Namespaces for interfaces
         */
        'interfaces' => [

            /*
             * Prefix for all interfaces
             */
            'prefix'  => 'Contracts\\Support\\Properties\\',

            /*
             * Namespaces for various data types
             */
            DataTypes::STRING_TYPE      => 'Strings\\',
            DataTypes::INT_TYPE         => 'Integers\\',
            DataTypes::FLOAT_TYPE       => 'Floats\\',
            DataTypes::BOOL_TYPE        => 'Booleans\\',
            DataTypes::ARRAY_TYPE       => 'Arrays\\',
            DataTypes::CALLABLE_TYPE    => 'Callables\\',
            DataTypes::ITERABLE_TYPE    => 'Iterators\\',
            DataTypes::MIXED_TYPE       => 'Mixed\\',
        ],

        /*
         * Namespaces for interfaces
         */
        'traits' => [

            /*
             * Prefix for all traits
             */
            'prefix'  => 'Support\\Properties\\',

            /*
             * Namespaces for various data types
             */
            DataTypes::STRING_TYPE      => 'Strings\\',
            DataTypes::INT_TYPE         => 'Integers\\',
            DataTypes::FLOAT_TYPE       => 'Floats\\',
            DataTypes::BOOL_TYPE        => 'Booleans\\',
            DataTypes::ARRAY_TYPE       => 'Arrays\\',
            DataTypes::CALLABLE_TYPE    => 'Callables\\',
            DataTypes::ITERABLE_TYPE    => 'Iterators\\',
            DataTypes::MIXED_TYPE       => 'Mixed\\',
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
