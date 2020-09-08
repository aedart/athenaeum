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
     *
     * E.g. Psr-4 namespace location
     */
    'output'    => 'tests/_output/aware-of/',

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
     * Documentation location
     ****************************************************************/

    /*
     * Location where a markdown file is to be generated.
     * Omit if no document should be generated.
     *
     * @var string
     */
    'docs-output' => 'tests/_output/aware-of/README.md',

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
             * Prefix for all interfaces
             */
            'prefix'  => 'Contracts\\',

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
            DataTypes::MIXED_TYPE       => 'Mixes\\',
            DataTypes::DATE_TIME_TYPE   => 'Dates\\',
        ],

        /*
         * Namespaces for interfaces
         */
        'traits' => [

            /*
             * Prefix for all traits
             */
            'prefix'  => 'Traits\\',

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
            DataTypes::MIXED_TYPE       => 'Mixes\\',
            DataTypes::DATE_TIME_TYPE   => 'Dates\\',
        ],
    ],

    /*****************************************************************
     * List of Aware-Of Components to generate
     ****************************************************************/

    'aware-of-properties' => [

        stringProperty('name', 'Name of a person', 'name'),
        integerProperty('age', 'Age of a person', 'years'),
        floatProperty('price', 'Price of something', 'price'),
        booleanProperty('is destroyed', 'State of a player', 'state'),
        arrayProperty('categories', 'List of categories', 'categories'),
        callableProperty('callback', 'A callback method', 'callback'),
        iterableProperty('persons', 'List of persons', 'persons'),
        mixedProperty('player', 'A player instance', 'player'),
        dateTimeProperty('created at', 'Date of creation', 'date'),
    ]
];
