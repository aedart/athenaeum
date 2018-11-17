<?php

use Aedart\Contracts\Utils\DataTypes;

return [
    /*****************************************************************
     * Aware-Of Properties Generator Configuration
     ****************************************************************/

    /*
     * Author and email
     */
    'author'    => 'John Doe',
    'email'     => 'john.doe@example.org',

    /*
     * Location where files are to be generated
     */
    'output'    => 'src/',

    /*****************************************************************
     * Namespaces to use
     ****************************************************************/

    'namespaces' => [

        /*
         * Namespaces for interfaces
         */
        'interfaces' => [

            /*
             * Prefix for all interfaces
             */
            'prefix'  => 'Acme\\Contracts\\',

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
        ],

        /*
         * Namespaces for interfaces
         */
        'traits' => [

            /*
             * Prefix for all traits
             */
            'prefix'  => 'Acme\\Traits\\',

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
