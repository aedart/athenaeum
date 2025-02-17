<?php

/*****************************************************************
 * @deprecated Since version 9.x. Component will be removed in next major version.
 ****************************************************************/


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
    'output'    => 'packages/',

    /*****************************************************************
     * Templates location
     ****************************************************************/

    /*
     * If none is given, then default twig templates are used
     *
     * @var string|array
     */
    'templates-path' => [
        'packages/Support/resources/athenaeum/templates/aware-of/',
        'packages/Support/resources/templates/aware-of-component/',
    ],

    /*****************************************************************
     * Documentation
     ****************************************************************/

    /*
     * Location where a markdown file is to be generated.
     * Omit if no document should be generated.
     *
     * @var string
     */
    'docs-output' => 'docs/archive/current/support/properties/available-helpers.md',

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
             * Vendor namespace overwrite for interfaces
             */
            'vendor' => 'Aedart\\Contracts\\',

            /*
             * Prefix for all interfaces
             */
            'prefix'  => 'Support\\Properties\\',

            /**
             * Path overwrite for interfaces
             *
             * Uses "output" if not given
             */
            'output'  => 'packages/Contracts/src/',

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
             * Vendor namespace overwrite for interfaces
             */
            'vendor' => 'Aedart\\Support\\',

            /*
             * Prefix for all traits
             */
            'prefix'  => 'Properties\\',

            /**
             * Path overwrite for traits
             *
             * Uses "output" if not given
             */
            'output'  => 'packages/Support/src/',

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

        // -------------------------------------------------------------------------------------
        // A
        // -------------------------------------------------------------------------------------

        stringProperty(
            'action',
            'A process or fact of doing something',
            'action'
        ),
        callableProperty(
            'action',
            'Callback method',
            'callback'
        ),
        stringProperty(
            'address',
            'Address to someone or something',
            'address'
        ),
        integerProperty(
            'age',
            'Age of someone or something',
            'age'
        ),
        stringProperty(
            'agency',
            'Name of agency organisation',
            'name'
        ),
        stringProperty(
            'agent',
            'Someone or something that acts on behalf of someone else or something else',
            'agent'
        ),
        stringProperty(
            'alias',
            'An alternate name of an item or component',
            'name'
        ),
        integerProperty(
            'amount',
            'The quantity of something',
            'amount'
        ),
        floatProperty(
            'amount',
            'The quantity of something',
            'amount'
        ),
        stringProperty(
            'anniversary',
            'Date of anniversary',
            'anniversary'
        ),
        integerProperty(
            'anniversary',
            'Date of anniversary',
            'anniversary'
        ),
        dateTimeProperty(
            'anniversary',
            'Date of anniversary',
            'anniversary'
        ),
        stringProperty(
            'area',
            'Name of area, e.g. in a building, in a city, outside the city, ...etc',
            'name'
        ),
        stringProperty(
            'author',
            'Name of author',
            'name'
        ),

        // -------------------------------------------------------------------------------------
        // B
        // -------------------------------------------------------------------------------------

        stringProperty(
            'basePath',
            'The path to the root directory of some kind of a resource, e.g. your application, files, pictures,...etc',
            'path'
        ),
        stringProperty(
            'begin',
            'Location, index or some other identifier of where something begins',
            'location'
        ),
        stringProperty(
            'birthdate',
            'Date of birth',
            'date'
        ),
        integerProperty(
            'birthdate',
            'Date of birth',
            'date'
        ),
        dateTimeProperty(
            'birthdate',
            'Date of birth',
            'date'
        ),
        stringProperty(
            'bootstrapPath',
            'Directory path where bootstrapping resources are located',
            'path'
        ),
        stringProperty(
            'brand',
            'Name or identifier of a brand that is associated with a product or service',
            'identifier'
        ),
        integerProperty(
            'brand',
            'Name or identifier of a brand that is associated with a product or service',
            'identifier'
        ),
        stringProperty(
            'buildingNumber',
            'The house number assigned to a building or apartment in a street or area, e.g. 12a',
            'number'
        ),

        // -------------------------------------------------------------------------------------
        // C
        // -------------------------------------------------------------------------------------

        callableProperty(
            'callback',
            'Callback method',
            'callback'
        ),
        stringProperty(
            'calendar',
            'Location to calendar, e.g. URI, name, ID or other identifier',
            'location'
        ),
        stringProperty(
            'cardNumber',
            'Numeric or Alphanumeric card number, e.g. for credit cards or other types of cards',
            'number'
        ),
        stringProperty(
            'cardOwner',
            'Name of the card owner (cardholder)',
            'name'
        ),
        stringProperty(
            'cardType',
            'The type of card, e.g. VISA, MasterCard, Playing Card, Magic Card... etc',
            'type'
        ),
        stringProperty(
            'category',
            'Name of category',
            'name'
        ),
        arrayProperty(
            'categories',
            'List of category names',
            'list'
        ),
        arrayProperty(
            'choices',
            'Various choices that can be made',
            'list'
        ),
        stringProperty(
            'city',
            'Name of city, town or village',
            'name'
        ),
        stringProperty(
            'class',
            'The class of something or perhaps a class path',
            'class'
        ),
        stringProperty(
            'code',
            'The code for something, e.g. language code, classification code, or perhaps an artifacts identifier',
            'code'
        ),
        stringProperty(
            'colour',
            'Name of colour or colour value, e.g. RGB, CMYK, HSL or other format',
            'colour'
        ),
        stringProperty(
            'column',
            'Name of column',
            'name'
        ),
        stringProperty(
            'comment',
            'A comment',
            'content'
        ),
        stringProperty(
            'company',
            'Name of company',
            'name'
        ),
        stringProperty(
            'configPath',
            'Directory path where configuration files or resources located',
            'path'
        ),
        stringProperty(
            'content',
            'Content',
            'content'
        ),
        stringProperty(
            'country',
            'Name of country, e.g. Denmark, United Kingdom, Australia...etc',
            'name'
        ),
        stringProperty(
            'createdAt',
            'Date of when this component, entity or resource was created',
            'date'
        ),
        integerProperty(
            'createdAt',
            'Date of when this component, entity or resource was created',
            'date'
        ),
        dateTimeProperty(
            'createdAt',
            'Date of when this component, entity or resource was created',
            'date'
        ),
        stringProperty(
            'currency',
            'Name, code or other identifier of currency',
            'identifier'
        ),

        // -------------------------------------------------------------------------------------
        // D
        // -------------------------------------------------------------------------------------

        arrayProperty(
            'data',
            'A list (array) containing a set of values',
            'values'
        ),
        stringProperty(
            'database',
            'Name of database',
            'name'
        ),
        stringProperty(
            'databasePath',
            'Directory path where your databases are located',
            'path'
        ),
        stringProperty(
            'date',
            'Date of event',
            'date'
        ),
        integerProperty(
            'date',
            'Date of event',
            'date'
        ),
        dateTimeProperty(
            'date',
            'Date of event',
            'date'
        ),
        stringProperty(
            'deceasedAt',
            'Date of when person, animal of something has died',
            'date'
        ),
        integerProperty(
            'deceasedAt',
            'Date of when person, animal of something has died',
            'date'
        ),
        dateTimeProperty(
            'deceasedAt',
            'Date of when person, animal of something has died',
            'date'
        ),
        stringProperty(
            'deletedAt',
            'Date of when this component, entity or resource was deleted',
            'date'
        ),
        integerProperty(
            'deletedAt',
            'Date of when this component, entity or resource was deleted',
            'date'
        ),
        dateTimeProperty(
            'deletedAt',
            'Date of when this component, entity or resource was deleted',
            'date'
        ),
        stringProperty(
            'deliveredAt',
            'Date of delivery',
            'date'
        ),
        integerProperty(
            'deliveredAt',
            'Date of delivery',
            'date'
        ),
        dateTimeProperty(
            'deliveredAt',
            'Date of delivery',
            'date'
        ),
        stringProperty(
            'deliveryAddress',
            'Delivery address',
            'address'
        ),
        stringProperty(
            'deliveryDate',
            'Date of planned delivery',
            'date'
        ),
        integerProperty(
            'deliveryDate',
            'Date of planned delivery',
            'date'
        ),
        dateTimeProperty(
            'deliveryDate',
            'Date of planned delivery',
            'date'
        ),
        integerProperty(
            'depth',
            'Depth of something',
            'amount'
        ),
        floatProperty(
            'depth',
            'Depth of something',
            'amount'
        ),
        stringProperty(
            'description',
            'Description',
            'description'
        ),
        stringProperty(
            'directory',
            'Path to a given directory, relative or absolute, existing or none-existing',
            'path'
        ),
        stringProperty(
            'discount',
            'Discount amount',
            'amount'
        ),
        integerProperty(
            'discount',
            'Discount amount',
            'amount'
        ),
        floatProperty(
            'discount',
            'Discount amount',
            'amount'
        ),
        stringProperty(
            'distance',
            'Distance to or from something',
            'length'
        ),
        integerProperty(
            'distance',
            'Distance to or from something',
            'length'
        ),
        floatProperty(
            'distance',
            'Distance to or from something',
            'length'
        ),
        stringProperty(
            'domain',
            'Name, URL, territory or term that describes a given domain... etc',
            'domain'
        ),
        stringProperty(
            'duration',
            'Duration of some event or media',
            'amount'
        ),
        integerProperty(
            'duration',
            'Duration of some event or media',
            'amount'
        ),
        floatProperty(
            'duration',
            'Duration of some event or media',
            'amount'
        ),

        // -------------------------------------------------------------------------------------
        // E
        // -------------------------------------------------------------------------------------

        stringProperty(
            'ean',
            'International Article Number (EAN)',
            'ean'
        ),
        stringProperty(
            'ean8',
            'International Article Number (EAN), 8-digit',
            'ean8'
        ),
        stringProperty(
            'ean13',
            'International Article Number (EAN), 13-digit',
            'ean13'
        ),
        stringProperty(
            'edition',
            'The version of a published text, e.g. book, article, newspaper, report... etc',
            'edition'
        ),
        integerProperty(
            'edition',
            'The version of a published text, e.g. book, article, newspaper, report... etc',
            'edition'
        ),
        stringProperty(
            'email',
            'Email',
            'email'
        ),
        stringProperty(
            'end',
            'Location, index or other identifier of when something ends',
            'location'
        ),
        stringProperty(
            'end',
            'Location, index or other identifier of when something ends',
            'location'
        ),
        stringProperty(
            'endDate',
            'Date for when some kind of event ends',
            'date'
        ),
        integerProperty(
            'endDate',
            'Date for when some kind of event ends',
            'date'
        ),
        dateTimeProperty(
            'endDate',
            'Date for when some kind of event ends',
            'date'
        ),
        stringProperty(
            'environmentPath',
            'Directory path where your environment resources are located',
            'path'
        ),
        stringProperty(
            'error',
            'Error name or identifier',
            'identifier'
        ),
        integerProperty(
            'error',
            'Error name or identifier',
            'identifier'
        ),
        stringProperty(
            'event',
            'Event name or identifier',
            'identifier'
        ),
        integerProperty(
            'event',
            'Event name or identifier',
            'identifier'
        ),
        stringProperty(
            'expiresAt',
            'Date of when this component, entity or resource is going to expire',
            'date'
        ),
        integerProperty(
            'expiresAt',
            'Date of when this component, entity or resource is going to expire',
            'date'
        ),
        dateTimeProperty(
            'expiresAt',
            'Date of when this component, entity or resource is going to expire',
            'date'
        ),

        // -------------------------------------------------------------------------------------
        // F
        // -------------------------------------------------------------------------------------

        stringProperty(
            'fileExtension',
            'File extension, e.g. php, avi, json, txt...etc',
            'extension'
        ),
        stringProperty(
            'filename',
            'Name of given file, with or without path, e.g. myText.txt, /usr/docs/README.md',
            'name'
        ),
        stringProperty(
            'filePath',
            'Path to a file',
            'path'
        ),
        stringProperty(
            'firstName',
            'First name (given name) or forename of a person',
            'name'
        ),
        stringProperty(
            'format',
            'The shape, size and presentation or medium of an item or component',
            'format'
        ),
        stringProperty(
            'formattedName',
            'Formatted name of someone or something',
            'name'
        ),

        // -------------------------------------------------------------------------------------
        // G
        // -------------------------------------------------------------------------------------

        stringProperty(
            'gender',
            'Gender (sex) identity of a person, animal or something',
            'identity'
        ),
        stringProperty(
            'group',
            'Group identifier',
            'identity'
        ),
        integerProperty(
            'group',
            'Group identifier',
            'identity'
        ),

        // -------------------------------------------------------------------------------------
        // H
        // -------------------------------------------------------------------------------------

        stringProperty(
            'handler',
            'Identifier of a handler',
            'identifier'
        ),
        integerProperty(
            'handler',
            'Identifier of a handler',
            'identifier'
        ),
        callableProperty(
            'handler',
            'Handler callback method',
            'callback'
        ),
        integerProperty(
            'height',
            'Height of something',
            'amount'
        ),
        floatProperty(
            'height',
            'Height of something',
            'amount'
        ),
        stringProperty(
            'host',
            'Identifier of a host',
            'identifier'
        ),
        stringProperty(
            'html',
            'HyperText Markup Language (HTML)',
            'html'
        ),
        mixedProperty(
            'html',
            'HyperText Markup Language (HTML)',
            'html'
        ),

        // -------------------------------------------------------------------------------------
        // I
        // -------------------------------------------------------------------------------------

        stringProperty(
            'iata',
            'International Air Transport Association code',
            'code'
        ),
        stringProperty(
            'iban',
            'International Bank Account Number (IBAN)',
            'number'
        ),
        stringProperty(
            'icao',
            'International Civil Aviation Organization code',
            'code'
        ),
        stringProperty(
            'id',
            'Unique identifier',
            'identifier'
        ),
        integerProperty(
            'id',
            'Unique identifier',
            'identifier'
        ),
        stringProperty(
            'identifier',
            'Name or code that identifies a unique object, resource, class, component or thing',
            'identifier'
        ),
        integerProperty(
            'identifier',
            'Name or code that identifies a unique object, resource, class, component or thing',
            'identifier'
        ),
        stringProperty(
            'image',
            'Path, Uri or other type of location to an image',
            'location'
        ),
        stringProperty(
            'index',
            'Index',
            'index'
        ),
        integerProperty(
            'index',
            'Index',
            'index'
        ),
        stringProperty(
            'info',
            'Information about someone or something',
            'text'
        ),
        stringProperty(
            'information',
            'Information about someone or something',
            'text'
        ),
        stringProperty(
            'invoiceAddress',
            'Invoice Address. Can be formatted.',
            'address'
        ),
        stringProperty(
            'ip',
            'IP address',
            'address'
        ),
        stringProperty(
            'ipV4',
            'IPv4 address',
            'address'
        ),
        stringProperty(
            'ipV6',
            'IPv6 address',
            'address'
        ),
        stringProperty(
            'isicV4',
            'International Standard of Industrial Classification of All Economic Activities (ISIC), revision 4 code',
            'code'
        ),
        stringProperty(
            'isbn',
            'International Standard Book Number (ISBN)',
            'isbn'
        ),
        stringProperty(
            'isbn10',
            'International Standard Book Number (ISBN), 10-digits',
            'isbn10'
        ),
        stringProperty(
            'isbn13',
            'International Standard Book Number (ISBN), 13-digits',
            'ibn13'
        ),

        // -------------------------------------------------------------------------------------
        // J
        // -------------------------------------------------------------------------------------

        stringProperty(
            'json',
            'JavaScript Object Notation (JSON)',
            'json'
        ),
        mixedProperty(
            'json',
            'JavaScript Object Notation (JSON)',
            'json'
        ),

        // -------------------------------------------------------------------------------------
        // K
        // -------------------------------------------------------------------------------------

        stringProperty(
            'key',
            'key, e.g. indexing key, encryption key or other type of key',
            'key'
        ),
        stringProperty(
            'kind',
            'The kind of object this represents, e.g. human, organisation, group, individual...etc',
            'kind'
        ),

        // -------------------------------------------------------------------------------------
        // L
        // -------------------------------------------------------------------------------------

        stringProperty(
            'label',
            'Label name',
            'name'
        ),
        stringProperty(
            'langPath',
            'Directory path where translation resources are located',
            'path'
        ),
        stringProperty(
            'language',
            'Name or identifier of a language',
            'identifier'
        ),
        stringProperty(
            'lastName',
            'Last Name (surname) or family name of a person',
            'name'
        ),
        stringProperty(
            'latitude',
            'North-South position on Earth\'s surface',
            'value'
        ),
        floatProperty(
            'latitude',
            'North-South position on Earth\'s surface',
            'value'
        ),
        integerProperty(
            'length',
            'Length of something',
            'amount'
        ),
        floatProperty(
            'length',
            'Length of something',
            'amount'
        ),
        stringProperty(
            'license',
            'License name or identifier',
            'identifier'
        ),
        integerProperty(
            'license',
            'License name or identifier',
            'identifier'
        ),
        stringProperty(
            'link',
            'Hyperlink to related resource or action',
            'link'
        ),
        stringProperty(
            'locale',
            'Locale language code, e.g. en_us or other format',
            'code'
        ),
        stringProperty(
            'location',
            'Name or identifier of a location',
            'identifier'
        ),
        integerProperty(
            'location',
            'Name or identifier of a location',
            'identifier'
        ),
        arrayProperty(
            'Locations',
            'List of locations',
            'list'
        ),
        stringProperty(
            'logo',
            'Path, Uri or other type of location to a logo',
            'location'
        ),
        stringProperty(
            'Longitude',
            'East-West position on Earth\'s surface',
            'value'
        ),
        floatProperty(
            'Longitude',
            'East-West position on Earth\'s surface',
            'value'
        ),

        // -------------------------------------------------------------------------------------
        // M
        // -------------------------------------------------------------------------------------

        stringProperty(
            'macAddress',
            'Media Access Control Address (MAC Address)',
            'address'
        ),
        stringProperty(
            'manufacturer',
            'Name or identifier of a manufacturer',
            'identifier'
        ),
        stringProperty(
            'material',
            'Name or identifier of a material, e.g. leather, wool, cotton, paper.',
            'identifier'
        ),
        stringProperty(
            'mediaType',
            'Media Type (also known as MIME Type), acc. to IANA standard, or perhaps a type name',
            'type'
        ),
        stringProperty(
            'message',
            'A message',
            'message'
        ),
        stringProperty(
            'method',
            'Name of method or other identifier',
            'identifier'
        ),
        integerProperty(
            'method',
            'Name of method or other identifier',
            'identifier'
        ),
        callableProperty(
            'method',
            'Callback method',
            'callback'
        ),
        stringProperty(
            'middleName',
            'Middle Name or names of a person',
            'name'
        ),
        stringProperty(
            'milestone',
            'A marker that signifies a change, state, location or action',
            'identifier'
        ),
        integerProperty(
            'milestone',
            'A marker that signifies a change, state, location or action',
            'identifier'
        ),

        // -------------------------------------------------------------------------------------
        // N
        // -------------------------------------------------------------------------------------

        stringProperty(
            'name',
            'Name',
            'name'
        ),
        stringProperty(
            'nickName',
            'Nickname of someone or something',
            'name'
        ),
        stringProperty(
            'namespace',
            'Namespace',
            'namespace'
        ),

        // -------------------------------------------------------------------------------------
        // O
        // -------------------------------------------------------------------------------------

        booleanProperty(
            'on',
            'Is on',
            'isOn'
        ),
        booleanProperty(
            'off',
            'Is off',
            'isOff'
        ),
        stringProperty(
            'orderNumber',
            'Number that represents a purchase or order placed by a customer',
            'number'
        ),
        integerProperty(
            'orderNumber',
            'Number that represents a purchase or order placed by a customer',
            'number'
        ),
        stringProperty(
            'organisation',
            'Name of organisation',
            'name'
        ),
        stringProperty(
            'outputPath',
            'Location of where some kind of output must be placed or written to',
            'path'
        ),

        // -------------------------------------------------------------------------------------
        // P
        // -------------------------------------------------------------------------------------

        stringProperty(
            'package',
            'Name of package. Can evt. contain path to package as well',
            'name'
        ),
        stringProperty(
            'password',
            'Password',
            'password'
        ),
        stringProperty(
            'path',
            'Location of some kind of a resources, e.g. a file, an Url, an index',
            'location'
        ),
        stringProperty(
            'pattern',
            'Some kind of a pattern, e.g. search or regex',
            'pattern'
        ),
        stringProperty(
            'percent',
            'A part or other object per hundred',
            'percent'
        ),
        integerProperty(
            'percent',
            'A part or other object per hundred',
            'percent'
        ),
        floatProperty(
            'percent',
            'A part or other object per hundred',
            'percent'
        ),
        stringProperty(
            'percentage',
            'A proportion (especially per hundred)',
            'percentage'
        ),
        integerProperty(
            'percentage',
            'A part or other object per hundred',
            'percentage'
        ),
        floatProperty(
            'percentage',
            'A proportion (especially per hundred)',
            'percentage'
        ),
        stringProperty(
            'phone',
            'Phone number',
            'number'
        ),
        stringProperty(
            'photo',
            'Path, Uri or other type of location to a photo',
            'location'
        ),
        stringProperty(
            'postalCode',
            'Numeric or Alphanumeric postal code (zip code)',
            'code'
        ),
        stringProperty(
            'prefix',
            'Prefix',
            'prefix'
        ),
        stringProperty(
            'price',
            'Numeric price',
            'amount'
        ),
        integerProperty(
            'price',
            'Numeric price',
            'amount'
        ),
        floatProperty(
            'price',
            'Numeric price',
            'amount'
        ),
        stringProperty(
            'profile',
            'The profile of someone or something',
            'profile'
        ),
        stringProperty(
            'producedAt',
            'Date of when this component, entity or something was produced',
            'date'
        ),
        integerProperty(
            'producedAt',
            'Date of when this component, entity or something was produced',
            'date'
        ),
        dateTimeProperty(
            'producedAt',
            'Date of when this component, entity or something was produced',
            'date'
        ),
        stringProperty(
            'productionDate',
            'Date of planned production',
            'date'
        ),
        integerProperty(
            'productionDate',
            'Date of planned production',
            'date'
        ),
        dateTimeProperty(
            'productionDate',
            'Date of planned production',
            'date'
        ),
        stringProperty(
            'publicPath',
            'Directory path where public resources are located',
            'path'
        ),
        stringProperty(
            'purchaseDate',
            'Date of planned purchase',
            'date'
        ),
        integerProperty(
            'purchaseDate',
            'Date of planned purchase',
            'date'
        ),
        dateTimeProperty(
            'purchaseDate',
            'Date of planned purchase',
            'date'
        ),
        stringProperty(
            'purchasedAt',
            'Date of when this component, entity or resource was purchased',
            'date'
        ),
        integerProperty(
            'purchasedAt',
            'Date of when this component, entity or resource was purchased',
            'date'
        ),
        dateTimeProperty(
            'purchasedAt',
            'Date of when this component, entity or resource was purchased',
            'date'
        ),

        // -------------------------------------------------------------------------------------
        // Q
        // -------------------------------------------------------------------------------------

        integerProperty(
            'quantity',
            'The quantity of something',
            'quantity'
        ),
        floatProperty(
            'quantity',
            'The quantity of something',
            'quantity'
        ),
        stringProperty(
            'query',
            'Query',
            'query'
        ),
        stringProperty(
            'question',
            'A question that can be asked',
            'question'
        ),

        // -------------------------------------------------------------------------------------
        // R
        // -------------------------------------------------------------------------------------

        stringProperty(
            'rank',
            'The position in a hierarchy',
            'position'
        ),
        integerProperty(
            'rank',
            'The position in a hierarchy',
            'position'
        ),
        floatProperty(
            'rank',
            'The position in a hierarchy',
            'position'
        ),
        stringProperty(
            'rate',
            'The rate of something, e.g. growth rate, tax rate',
            'rate'
        ),
        integerProperty(
            'rate',
            'The rate of something, e.g. growth rate, tax rate',
            'rate'
        ),
        floatProperty(
            'rate',
            'The rate of something, e.g. growth rate, tax rate',
            'rate'
        ),
        stringProperty(
            'rating',
            'The rating of something',
            'score'
        ),
        integerProperty(
            'rating',
            'The rating of something',
            'score'
        ),
        floatProperty(
            'rating',
            'The rating of something',
            'score'
        ),
        stringProperty(
            'releasedAt',
            'Date of when this component, entity or something was released',
            'date'
        ),
        integerProperty(
            'releasedAt',
            'Date of when this component, entity or something was released',
            'date'
        ),
        dateTimeProperty(
            'releasedAt',
            'Date of when this component, entity or something was released',
            'date'
        ),
        stringProperty(
            'releaseDate',
            'Date of planned release',
            'date'
        ),
        integerProperty(
            'releaseDate',
            'Date of planned release',
            'date'
        ),
        dateTimeProperty(
            'releaseDate',
            'Date of planned release',
            'date'
        ),
        stringProperty(
            'resourcePath',
            'Directory path where your resources are located',
            'path'
        ),
        integerProperty(
            'row',
            'A row identifier',
            'identifier'
        ),
        stringProperty(
            'region',
            'Name of a region, state or province',
            'name'
        ),
        stringProperty(
            'revision',
            'A revision, batch number or other identifier',
            'revision'
        ),
        stringProperty(
            'role',
            'Name or identifier of role',
            'identifier'
        ),

        // -------------------------------------------------------------------------------------
        // S
        // -------------------------------------------------------------------------------------

        stringProperty(
            'size',
            'The size of something',
            'size'
        ),
        integerProperty(
            'size',
            'The size of something',
            'size'
        ),
        floatProperty(
            'size',
            'The size of something',
            'size'
        ),
        stringProperty(
            'script',
            'Script of some kind or path to some script',
            'script'
        ),
        stringProperty(
            'slug',
            'Human readable keyword(s) that can be part or a Url',
            'slug'
        ),
        stringProperty(
            'source',
            'The source of something. E.g. location, reference, index key, or other identifier that can be used to determine the source',
            'source'
        ),
        stringProperty(
            'sql',
            'A Structured Query Language (SQL) query',
            'query'
        ),
        stringProperty(
            'startDate',
            'Start date of event',
            'date'
        ),
        integerProperty(
            'startDate',
            'Start date of event',
            'date'
        ),
        dateTimeProperty(
            'startDate',
            'Start date of event',
            'date'
        ),
        stringProperty(
            'state',
            'State of this component or what it represents. Alternative, state address',
            'state'
        ),
        integerProperty(
            'state',
            'State of this component or what it represents',
            'state'
        ),
        stringProperty(
            'status',
            'Situation of progress, classification, or civil status',
            'status'
        ),
        integerProperty(
            'status',
            'Situation of progress, classification, or civil status',
            'status'
        ),
        stringProperty(
            'storagePath',
            'Directory path where bootstrapping resources are located',
            'path'
        ),
        stringProperty(
            'street',
            'Full street address, which might include building or apartment number(s)',
            'address'
        ),
        stringProperty(
            'suffix',
            'Suffix',
            'suffix'
        ),
        stringProperty(
            'swift',
            'ISO-9362 Swift Code',
            'code'
        ),

        // -------------------------------------------------------------------------------------
        // T
        // -------------------------------------------------------------------------------------

        stringProperty(
            'table',
            'Name of table',
            'name'
        ),
        stringProperty(
            'tag',
            'Name of tag',
            'name'
        ),
        arrayProperty(
            'tags',
            'List of tags',
            'tags'
        ),
        stringProperty(
            'template',
            'Template or location of a template file',
            'template'
        ),
        stringProperty(
            'text',
            'The full text content for something, e.g. an article\'s body text',
            'text'
        ),
        integerProperty(
            'timeout',
            'Timeout amount',
            'amount'
        ),
        integerProperty(
            'timestamp',
            'Unix timestamp',
            'timestamp'
        ),
        stringProperty(
            'timezone',
            'Name of timezone',
            'name'
        ),
        stringProperty(
            'title',
            'Title',
            'title'
        ),
        stringProperty(
            'tld',
            'Top Level Domain (TLD)',
            'tld'
        ),
        stringProperty(
            'topic',
            'name of topic',
            'name'
        ),
        stringProperty(
            'type',
            'Type identifier',
            'identifier'
        ),
        integerProperty(
            'type',
            'Type identifier',
            'identifier'
        ),

        // -------------------------------------------------------------------------------------
        // U
        // -------------------------------------------------------------------------------------

        stringProperty(
            'updatedAt',
            'Date of when this component, entity or resource was updated',
            'date'
        ),
        integerProperty(
            'updatedAt',
            'Date of when this component, entity or resource was updated',
            'date'
        ),
        dateTimeProperty(
            'updatedAt',
            'Date of when this component, entity or resource was updated',
            'date'
        ),
        stringProperty(
            'url',
            'Uniform Resource Locator (Url), commonly known as a web address',
            'webAddress'
        ),
        stringProperty(
            'username',
            'Identifier to be used as username',
            'identifier'
        ),
        stringProperty(
            'uuid',
            'Universally Unique Identifier (UUID)',
            'identifier'
        ),

        // -------------------------------------------------------------------------------------
        // V
        // -------------------------------------------------------------------------------------

        stringProperty(
            'value',
            'Value',
            'value'
        ),
        mixedProperty(
            'value',
            'Value',
            'value'
        ),
        stringProperty(
            'vat',
            'Value Added Tac (VAT), formatted amount or rate',
            'amount'
        ),
        integerProperty(
            'vat',
            'Value Added Tac (VAT), formatted amount or rate',
            'amount'
        ),
        floatProperty(
            'vat',
            'Value Added Tac (VAT), formatted amount or rate',
            'amount'
        ),
        stringProperty(
            'vendor',
            'Name or path of a vendor',
            'vendor'
        ),
        stringProperty(
            'version',
            'Version',
            'version'
        ),

        // -------------------------------------------------------------------------------------
        // W
        // -------------------------------------------------------------------------------------

        integerProperty(
            'weight',
            'Weight of something',
            'amount'
        ),
        floatProperty(
            'weight',
            'Weight of something',
            'amount'
        ),
        integerProperty(
            'width',
            'Width of something',
            'amount'
        ),
        floatProperty(
            'width',
            'Width of something',
            'amount'
        ),
        stringProperty(
            'wildcard',
            'Wildcard identifier',
            'identifier'
        ),

        // -------------------------------------------------------------------------------------
        // X
        // -------------------------------------------------------------------------------------

        integerProperty(
            'x',
            'Co-ordinate or value',
            'value'
        ),
        floatProperty(
            'x',
            'Co-ordinate or value',
            'value'
        ),
        mixedProperty(
            'x',
            'Co-ordinate or value',
            'value'
        ),
        stringProperty(
            'xml',
            'Extensible Markup Language (XML)',
            'xml'
        ),
        mixedProperty(
            'xml',
            'Extensible Markup Language (XML)',
            'xml'
        ),

        // -------------------------------------------------------------------------------------
        // Y
        // -------------------------------------------------------------------------------------

        integerProperty(
            'y',
            'Co-ordinate or value',
            'value'
        ),
        floatProperty(
            'y',
            'Co-ordinate or value',
            'value'
        ),
        mixedProperty(
            'y',
            'Co-ordinate or value',
            'value'
        ),

        // -------------------------------------------------------------------------------------
        // Z
        // -------------------------------------------------------------------------------------

        integerProperty(
            'z',
            'Co-ordinate or value',
            'value'
        ),
        floatProperty(
            'z',
            'Co-ordinate or value',
            'value'
        ),
        mixedProperty(
            'z',
            'Co-ordinate or value',
            'value'
        ),
        stringProperty(
            'zone',
            'Name or identifier of area, district or division',
            'identifier'
        ),
        integerProperty(
            'zone',
            'Name or identifier of area, district or division',
            'identifier'
        ),
    ]
];
