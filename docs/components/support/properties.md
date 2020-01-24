# Aware Of Properties

Below is a list of default aware-of components that are offered by this package.
They are suitable for usage with the [Dto abstraction](../dto/README.md) or for situations where you require your components to be aware of some kind of property.

## Make You Own

If you cannot find a specific aware-of component, then you can [request a new component](https://github.com/aedart/athenaeum/issues).
Alternatively, you can generate your own by using the available [Dto Generator](./generator.md), which has also been used to generate these components.

## Available Aware-Of Components

The following list are the available aware-of components.


### Action

-------------------------------------------------------
`string` A process or fact of doing something

*Interface* : `Aedart\Contracts\Support\Properties\Strings\ActionAware`

*Trait* : `Aedart\Support\Properties\Strings\ActionTrait`

-------------------------------------------------------
`callable` Callback method

*Interface* : `Aedart\Contracts\Support\Properties\Callables\ActionAware`

*Trait* : `Aedart\Support\Properties\Callables\ActionTrait`


### Address

-------------------------------------------------------
`string` Address to someone or something

*Interface* : `Aedart\Contracts\Support\Properties\Strings\AddressAware`

*Trait* : `Aedart\Support\Properties\Strings\AddressTrait`


### Age

-------------------------------------------------------
`int` Age of someone or something

*Interface* : `Aedart\Contracts\Support\Properties\Integers\AgeAware`

*Trait* : `Aedart\Support\Properties\Integers\AgeTrait`


### Agency

-------------------------------------------------------
`string` Name of agency organisation

*Interface* : `Aedart\Contracts\Support\Properties\Strings\AgencyAware`

*Trait* : `Aedart\Support\Properties\Strings\AgencyTrait`


### Agent

-------------------------------------------------------
`string` Someone or something that acts on behalf of someone else or something else

*Interface* : `Aedart\Contracts\Support\Properties\Strings\AgentAware`

*Trait* : `Aedart\Support\Properties\Strings\AgentTrait`


### Alias

-------------------------------------------------------
`string` An alternate name of an item or component

*Interface* : `Aedart\Contracts\Support\Properties\Strings\AliasAware`

*Trait* : `Aedart\Support\Properties\Strings\AliasTrait`


### Amount

-------------------------------------------------------
`int` The quantity of something

*Interface* : `Aedart\Contracts\Support\Properties\Integers\AmountAware`

*Trait* : `Aedart\Support\Properties\Integers\AmountTrait`

-------------------------------------------------------
`float` The quantity of something

*Interface* : `Aedart\Contracts\Support\Properties\Floats\AmountAware`

*Trait* : `Aedart\Support\Properties\Floats\AmountTrait`


### Anniversary

-------------------------------------------------------
`string` Date of anniversary

*Interface* : `Aedart\Contracts\Support\Properties\Strings\AnniversaryAware`

*Trait* : `Aedart\Support\Properties\Strings\AnniversaryTrait`

-------------------------------------------------------
`int` Date of anniversary

*Interface* : `Aedart\Contracts\Support\Properties\Integers\AnniversaryAware`

*Trait* : `Aedart\Support\Properties\Integers\AnniversaryTrait`

-------------------------------------------------------
`\DateTime` Date of anniversary

*Interface* : `Aedart\Contracts\Support\Properties\Dates\AnniversaryAware`

*Trait* : `Aedart\Support\Properties\Dates\AnniversaryTrait`


### Area

-------------------------------------------------------
`string` Name of area, e.g. in a building, in a city, outside the city, ...etc

*Interface* : `Aedart\Contracts\Support\Properties\Strings\AreaAware`

*Trait* : `Aedart\Support\Properties\Strings\AreaTrait`


### Author

-------------------------------------------------------
`string` Name of author

*Interface* : `Aedart\Contracts\Support\Properties\Strings\AuthorAware`

*Trait* : `Aedart\Support\Properties\Strings\AuthorTrait`





### BasePath

-------------------------------------------------------
`string` The path to the root directory of some kind of a resource, e.g. your application, files, pictures,...etc

*Interface* : `Aedart\Contracts\Support\Properties\Strings\BasePathAware`

*Trait* : `Aedart\Support\Properties\Strings\BasePathTrait`


### Begin

-------------------------------------------------------
`string` Location, index or some other identifier of where something begins

*Interface* : `Aedart\Contracts\Support\Properties\Strings\BeginAware`

*Trait* : `Aedart\Support\Properties\Strings\BeginTrait`


### Birthdate

-------------------------------------------------------
`string` Date of birth

*Interface* : `Aedart\Contracts\Support\Properties\Strings\BirthdateAware`

*Trait* : `Aedart\Support\Properties\Strings\BirthdateTrait`

-------------------------------------------------------
`int` Date of birth

*Interface* : `Aedart\Contracts\Support\Properties\Integers\BirthdateAware`

*Trait* : `Aedart\Support\Properties\Integers\BirthdateTrait`

-------------------------------------------------------
`\DateTime` Date of birth

*Interface* : `Aedart\Contracts\Support\Properties\Dates\BirthdateAware`

*Trait* : `Aedart\Support\Properties\Dates\BirthdateTrait`


### BootstrapPath

-------------------------------------------------------
`string` Directory path where bootstrapping resources are located

*Interface* : `Aedart\Contracts\Support\Properties\Strings\BootstrapPathAware`

*Trait* : `Aedart\Support\Properties\Strings\BootstrapPathTrait`


### Brand

-------------------------------------------------------
`string` Name or identifier of a brand that is associated with a product or service

*Interface* : `Aedart\Contracts\Support\Properties\Strings\BrandAware`

*Trait* : `Aedart\Support\Properties\Strings\BrandTrait`

-------------------------------------------------------
`int` Name or identifier of a brand that is associated with a product or service

*Interface* : `Aedart\Contracts\Support\Properties\Integers\BrandAware`

*Trait* : `Aedart\Support\Properties\Integers\BrandTrait`


### BuildingNumber

-------------------------------------------------------
`string` The house number assigned to a building or apartment in a street or area, e.g. 12a

*Interface* : `Aedart\Contracts\Support\Properties\Strings\BuildingNumberAware`

*Trait* : `Aedart\Support\Properties\Strings\BuildingNumberTrait`





### Callback

-------------------------------------------------------
`callable` Callback method

*Interface* : `Aedart\Contracts\Support\Properties\Callables\CallbackAware`

*Trait* : `Aedart\Support\Properties\Callables\CallbackTrait`


### Calendar

-------------------------------------------------------
`string` Location to calendar, e.g. URI, name, ID or other identifier

*Interface* : `Aedart\Contracts\Support\Properties\Strings\CalendarAware`

*Trait* : `Aedart\Support\Properties\Strings\CalendarTrait`


### CardNumber

-------------------------------------------------------
`string` Numeric or Alphanumeric card number, e.g. for credit cards or other types of cards

*Interface* : `Aedart\Contracts\Support\Properties\Strings\CardNumberAware`

*Trait* : `Aedart\Support\Properties\Strings\CardNumberTrait`


### CardOwner

-------------------------------------------------------
`string` Name of the card owner (cardholder)

*Interface* : `Aedart\Contracts\Support\Properties\Strings\CardOwnerAware`

*Trait* : `Aedart\Support\Properties\Strings\CardOwnerTrait`


### CardType

-------------------------------------------------------
`string` The type of card, e.g. VISA, MasterCard, Playing Card, Magic Card... etc

*Interface* : `Aedart\Contracts\Support\Properties\Strings\CardTypeAware`

*Trait* : `Aedart\Support\Properties\Strings\CardTypeTrait`


### Category

-------------------------------------------------------
`string` Name of category

*Interface* : `Aedart\Contracts\Support\Properties\Strings\CategoryAware`

*Trait* : `Aedart\Support\Properties\Strings\CategoryTrait`


### Categories

-------------------------------------------------------
`array` List of category names

*Interface* : `Aedart\Contracts\Support\Properties\Arrays\CategoriesAware`

*Trait* : `Aedart\Support\Properties\Arrays\CategoriesTrait`


### Choices

-------------------------------------------------------
`array` Various choices that can be made

*Interface* : `Aedart\Contracts\Support\Properties\Arrays\ChoicesAware`

*Trait* : `Aedart\Support\Properties\Arrays\ChoicesTrait`


### City

-------------------------------------------------------
`string` Name of city, town or village

*Interface* : `Aedart\Contracts\Support\Properties\Strings\CityAware`

*Trait* : `Aedart\Support\Properties\Strings\CityTrait`


### Class

-------------------------------------------------------
`string` The class of something or perhaps a class path

*Interface* : `Aedart\Contracts\Support\Properties\Strings\ClassAware`

*Trait* : `Aedart\Support\Properties\Strings\ClassTrait`


### Code

-------------------------------------------------------
`string` The code for something, e.g. language code, classification code, or perhaps an artifacts identifier

*Interface* : `Aedart\Contracts\Support\Properties\Strings\CodeAware`

*Trait* : `Aedart\Support\Properties\Strings\CodeTrait`


### Colour

-------------------------------------------------------
`string` Name of colour or colour value, e.g. RGB, CMYK, HSL or other format

*Interface* : `Aedart\Contracts\Support\Properties\Strings\ColourAware`

*Trait* : `Aedart\Support\Properties\Strings\ColourTrait`


### Column

-------------------------------------------------------
`string` Name of column

*Interface* : `Aedart\Contracts\Support\Properties\Strings\ColumnAware`

*Trait* : `Aedart\Support\Properties\Strings\ColumnTrait`


### Comment

-------------------------------------------------------
`string` A comment

*Interface* : `Aedart\Contracts\Support\Properties\Strings\CommentAware`

*Trait* : `Aedart\Support\Properties\Strings\CommentTrait`


### Company

-------------------------------------------------------
`string` Name of company

*Interface* : `Aedart\Contracts\Support\Properties\Strings\CompanyAware`

*Trait* : `Aedart\Support\Properties\Strings\CompanyTrait`


### ConfigPath

-------------------------------------------------------
`string` Directory path where configuration files or resources located

*Interface* : `Aedart\Contracts\Support\Properties\Strings\ConfigPathAware`

*Trait* : `Aedart\Support\Properties\Strings\ConfigPathTrait`


### Content

-------------------------------------------------------
`string` Content

*Interface* : `Aedart\Contracts\Support\Properties\Strings\ContentAware`

*Trait* : `Aedart\Support\Properties\Strings\ContentTrait`


### Country

-------------------------------------------------------
`string` Name of country, e.g. Denmark, United Kingdom, Australia...etc

*Interface* : `Aedart\Contracts\Support\Properties\Strings\CountryAware`

*Trait* : `Aedart\Support\Properties\Strings\CountryTrait`


### CreatedAt

-------------------------------------------------------
`string` Date of when this component, entity or resource was created

*Interface* : `Aedart\Contracts\Support\Properties\Strings\CreatedAtAware`

*Trait* : `Aedart\Support\Properties\Strings\CreatedAtTrait`

-------------------------------------------------------
`int` Date of when this component, entity or resource was created

*Interface* : `Aedart\Contracts\Support\Properties\Integers\CreatedAtAware`

*Trait* : `Aedart\Support\Properties\Integers\CreatedAtTrait`

-------------------------------------------------------
`\DateTime` Date of when this component, entity or resource was created

*Interface* : `Aedart\Contracts\Support\Properties\Dates\CreatedAtAware`

*Trait* : `Aedart\Support\Properties\Dates\CreatedAtTrait`


### Currency

-------------------------------------------------------
`string` Name, code or other identifier of currency

*Interface* : `Aedart\Contracts\Support\Properties\Strings\CurrencyAware`

*Trait* : `Aedart\Support\Properties\Strings\CurrencyTrait`





### Data

-------------------------------------------------------
`array` A list (array) containing a set of values

*Interface* : `Aedart\Contracts\Support\Properties\Arrays\DataAware`

*Trait* : `Aedart\Support\Properties\Arrays\DataTrait`


### Database

-------------------------------------------------------
`string` Name of database

*Interface* : `Aedart\Contracts\Support\Properties\Strings\DatabaseAware`

*Trait* : `Aedart\Support\Properties\Strings\DatabaseTrait`


### DatabasePath

-------------------------------------------------------
`string` Directory path where your databases are located

*Interface* : `Aedart\Contracts\Support\Properties\Strings\DatabasePathAware`

*Trait* : `Aedart\Support\Properties\Strings\DatabasePathTrait`


### Date

-------------------------------------------------------
`string` Date of event

*Interface* : `Aedart\Contracts\Support\Properties\Strings\DateAware`

*Trait* : `Aedart\Support\Properties\Strings\DateTrait`

-------------------------------------------------------
`int` Date of event

*Interface* : `Aedart\Contracts\Support\Properties\Integers\DateAware`

*Trait* : `Aedart\Support\Properties\Integers\DateTrait`

-------------------------------------------------------
`\DateTime` Date of event

*Interface* : `Aedart\Contracts\Support\Properties\Dates\DateAware`

*Trait* : `Aedart\Support\Properties\Dates\DateTrait`


### DeceasedAt

-------------------------------------------------------
`string` Date of when person, animal of something has died

*Interface* : `Aedart\Contracts\Support\Properties\Strings\DeceasedAtAware`

*Trait* : `Aedart\Support\Properties\Strings\DeceasedAtTrait`

-------------------------------------------------------
`int` Date of when person, animal of something has died

*Interface* : `Aedart\Contracts\Support\Properties\Integers\DeceasedAtAware`

*Trait* : `Aedart\Support\Properties\Integers\DeceasedAtTrait`

-------------------------------------------------------
`\DateTime` Date of when person, animal of something has died

*Interface* : `Aedart\Contracts\Support\Properties\Dates\DeceasedAtAware`

*Trait* : `Aedart\Support\Properties\Dates\DeceasedAtTrait`


### DeletedAt

-------------------------------------------------------
`string` Date of when this component, entity or resource was deleted

*Interface* : `Aedart\Contracts\Support\Properties\Strings\DeletedAtAware`

*Trait* : `Aedart\Support\Properties\Strings\DeletedAtTrait`

-------------------------------------------------------
`int` Date of when this component, entity or resource was deleted

*Interface* : `Aedart\Contracts\Support\Properties\Integers\DeletedAtAware`

*Trait* : `Aedart\Support\Properties\Integers\DeletedAtTrait`

-------------------------------------------------------
`\DateTime` Date of when this component, entity or resource was deleted

*Interface* : `Aedart\Contracts\Support\Properties\Dates\DeletedAtAware`

*Trait* : `Aedart\Support\Properties\Dates\DeletedAtTrait`


### DeliveredAt

-------------------------------------------------------
`string` Date of delivery

*Interface* : `Aedart\Contracts\Support\Properties\Strings\DeliveredAtAware`

*Trait* : `Aedart\Support\Properties\Strings\DeliveredAtTrait`

-------------------------------------------------------
`int` Date of delivery

*Interface* : `Aedart\Contracts\Support\Properties\Integers\DeliveredAtAware`

*Trait* : `Aedart\Support\Properties\Integers\DeliveredAtTrait`

-------------------------------------------------------
`\DateTime` Date of delivery

*Interface* : `Aedart\Contracts\Support\Properties\Dates\DeliveredAtAware`

*Trait* : `Aedart\Support\Properties\Dates\DeliveredAtTrait`


### DeliveryAddress

-------------------------------------------------------
`string` Delivery address

*Interface* : `Aedart\Contracts\Support\Properties\Strings\DeliveryAddressAware`

*Trait* : `Aedart\Support\Properties\Strings\DeliveryAddressTrait`


### DeliveryDate

-------------------------------------------------------
`string` Date of planned delivery

*Interface* : `Aedart\Contracts\Support\Properties\Strings\DeliveryDateAware`

*Trait* : `Aedart\Support\Properties\Strings\DeliveryDateTrait`

-------------------------------------------------------
`int` Date of planned delivery

*Interface* : `Aedart\Contracts\Support\Properties\Integers\DeliveryDateAware`

*Trait* : `Aedart\Support\Properties\Integers\DeliveryDateTrait`

-------------------------------------------------------
`\DateTime` Date of planned delivery

*Interface* : `Aedart\Contracts\Support\Properties\Dates\DeliveryDateAware`

*Trait* : `Aedart\Support\Properties\Dates\DeliveryDateTrait`


### Depth

-------------------------------------------------------
`int` Depth of something

*Interface* : `Aedart\Contracts\Support\Properties\Integers\DepthAware`

*Trait* : `Aedart\Support\Properties\Integers\DepthTrait`

-------------------------------------------------------
`float` Depth of something

*Interface* : `Aedart\Contracts\Support\Properties\Floats\DepthAware`

*Trait* : `Aedart\Support\Properties\Floats\DepthTrait`


### Description

-------------------------------------------------------
`string` Description

*Interface* : `Aedart\Contracts\Support\Properties\Strings\DescriptionAware`

*Trait* : `Aedart\Support\Properties\Strings\DescriptionTrait`


### Directory

-------------------------------------------------------
`string` Path to a given directory, relative or absolute, existing or none-existing

*Interface* : `Aedart\Contracts\Support\Properties\Strings\DirectoryAware`

*Trait* : `Aedart\Support\Properties\Strings\DirectoryTrait`


### Discount

-------------------------------------------------------
`string` Discount amount

*Interface* : `Aedart\Contracts\Support\Properties\Strings\DiscountAware`

*Trait* : `Aedart\Support\Properties\Strings\DiscountTrait`

-------------------------------------------------------
`int` Discount amount

*Interface* : `Aedart\Contracts\Support\Properties\Integers\DiscountAware`

*Trait* : `Aedart\Support\Properties\Integers\DiscountTrait`

-------------------------------------------------------
`float` Discount amount

*Interface* : `Aedart\Contracts\Support\Properties\Floats\DiscountAware`

*Trait* : `Aedart\Support\Properties\Floats\DiscountTrait`


### Distance

-------------------------------------------------------
`string` Distance to or from something

*Interface* : `Aedart\Contracts\Support\Properties\Strings\DistanceAware`

*Trait* : `Aedart\Support\Properties\Strings\DistanceTrait`

-------------------------------------------------------
`int` Distance to or from something

*Interface* : `Aedart\Contracts\Support\Properties\Integers\DistanceAware`

*Trait* : `Aedart\Support\Properties\Integers\DistanceTrait`

-------------------------------------------------------
`float` Distance to or from something

*Interface* : `Aedart\Contracts\Support\Properties\Floats\DistanceAware`

*Trait* : `Aedart\Support\Properties\Floats\DistanceTrait`


### Domain

-------------------------------------------------------
`string` Name, URL, territory or term that describes a given domain... etc

*Interface* : `Aedart\Contracts\Support\Properties\Strings\DomainAware`

*Trait* : `Aedart\Support\Properties\Strings\DomainTrait`


### Duration

-------------------------------------------------------
`string` Duration of some event or media

*Interface* : `Aedart\Contracts\Support\Properties\Strings\DurationAware`

*Trait* : `Aedart\Support\Properties\Strings\DurationTrait`

-------------------------------------------------------
`int` Duration of some event or media

*Interface* : `Aedart\Contracts\Support\Properties\Integers\DurationAware`

*Trait* : `Aedart\Support\Properties\Integers\DurationTrait`

-------------------------------------------------------
`float` Duration of some event or media

*Interface* : `Aedart\Contracts\Support\Properties\Floats\DurationAware`

*Trait* : `Aedart\Support\Properties\Floats\DurationTrait`





### Ean

-------------------------------------------------------
`string` International Article Number (EAN)

*Interface* : `Aedart\Contracts\Support\Properties\Strings\EanAware`

*Trait* : `Aedart\Support\Properties\Strings\EanTrait`


### Ean8

-------------------------------------------------------
`string` International Article Number (EAN), 8-digit

*Interface* : `Aedart\Contracts\Support\Properties\Strings\Ean8Aware`

*Trait* : `Aedart\Support\Properties\Strings\Ean8Trait`


### Ean13

-------------------------------------------------------
`string` International Article Number (EAN), 13-digit

*Interface* : `Aedart\Contracts\Support\Properties\Strings\Ean13Aware`

*Trait* : `Aedart\Support\Properties\Strings\Ean13Trait`


### Edition

-------------------------------------------------------
`string` The version of a published text, e.g. book, article, newspaper, report... etc

*Interface* : `Aedart\Contracts\Support\Properties\Strings\EditionAware`

*Trait* : `Aedart\Support\Properties\Strings\EditionTrait`

-------------------------------------------------------
`int` The version of a published text, e.g. book, article, newspaper, report... etc

*Interface* : `Aedart\Contracts\Support\Properties\Integers\EditionAware`

*Trait* : `Aedart\Support\Properties\Integers\EditionTrait`


### Email

-------------------------------------------------------
`string` Email

*Interface* : `Aedart\Contracts\Support\Properties\Strings\EmailAware`

*Trait* : `Aedart\Support\Properties\Strings\EmailTrait`


### End

-------------------------------------------------------
`string` Location, index or other identifier of when something ends

*Interface* : `Aedart\Contracts\Support\Properties\Strings\EndAware`

*Trait* : `Aedart\Support\Properties\Strings\EndTrait`


### EndDate

-------------------------------------------------------
`string` Date for when some kind of event ends

*Interface* : `Aedart\Contracts\Support\Properties\Strings\EndDateAware`

*Trait* : `Aedart\Support\Properties\Strings\EndDateTrait`

-------------------------------------------------------
`int` Date for when some kind of event ends

*Interface* : `Aedart\Contracts\Support\Properties\Integers\EndDateAware`

*Trait* : `Aedart\Support\Properties\Integers\EndDateTrait`

-------------------------------------------------------
`\DateTime` Date for when some kind of event ends

*Interface* : `Aedart\Contracts\Support\Properties\Dates\EndDateAware`

*Trait* : `Aedart\Support\Properties\Dates\EndDateTrait`


### EnvironmentPath

-------------------------------------------------------
`string` Directory path where your environment resources are located

*Interface* : `Aedart\Contracts\Support\Properties\Strings\EnvironmentPathAware`

*Trait* : `Aedart\Support\Properties\Strings\EnvironmentPathTrait`


### Error

-------------------------------------------------------
`string` Error name or identifier

*Interface* : `Aedart\Contracts\Support\Properties\Strings\ErrorAware`

*Trait* : `Aedart\Support\Properties\Strings\ErrorTrait`

-------------------------------------------------------
`int` Error name or identifier

*Interface* : `Aedart\Contracts\Support\Properties\Integers\ErrorAware`

*Trait* : `Aedart\Support\Properties\Integers\ErrorTrait`


### Event

-------------------------------------------------------
`string` Event name or identifier

*Interface* : `Aedart\Contracts\Support\Properties\Strings\EventAware`

*Trait* : `Aedart\Support\Properties\Strings\EventTrait`

-------------------------------------------------------
`int` Event name or identifier

*Interface* : `Aedart\Contracts\Support\Properties\Integers\EventAware`

*Trait* : `Aedart\Support\Properties\Integers\EventTrait`


### ExpiresAt

-------------------------------------------------------
`string` Date of when this component, entity or resource is going to expire

*Interface* : `Aedart\Contracts\Support\Properties\Strings\ExpiresAtAware`

*Trait* : `Aedart\Support\Properties\Strings\ExpiresAtTrait`

-------------------------------------------------------
`int` Date of when this component, entity or resource is going to expire

*Interface* : `Aedart\Contracts\Support\Properties\Integers\ExpiresAtAware`

*Trait* : `Aedart\Support\Properties\Integers\ExpiresAtTrait`

-------------------------------------------------------
`\DateTime` Date of when this component, entity or resource is going to expire

*Interface* : `Aedart\Contracts\Support\Properties\Dates\ExpiresAtAware`

*Trait* : `Aedart\Support\Properties\Dates\ExpiresAtTrait`





### FileExtension

-------------------------------------------------------
`string` File extension, e.g. php, avi, json, txt...etc

*Interface* : `Aedart\Contracts\Support\Properties\Strings\FileExtensionAware`

*Trait* : `Aedart\Support\Properties\Strings\FileExtensionTrait`


### Filename

-------------------------------------------------------
`string` Name of given file, with or without path, e.g. myText.txt, /usr/docs/README.md

*Interface* : `Aedart\Contracts\Support\Properties\Strings\FilenameAware`

*Trait* : `Aedart\Support\Properties\Strings\FilenameTrait`


### FilePath

-------------------------------------------------------
`string` Path to a file

*Interface* : `Aedart\Contracts\Support\Properties\Strings\FilePathAware`

*Trait* : `Aedart\Support\Properties\Strings\FilePathTrait`


### FirstName

-------------------------------------------------------
`string` First name (given name) or forename of a person

*Interface* : `Aedart\Contracts\Support\Properties\Strings\FirstNameAware`

*Trait* : `Aedart\Support\Properties\Strings\FirstNameTrait`


### Format

-------------------------------------------------------
`string` The shape, size and presentation or medium of an item or component

*Interface* : `Aedart\Contracts\Support\Properties\Strings\FormatAware`

*Trait* : `Aedart\Support\Properties\Strings\FormatTrait`


### FormattedName

-------------------------------------------------------
`string` Formatted name of someone or something

*Interface* : `Aedart\Contracts\Support\Properties\Strings\FormattedNameAware`

*Trait* : `Aedart\Support\Properties\Strings\FormattedNameTrait`





### Gender

-------------------------------------------------------
`string` Gender (sex) identity of a person, animal or something

*Interface* : `Aedart\Contracts\Support\Properties\Strings\GenderAware`

*Trait* : `Aedart\Support\Properties\Strings\GenderTrait`


### Group

-------------------------------------------------------
`string` Group identifier

*Interface* : `Aedart\Contracts\Support\Properties\Strings\GroupAware`

*Trait* : `Aedart\Support\Properties\Strings\GroupTrait`

-------------------------------------------------------
`int` Group identifier

*Interface* : `Aedart\Contracts\Support\Properties\Integers\GroupAware`

*Trait* : `Aedart\Support\Properties\Integers\GroupTrait`





### Handler

-------------------------------------------------------
`string` Identifier of a handler

*Interface* : `Aedart\Contracts\Support\Properties\Strings\HandlerAware`

*Trait* : `Aedart\Support\Properties\Strings\HandlerTrait`

-------------------------------------------------------
`int` Identifier of a handler

*Interface* : `Aedart\Contracts\Support\Properties\Integers\HandlerAware`

*Trait* : `Aedart\Support\Properties\Integers\HandlerTrait`

-------------------------------------------------------
`callable` Handler callback method

*Interface* : `Aedart\Contracts\Support\Properties\Callables\HandlerAware`

*Trait* : `Aedart\Support\Properties\Callables\HandlerTrait`


### Height

-------------------------------------------------------
`int` Height of something

*Interface* : `Aedart\Contracts\Support\Properties\Integers\HeightAware`

*Trait* : `Aedart\Support\Properties\Integers\HeightTrait`

-------------------------------------------------------
`float` Height of something

*Interface* : `Aedart\Contracts\Support\Properties\Floats\HeightAware`

*Trait* : `Aedart\Support\Properties\Floats\HeightTrait`


### Host

-------------------------------------------------------
`string` Identifier of a host

*Interface* : `Aedart\Contracts\Support\Properties\Strings\HostAware`

*Trait* : `Aedart\Support\Properties\Strings\HostTrait`


### Html

-------------------------------------------------------
`string` HyperText Markup Language (HTML)

*Interface* : `Aedart\Contracts\Support\Properties\Strings\HtmlAware`

*Trait* : `Aedart\Support\Properties\Strings\HtmlTrait`

-------------------------------------------------------
`mixed` HyperText Markup Language (HTML)

*Interface* : `Aedart\Contracts\Support\Properties\Mixed\HtmlAware`

*Trait* : `Aedart\Support\Properties\Mixed\HtmlTrait`





### Iata

-------------------------------------------------------
`string` International Air Transport Association code

*Interface* : `Aedart\Contracts\Support\Properties\Strings\IataAware`

*Trait* : `Aedart\Support\Properties\Strings\IataTrait`


### Iban

-------------------------------------------------------
`string` International Bank Account Number (IBAN)

*Interface* : `Aedart\Contracts\Support\Properties\Strings\IbanAware`

*Trait* : `Aedart\Support\Properties\Strings\IbanTrait`


### Icao

-------------------------------------------------------
`string` International Civil Aviation Organization code

*Interface* : `Aedart\Contracts\Support\Properties\Strings\IcaoAware`

*Trait* : `Aedart\Support\Properties\Strings\IcaoTrait`


### Id

-------------------------------------------------------
`string` Unique identifier

*Interface* : `Aedart\Contracts\Support\Properties\Strings\IdAware`

*Trait* : `Aedart\Support\Properties\Strings\IdTrait`

-------------------------------------------------------
`int` Unique identifier

*Interface* : `Aedart\Contracts\Support\Properties\Integers\IdAware`

*Trait* : `Aedart\Support\Properties\Integers\IdTrait`


### Identifier

-------------------------------------------------------
`string` Name or code that identifies a unique object, resource, class, component or thing

*Interface* : `Aedart\Contracts\Support\Properties\Strings\IdentifierAware`

*Trait* : `Aedart\Support\Properties\Strings\IdentifierTrait`

-------------------------------------------------------
`int` Name or code that identifies a unique object, resource, class, component or thing

*Interface* : `Aedart\Contracts\Support\Properties\Integers\IdentifierAware`

*Trait* : `Aedart\Support\Properties\Integers\IdentifierTrait`


### Image

-------------------------------------------------------
`string` Path, Uri or other type of location to an image

*Interface* : `Aedart\Contracts\Support\Properties\Strings\ImageAware`

*Trait* : `Aedart\Support\Properties\Strings\ImageTrait`


### Index

-------------------------------------------------------
`string` Index

*Interface* : `Aedart\Contracts\Support\Properties\Strings\IndexAware`

*Trait* : `Aedart\Support\Properties\Strings\IndexTrait`

-------------------------------------------------------
`int` Index

*Interface* : `Aedart\Contracts\Support\Properties\Integers\IndexAware`

*Trait* : `Aedart\Support\Properties\Integers\IndexTrait`


### Info

-------------------------------------------------------
`string` Information about someone or something

*Interface* : `Aedart\Contracts\Support\Properties\Strings\InfoAware`

*Trait* : `Aedart\Support\Properties\Strings\InfoTrait`


### Information

-------------------------------------------------------
`string` Information about someone or something

*Interface* : `Aedart\Contracts\Support\Properties\Strings\InformationAware`

*Trait* : `Aedart\Support\Properties\Strings\InformationTrait`


### InvoiceAddress

-------------------------------------------------------
`string` Invoice Address. Can be formatted.

*Interface* : `Aedart\Contracts\Support\Properties\Strings\InvoiceAddressAware`

*Trait* : `Aedart\Support\Properties\Strings\InvoiceAddressTrait`


### Ip

-------------------------------------------------------
`string` IP address

*Interface* : `Aedart\Contracts\Support\Properties\Strings\IpAware`

*Trait* : `Aedart\Support\Properties\Strings\IpTrait`


### IpV4

-------------------------------------------------------
`string` IPv4 address

*Interface* : `Aedart\Contracts\Support\Properties\Strings\IpV4Aware`

*Trait* : `Aedart\Support\Properties\Strings\IpV4Trait`


### IpV6

-------------------------------------------------------
`string` IPv6 address

*Interface* : `Aedart\Contracts\Support\Properties\Strings\IpV6Aware`

*Trait* : `Aedart\Support\Properties\Strings\IpV6Trait`


### IsicV4

-------------------------------------------------------
`string` International Standard of Industrial Classification of All Economic Activities (ISIC), revision 4 code

*Interface* : `Aedart\Contracts\Support\Properties\Strings\IsicV4Aware`

*Trait* : `Aedart\Support\Properties\Strings\IsicV4Trait`


### Isbn

-------------------------------------------------------
`string` International Standard Book Number (ISBN)

*Interface* : `Aedart\Contracts\Support\Properties\Strings\IsbnAware`

*Trait* : `Aedart\Support\Properties\Strings\IsbnTrait`


### Isbn10

-------------------------------------------------------
`string` International Standard Book Number (ISBN), 10-digits

*Interface* : `Aedart\Contracts\Support\Properties\Strings\Isbn10Aware`

*Trait* : `Aedart\Support\Properties\Strings\Isbn10Trait`


### Isbn13

-------------------------------------------------------
`string` International Standard Book Number (ISBN), 13-digits

*Interface* : `Aedart\Contracts\Support\Properties\Strings\Isbn13Aware`

*Trait* : `Aedart\Support\Properties\Strings\Isbn13Trait`





### Json

-------------------------------------------------------
`string` JavaScript Object Notation (JSON)

*Interface* : `Aedart\Contracts\Support\Properties\Strings\JsonAware`

*Trait* : `Aedart\Support\Properties\Strings\JsonTrait`

-------------------------------------------------------
`mixed` JavaScript Object Notation (JSON)

*Interface* : `Aedart\Contracts\Support\Properties\Mixed\JsonAware`

*Trait* : `Aedart\Support\Properties\Mixed\JsonTrait`





### Key

-------------------------------------------------------
`string` Key, e.g. indexing key, encryption key or other type of key

*Interface* : `Aedart\Contracts\Support\Properties\Strings\KeyAware`

*Trait* : `Aedart\Support\Properties\Strings\KeyTrait`


### Kind

-------------------------------------------------------
`string` The kind of object this represents, e.g. human, organisation, group, individual...etc

*Interface* : `Aedart\Contracts\Support\Properties\Strings\KindAware`

*Trait* : `Aedart\Support\Properties\Strings\KindTrait`





### Label

-------------------------------------------------------
`string` Label name

*Interface* : `Aedart\Contracts\Support\Properties\Strings\LabelAware`

*Trait* : `Aedart\Support\Properties\Strings\LabelTrait`


### LangPath

-------------------------------------------------------
`string` Directory path where translation resources are located

*Interface* : `Aedart\Contracts\Support\Properties\Strings\LangPathAware`

*Trait* : `Aedart\Support\Properties\Strings\LangPathTrait`


### Language

-------------------------------------------------------
`string` Name or identifier of a language

*Interface* : `Aedart\Contracts\Support\Properties\Strings\LanguageAware`

*Trait* : `Aedart\Support\Properties\Strings\LanguageTrait`


### LastName

-------------------------------------------------------
`string` Last Name (surname) or family name of a person

*Interface* : `Aedart\Contracts\Support\Properties\Strings\LastNameAware`

*Trait* : `Aedart\Support\Properties\Strings\LastNameTrait`


### Latitude

-------------------------------------------------------
`string` North-South position on Earth&#039;s surface

*Interface* : `Aedart\Contracts\Support\Properties\Strings\LatitudeAware`

*Trait* : `Aedart\Support\Properties\Strings\LatitudeTrait`

-------------------------------------------------------
`float` North-South position on Earth&#039;s surface

*Interface* : `Aedart\Contracts\Support\Properties\Floats\LatitudeAware`

*Trait* : `Aedart\Support\Properties\Floats\LatitudeTrait`


### Length

-------------------------------------------------------
`int` Length of something

*Interface* : `Aedart\Contracts\Support\Properties\Integers\LengthAware`

*Trait* : `Aedart\Support\Properties\Integers\LengthTrait`

-------------------------------------------------------
`float` Length of something

*Interface* : `Aedart\Contracts\Support\Properties\Floats\LengthAware`

*Trait* : `Aedart\Support\Properties\Floats\LengthTrait`


### License

-------------------------------------------------------
`string` License name or identifier

*Interface* : `Aedart\Contracts\Support\Properties\Strings\LicenseAware`

*Trait* : `Aedart\Support\Properties\Strings\LicenseTrait`

-------------------------------------------------------
`int` License name or identifier

*Interface* : `Aedart\Contracts\Support\Properties\Integers\LicenseAware`

*Trait* : `Aedart\Support\Properties\Integers\LicenseTrait`


### Link

-------------------------------------------------------
`string` Hyperlink to related resource or action

*Interface* : `Aedart\Contracts\Support\Properties\Strings\LinkAware`

*Trait* : `Aedart\Support\Properties\Strings\LinkTrait`


### Locale

-------------------------------------------------------
`string` Locale language code, e.g. en_us or other format

*Interface* : `Aedart\Contracts\Support\Properties\Strings\LocaleAware`

*Trait* : `Aedart\Support\Properties\Strings\LocaleTrait`


### Location

-------------------------------------------------------
`string` Name or identifier of a location

*Interface* : `Aedart\Contracts\Support\Properties\Strings\LocationAware`

*Trait* : `Aedart\Support\Properties\Strings\LocationTrait`

-------------------------------------------------------
`int` Name or identifier of a location

*Interface* : `Aedart\Contracts\Support\Properties\Integers\LocationAware`

*Trait* : `Aedart\Support\Properties\Integers\LocationTrait`


### Locations

-------------------------------------------------------
`array` List of locations

*Interface* : `Aedart\Contracts\Support\Properties\Arrays\LocationsAware`

*Trait* : `Aedart\Support\Properties\Arrays\LocationsTrait`


### Logo

-------------------------------------------------------
`string` Path, Uri or other type of location to a logo

*Interface* : `Aedart\Contracts\Support\Properties\Strings\LogoAware`

*Trait* : `Aedart\Support\Properties\Strings\LogoTrait`


### Longitude

-------------------------------------------------------
`string` East-West position on Earth&#039;s surface

*Interface* : `Aedart\Contracts\Support\Properties\Strings\LongitudeAware`

*Trait* : `Aedart\Support\Properties\Strings\LongitudeTrait`

-------------------------------------------------------
`float` East-West position on Earth&#039;s surface

*Interface* : `Aedart\Contracts\Support\Properties\Floats\LongitudeAware`

*Trait* : `Aedart\Support\Properties\Floats\LongitudeTrait`





### MacAddress

-------------------------------------------------------
`string` Media Access Control Address (MAC Address)

*Interface* : `Aedart\Contracts\Support\Properties\Strings\MacAddressAware`

*Trait* : `Aedart\Support\Properties\Strings\MacAddressTrait`


### Manufacturer

-------------------------------------------------------
`string` Name or identifier of a manufacturer

*Interface* : `Aedart\Contracts\Support\Properties\Strings\ManufacturerAware`

*Trait* : `Aedart\Support\Properties\Strings\ManufacturerTrait`


### Material

-------------------------------------------------------
`string` Name or identifier of a material, e.g. leather, wool, cotton, paper.

*Interface* : `Aedart\Contracts\Support\Properties\Strings\MaterialAware`

*Trait* : `Aedart\Support\Properties\Strings\MaterialTrait`


### MediaType

-------------------------------------------------------
`string` Media Type (also known as MIME Type), acc. to IANA standard, or perhaps a type name

*Interface* : `Aedart\Contracts\Support\Properties\Strings\MediaTypeAware`

*Trait* : `Aedart\Support\Properties\Strings\MediaTypeTrait`


### Message

-------------------------------------------------------
`string` A message

*Interface* : `Aedart\Contracts\Support\Properties\Strings\MessageAware`

*Trait* : `Aedart\Support\Properties\Strings\MessageTrait`


### Method

-------------------------------------------------------
`string` Name of method or other identifier

*Interface* : `Aedart\Contracts\Support\Properties\Strings\MethodAware`

*Trait* : `Aedart\Support\Properties\Strings\MethodTrait`

-------------------------------------------------------
`int` Name of method or other identifier

*Interface* : `Aedart\Contracts\Support\Properties\Integers\MethodAware`

*Trait* : `Aedart\Support\Properties\Integers\MethodTrait`

-------------------------------------------------------
`callable` Callback method

*Interface* : `Aedart\Contracts\Support\Properties\Callables\MethodAware`

*Trait* : `Aedart\Support\Properties\Callables\MethodTrait`


### MiddleName

-------------------------------------------------------
`string` Middle Name or names of a person

*Interface* : `Aedart\Contracts\Support\Properties\Strings\MiddleNameAware`

*Trait* : `Aedart\Support\Properties\Strings\MiddleNameTrait`


### Milestone

-------------------------------------------------------
`string` A marker that signifies a change, state, location or action

*Interface* : `Aedart\Contracts\Support\Properties\Strings\MilestoneAware`

*Trait* : `Aedart\Support\Properties\Strings\MilestoneTrait`

-------------------------------------------------------
`int` A marker that signifies a change, state, location or action

*Interface* : `Aedart\Contracts\Support\Properties\Integers\MilestoneAware`

*Trait* : `Aedart\Support\Properties\Integers\MilestoneTrait`





### Name

-------------------------------------------------------
`string` Name

*Interface* : `Aedart\Contracts\Support\Properties\Strings\NameAware`

*Trait* : `Aedart\Support\Properties\Strings\NameTrait`


### NickName

-------------------------------------------------------
`string` Nickname of someone or something

*Interface* : `Aedart\Contracts\Support\Properties\Strings\NickNameAware`

*Trait* : `Aedart\Support\Properties\Strings\NickNameTrait`


### Namespace

-------------------------------------------------------
`string` Namespace

*Interface* : `Aedart\Contracts\Support\Properties\Strings\NamespaceAware`

*Trait* : `Aedart\Support\Properties\Strings\NamespaceTrait`





### On

-------------------------------------------------------
`bool` 

*Interface* : `Aedart\Contracts\Support\Properties\Booleans\OnAware`

*Trait* : `Aedart\Support\Properties\Booleans\OnTrait`


### Off

-------------------------------------------------------
`bool` 

*Interface* : `Aedart\Contracts\Support\Properties\Booleans\OffAware`

*Trait* : `Aedart\Support\Properties\Booleans\OffTrait`


### OrderNumber

-------------------------------------------------------
`string` Number that represents a purchase or order placed by a customer

*Interface* : `Aedart\Contracts\Support\Properties\Strings\OrderNumberAware`

*Trait* : `Aedart\Support\Properties\Strings\OrderNumberTrait`

-------------------------------------------------------
`int` Number that represents a purchase or order placed by a customer

*Interface* : `Aedart\Contracts\Support\Properties\Integers\OrderNumberAware`

*Trait* : `Aedart\Support\Properties\Integers\OrderNumberTrait`


### Organisation

-------------------------------------------------------
`string` Name of organisation

*Interface* : `Aedart\Contracts\Support\Properties\Strings\OrganisationAware`

*Trait* : `Aedart\Support\Properties\Strings\OrganisationTrait`


### OutputPath

-------------------------------------------------------
`string` Location of where some kind of output must be placed or written to

*Interface* : `Aedart\Contracts\Support\Properties\Strings\OutputPathAware`

*Trait* : `Aedart\Support\Properties\Strings\OutputPathTrait`





### Package

-------------------------------------------------------
`string` Name of package. Can evt. contain path to package as well

*Interface* : `Aedart\Contracts\Support\Properties\Strings\PackageAware`

*Trait* : `Aedart\Support\Properties\Strings\PackageTrait`


### Password

-------------------------------------------------------
`string` Password

*Interface* : `Aedart\Contracts\Support\Properties\Strings\PasswordAware`

*Trait* : `Aedart\Support\Properties\Strings\PasswordTrait`


### Path

-------------------------------------------------------
`string` Location of some kind of a resources, e.g. a file, an Url, an index

*Interface* : `Aedart\Contracts\Support\Properties\Strings\PathAware`

*Trait* : `Aedart\Support\Properties\Strings\PathTrait`


### Pattern

-------------------------------------------------------
`string` Some kind of a pattern, e.g. search or regex

*Interface* : `Aedart\Contracts\Support\Properties\Strings\PatternAware`

*Trait* : `Aedart\Support\Properties\Strings\PatternTrait`


### Percent

-------------------------------------------------------
`string` A part or other object per hundred

*Interface* : `Aedart\Contracts\Support\Properties\Strings\PercentAware`

*Trait* : `Aedart\Support\Properties\Strings\PercentTrait`

-------------------------------------------------------
`int` A part or other object per hundred

*Interface* : `Aedart\Contracts\Support\Properties\Integers\PercentAware`

*Trait* : `Aedart\Support\Properties\Integers\PercentTrait`

-------------------------------------------------------
`float` A part or other object per hundred

*Interface* : `Aedart\Contracts\Support\Properties\Floats\PercentAware`

*Trait* : `Aedart\Support\Properties\Floats\PercentTrait`


### Percentage

-------------------------------------------------------
`string` A proportion (especially per hundred)

*Interface* : `Aedart\Contracts\Support\Properties\Strings\PercentageAware`

*Trait* : `Aedart\Support\Properties\Strings\PercentageTrait`

-------------------------------------------------------
`int` A part or other object per hundred

*Interface* : `Aedart\Contracts\Support\Properties\Integers\PercentageAware`

*Trait* : `Aedart\Support\Properties\Integers\PercentageTrait`

-------------------------------------------------------
`float` A proportion (especially per hundred)

*Interface* : `Aedart\Contracts\Support\Properties\Floats\PercentageAware`

*Trait* : `Aedart\Support\Properties\Floats\PercentageTrait`


### Phone

-------------------------------------------------------
`string` Phone number

*Interface* : `Aedart\Contracts\Support\Properties\Strings\PhoneAware`

*Trait* : `Aedart\Support\Properties\Strings\PhoneTrait`


### Photo

-------------------------------------------------------
`string` Path, Uri or other type of location to a photo

*Interface* : `Aedart\Contracts\Support\Properties\Strings\PhotoAware`

*Trait* : `Aedart\Support\Properties\Strings\PhotoTrait`


### PostalCode

-------------------------------------------------------
`string` Numeric or Alphanumeric postal code (zip code)

*Interface* : `Aedart\Contracts\Support\Properties\Strings\PostalCodeAware`

*Trait* : `Aedart\Support\Properties\Strings\PostalCodeTrait`


### Prefix

-------------------------------------------------------
`string` Prefix

*Interface* : `Aedart\Contracts\Support\Properties\Strings\PrefixAware`

*Trait* : `Aedart\Support\Properties\Strings\PrefixTrait`


### Price

-------------------------------------------------------
`string` Numeric price

*Interface* : `Aedart\Contracts\Support\Properties\Strings\PriceAware`

*Trait* : `Aedart\Support\Properties\Strings\PriceTrait`

-------------------------------------------------------
`int` Numeric price

*Interface* : `Aedart\Contracts\Support\Properties\Integers\PriceAware`

*Trait* : `Aedart\Support\Properties\Integers\PriceTrait`

-------------------------------------------------------
`float` Numeric price

*Interface* : `Aedart\Contracts\Support\Properties\Floats\PriceAware`

*Trait* : `Aedart\Support\Properties\Floats\PriceTrait`


### Profile

-------------------------------------------------------
`string` The profile or someone or something

*Interface* : `Aedart\Contracts\Support\Properties\Strings\ProfileAware`

*Trait* : `Aedart\Support\Properties\Strings\ProfileTrait`


### ProducedAt

-------------------------------------------------------
`string` Date of when this component, entity or something was produced

*Interface* : `Aedart\Contracts\Support\Properties\Strings\ProducedAtAware`

*Trait* : `Aedart\Support\Properties\Strings\ProducedAtTrait`

-------------------------------------------------------
`int` Date of when this component, entity or something was produced

*Interface* : `Aedart\Contracts\Support\Properties\Integers\ProducedAtAware`

*Trait* : `Aedart\Support\Properties\Integers\ProducedAtTrait`

-------------------------------------------------------
`\DateTime` Date of when this component, entity or something was produced

*Interface* : `Aedart\Contracts\Support\Properties\Dates\ProducedAtAware`

*Trait* : `Aedart\Support\Properties\Dates\ProducedAtTrait`


### ProductionDate

-------------------------------------------------------
`string` Date of planned production

*Interface* : `Aedart\Contracts\Support\Properties\Strings\ProductionDateAware`

*Trait* : `Aedart\Support\Properties\Strings\ProductionDateTrait`

-------------------------------------------------------
`int` Date of planned production

*Interface* : `Aedart\Contracts\Support\Properties\Integers\ProductionDateAware`

*Trait* : `Aedart\Support\Properties\Integers\ProductionDateTrait`

-------------------------------------------------------
`\DateTime` Date of planned production

*Interface* : `Aedart\Contracts\Support\Properties\Dates\ProductionDateAware`

*Trait* : `Aedart\Support\Properties\Dates\ProductionDateTrait`


### PublicPath

-------------------------------------------------------
`string` Directory path where public resources are located

*Interface* : `Aedart\Contracts\Support\Properties\Strings\PublicPathAware`

*Trait* : `Aedart\Support\Properties\Strings\PublicPathTrait`


### PurchaseDate

-------------------------------------------------------
`string` Date of planned purchase

*Interface* : `Aedart\Contracts\Support\Properties\Strings\PurchaseDateAware`

*Trait* : `Aedart\Support\Properties\Strings\PurchaseDateTrait`

-------------------------------------------------------
`int` Date of planned purchase

*Interface* : `Aedart\Contracts\Support\Properties\Integers\PurchaseDateAware`

*Trait* : `Aedart\Support\Properties\Integers\PurchaseDateTrait`

-------------------------------------------------------
`\DateTime` Date of planned purchase

*Interface* : `Aedart\Contracts\Support\Properties\Dates\PurchaseDateAware`

*Trait* : `Aedart\Support\Properties\Dates\PurchaseDateTrait`


### PurchasedAt

-------------------------------------------------------
`string` Date of when this component, entity or resource was purchased

*Interface* : `Aedart\Contracts\Support\Properties\Strings\PurchasedAtAware`

*Trait* : `Aedart\Support\Properties\Strings\PurchasedAtTrait`

-------------------------------------------------------
`int` Date of when this component, entity or resource was purchased

*Interface* : `Aedart\Contracts\Support\Properties\Integers\PurchasedAtAware`

*Trait* : `Aedart\Support\Properties\Integers\PurchasedAtTrait`

-------------------------------------------------------
`\DateTime` Date of when this component, entity or resource was purchased

*Interface* : `Aedart\Contracts\Support\Properties\Dates\PurchasedAtAware`

*Trait* : `Aedart\Support\Properties\Dates\PurchasedAtTrait`





### Quantity

-------------------------------------------------------
`int` The quantity of something

*Interface* : `Aedart\Contracts\Support\Properties\Integers\QuantityAware`

*Trait* : `Aedart\Support\Properties\Integers\QuantityTrait`

-------------------------------------------------------
`float` The quantity of something

*Interface* : `Aedart\Contracts\Support\Properties\Floats\QuantityAware`

*Trait* : `Aedart\Support\Properties\Floats\QuantityTrait`


### Query

-------------------------------------------------------
`string` Query

*Interface* : `Aedart\Contracts\Support\Properties\Strings\QueryAware`

*Trait* : `Aedart\Support\Properties\Strings\QueryTrait`


### Question

-------------------------------------------------------
`string` A question that can be asked

*Interface* : `Aedart\Contracts\Support\Properties\Strings\QuestionAware`

*Trait* : `Aedart\Support\Properties\Strings\QuestionTrait`





### Rank

-------------------------------------------------------
`string` The position in a hierarchy

*Interface* : `Aedart\Contracts\Support\Properties\Strings\RankAware`

*Trait* : `Aedart\Support\Properties\Strings\RankTrait`

-------------------------------------------------------
`int` The position in a hierarchy

*Interface* : `Aedart\Contracts\Support\Properties\Integers\RankAware`

*Trait* : `Aedart\Support\Properties\Integers\RankTrait`

-------------------------------------------------------
`float` The position in a hierarchy

*Interface* : `Aedart\Contracts\Support\Properties\Floats\RankAware`

*Trait* : `Aedart\Support\Properties\Floats\RankTrait`


### Rate

-------------------------------------------------------
`string` The rate of something, e.g. growth rate, tax rate

*Interface* : `Aedart\Contracts\Support\Properties\Strings\RateAware`

*Trait* : `Aedart\Support\Properties\Strings\RateTrait`

-------------------------------------------------------
`int` The rate of something, e.g. growth rate, tax rate

*Interface* : `Aedart\Contracts\Support\Properties\Integers\RateAware`

*Trait* : `Aedart\Support\Properties\Integers\RateTrait`

-------------------------------------------------------
`float` The rate of something, e.g. growth rate, tax rate

*Interface* : `Aedart\Contracts\Support\Properties\Floats\RateAware`

*Trait* : `Aedart\Support\Properties\Floats\RateTrait`


### Rating

-------------------------------------------------------
`string` The rating of something

*Interface* : `Aedart\Contracts\Support\Properties\Strings\RatingAware`

*Trait* : `Aedart\Support\Properties\Strings\RatingTrait`

-------------------------------------------------------
`int` The rating of something

*Interface* : `Aedart\Contracts\Support\Properties\Integers\RatingAware`

*Trait* : `Aedart\Support\Properties\Integers\RatingTrait`

-------------------------------------------------------
`float` The rating of something

*Interface* : `Aedart\Contracts\Support\Properties\Floats\RatingAware`

*Trait* : `Aedart\Support\Properties\Floats\RatingTrait`


### ReleasedAt

-------------------------------------------------------
`string` Date of when this component, entity or something was released

*Interface* : `Aedart\Contracts\Support\Properties\Strings\ReleasedAtAware`

*Trait* : `Aedart\Support\Properties\Strings\ReleasedAtTrait`

-------------------------------------------------------
`int` Date of when this component, entity or something was released

*Interface* : `Aedart\Contracts\Support\Properties\Integers\ReleasedAtAware`

*Trait* : `Aedart\Support\Properties\Integers\ReleasedAtTrait`

-------------------------------------------------------
`\DateTime` Date of when this component, entity or something was released

*Interface* : `Aedart\Contracts\Support\Properties\Dates\ReleasedAtAware`

*Trait* : `Aedart\Support\Properties\Dates\ReleasedAtTrait`


### ReleaseDate

-------------------------------------------------------
`string` Date of planned release

*Interface* : `Aedart\Contracts\Support\Properties\Strings\ReleaseDateAware`

*Trait* : `Aedart\Support\Properties\Strings\ReleaseDateTrait`

-------------------------------------------------------
`int` Date of planned release

*Interface* : `Aedart\Contracts\Support\Properties\Integers\ReleaseDateAware`

*Trait* : `Aedart\Support\Properties\Integers\ReleaseDateTrait`

-------------------------------------------------------
`\DateTime` Date of planned release

*Interface* : `Aedart\Contracts\Support\Properties\Dates\ReleaseDateAware`

*Trait* : `Aedart\Support\Properties\Dates\ReleaseDateTrait`


### ResourcePath

-------------------------------------------------------
`string` Directory path where your resources are located

*Interface* : `Aedart\Contracts\Support\Properties\Strings\ResourcePathAware`

*Trait* : `Aedart\Support\Properties\Strings\ResourcePathTrait`


### Row

-------------------------------------------------------
`int` A row identifier

*Interface* : `Aedart\Contracts\Support\Properties\Integers\RowAware`

*Trait* : `Aedart\Support\Properties\Integers\RowTrait`


### Region

-------------------------------------------------------
`string` Name of a region, state or province

*Interface* : `Aedart\Contracts\Support\Properties\Strings\RegionAware`

*Trait* : `Aedart\Support\Properties\Strings\RegionTrait`


### Revision

-------------------------------------------------------
`string` A revision, batch number or other identifier

*Interface* : `Aedart\Contracts\Support\Properties\Strings\RevisionAware`

*Trait* : `Aedart\Support\Properties\Strings\RevisionTrait`


### Role

-------------------------------------------------------
`string` Name or identifier of role

*Interface* : `Aedart\Contracts\Support\Properties\Strings\RoleAware`

*Trait* : `Aedart\Support\Properties\Strings\RoleTrait`





### Size

-------------------------------------------------------
`string` The size of something

*Interface* : `Aedart\Contracts\Support\Properties\Strings\SizeAware`

*Trait* : `Aedart\Support\Properties\Strings\SizeTrait`

-------------------------------------------------------
`int` The size of something

*Interface* : `Aedart\Contracts\Support\Properties\Integers\SizeAware`

*Trait* : `Aedart\Support\Properties\Integers\SizeTrait`

-------------------------------------------------------
`float` The size of something

*Interface* : `Aedart\Contracts\Support\Properties\Floats\SizeAware`

*Trait* : `Aedart\Support\Properties\Floats\SizeTrait`


### Script

-------------------------------------------------------
`string` Script of some kind or path to some script

*Interface* : `Aedart\Contracts\Support\Properties\Strings\ScriptAware`

*Trait* : `Aedart\Support\Properties\Strings\ScriptTrait`


### Slug

-------------------------------------------------------
`string` Human readable keyword(s) that can be part or a Url

*Interface* : `Aedart\Contracts\Support\Properties\Strings\SlugAware`

*Trait* : `Aedart\Support\Properties\Strings\SlugTrait`


### Source

-------------------------------------------------------
`string` The source of something. E.g. location, reference, index key, or other identifier that can be used to determine the source

*Interface* : `Aedart\Contracts\Support\Properties\Strings\SourceAware`

*Trait* : `Aedart\Support\Properties\Strings\SourceTrait`


### Sql

-------------------------------------------------------
`string` A Structured Query Language (SQL) query

*Interface* : `Aedart\Contracts\Support\Properties\Strings\SqlAware`

*Trait* : `Aedart\Support\Properties\Strings\SqlTrait`


### StartDate

-------------------------------------------------------
`string` Start date of event

*Interface* : `Aedart\Contracts\Support\Properties\Strings\StartDateAware`

*Trait* : `Aedart\Support\Properties\Strings\StartDateTrait`

-------------------------------------------------------
`int` Start date of event

*Interface* : `Aedart\Contracts\Support\Properties\Integers\StartDateAware`

*Trait* : `Aedart\Support\Properties\Integers\StartDateTrait`

-------------------------------------------------------
`\DateTime` Start date of event

*Interface* : `Aedart\Contracts\Support\Properties\Dates\StartDateAware`

*Trait* : `Aedart\Support\Properties\Dates\StartDateTrait`


### State

-------------------------------------------------------
`string` State of this component or what it represents. Alternative, state address

*Interface* : `Aedart\Contracts\Support\Properties\Strings\StateAware`

*Trait* : `Aedart\Support\Properties\Strings\StateTrait`

-------------------------------------------------------
`int` State of this component or what it represents

*Interface* : `Aedart\Contracts\Support\Properties\Integers\StateAware`

*Trait* : `Aedart\Support\Properties\Integers\StateTrait`


### Status

-------------------------------------------------------
`string` Situation of progress, classification, or civil status

*Interface* : `Aedart\Contracts\Support\Properties\Strings\StatusAware`

*Trait* : `Aedart\Support\Properties\Strings\StatusTrait`

-------------------------------------------------------
`int` Situation of progress, classification, or civil status

*Interface* : `Aedart\Contracts\Support\Properties\Integers\StatusAware`

*Trait* : `Aedart\Support\Properties\Integers\StatusTrait`


### StoragePath

-------------------------------------------------------
`string` Directory path where bootstrapping resources are located

*Interface* : `Aedart\Contracts\Support\Properties\Strings\StoragePathAware`

*Trait* : `Aedart\Support\Properties\Strings\StoragePathTrait`


### Street

-------------------------------------------------------
`string` Full street address, which might include building or apartment number(s)

*Interface* : `Aedart\Contracts\Support\Properties\Strings\StreetAware`

*Trait* : `Aedart\Support\Properties\Strings\StreetTrait`


### Suffix

-------------------------------------------------------
`string` Suffix

*Interface* : `Aedart\Contracts\Support\Properties\Strings\SuffixAware`

*Trait* : `Aedart\Support\Properties\Strings\SuffixTrait`


### Swift

-------------------------------------------------------
`string` ISO-9362 Swift Code

*Interface* : `Aedart\Contracts\Support\Properties\Strings\SwiftAware`

*Trait* : `Aedart\Support\Properties\Strings\SwiftTrait`





### Table

-------------------------------------------------------
`string` Name of table

*Interface* : `Aedart\Contracts\Support\Properties\Strings\TableAware`

*Trait* : `Aedart\Support\Properties\Strings\TableTrait`


### Tag

-------------------------------------------------------
`string` Name of tag

*Interface* : `Aedart\Contracts\Support\Properties\Strings\TagAware`

*Trait* : `Aedart\Support\Properties\Strings\TagTrait`


### Tags

-------------------------------------------------------
`array` List of tags

*Interface* : `Aedart\Contracts\Support\Properties\Arrays\TagsAware`

*Trait* : `Aedart\Support\Properties\Arrays\TagsTrait`


### Template

-------------------------------------------------------
`string` Template or location of a template file

*Interface* : `Aedart\Contracts\Support\Properties\Strings\TemplateAware`

*Trait* : `Aedart\Support\Properties\Strings\TemplateTrait`


### Text

-------------------------------------------------------
`string` The full text content for something, e.g. an article&#039;s body text

*Interface* : `Aedart\Contracts\Support\Properties\Strings\TextAware`

*Trait* : `Aedart\Support\Properties\Strings\TextTrait`


### Timeout

-------------------------------------------------------
`int` Timeout amount

*Interface* : `Aedart\Contracts\Support\Properties\Integers\TimeoutAware`

*Trait* : `Aedart\Support\Properties\Integers\TimeoutTrait`


### Timestamp

-------------------------------------------------------
`int` Unix timestamp

*Interface* : `Aedart\Contracts\Support\Properties\Integers\TimestampAware`

*Trait* : `Aedart\Support\Properties\Integers\TimestampTrait`


### Timezone

-------------------------------------------------------
`string` Name of timezone

*Interface* : `Aedart\Contracts\Support\Properties\Strings\TimezoneAware`

*Trait* : `Aedart\Support\Properties\Strings\TimezoneTrait`


### Title

-------------------------------------------------------
`string` Title

*Interface* : `Aedart\Contracts\Support\Properties\Strings\TitleAware`

*Trait* : `Aedart\Support\Properties\Strings\TitleTrait`


### Tld

-------------------------------------------------------
`string` Top Level Domain (TLD)

*Interface* : `Aedart\Contracts\Support\Properties\Strings\TldAware`

*Trait* : `Aedart\Support\Properties\Strings\TldTrait`


### Topic

-------------------------------------------------------
`string` Name of topic

*Interface* : `Aedart\Contracts\Support\Properties\Strings\TopicAware`

*Trait* : `Aedart\Support\Properties\Strings\TopicTrait`


### Type

-------------------------------------------------------
`string` Type identifier

*Interface* : `Aedart\Contracts\Support\Properties\Strings\TypeAware`

*Trait* : `Aedart\Support\Properties\Strings\TypeTrait`

-------------------------------------------------------
`int` Type identifier

*Interface* : `Aedart\Contracts\Support\Properties\Integers\TypeAware`

*Trait* : `Aedart\Support\Properties\Integers\TypeTrait`





### UpdatedAt

-------------------------------------------------------
`string` Date of when this component, entity or resource was updated

*Interface* : `Aedart\Contracts\Support\Properties\Strings\UpdatedAtAware`

*Trait* : `Aedart\Support\Properties\Strings\UpdatedAtTrait`

-------------------------------------------------------
`int` Date of when this component, entity or resource was updated

*Interface* : `Aedart\Contracts\Support\Properties\Integers\UpdatedAtAware`

*Trait* : `Aedart\Support\Properties\Integers\UpdatedAtTrait`

-------------------------------------------------------
`\DateTime` Date of when this component, entity or resource was updated

*Interface* : `Aedart\Contracts\Support\Properties\Dates\UpdatedAtAware`

*Trait* : `Aedart\Support\Properties\Dates\UpdatedAtTrait`


### Url

-------------------------------------------------------
`string` Uniform Resource Locator (Url), commonly known as a web address

*Interface* : `Aedart\Contracts\Support\Properties\Strings\UrlAware`

*Trait* : `Aedart\Support\Properties\Strings\UrlTrait`


### Username

-------------------------------------------------------
`string` Identifier to be used as username

*Interface* : `Aedart\Contracts\Support\Properties\Strings\UsernameAware`

*Trait* : `Aedart\Support\Properties\Strings\UsernameTrait`


### Uuid

-------------------------------------------------------
`string` Universally Unique Identifier (UUID)

*Interface* : `Aedart\Contracts\Support\Properties\Strings\UuidAware`

*Trait* : `Aedart\Support\Properties\Strings\UuidTrait`





### Value

-------------------------------------------------------
`string` Value

*Interface* : `Aedart\Contracts\Support\Properties\Strings\ValueAware`

*Trait* : `Aedart\Support\Properties\Strings\ValueTrait`

-------------------------------------------------------
`mixed` Value

*Interface* : `Aedart\Contracts\Support\Properties\Mixed\ValueAware`

*Trait* : `Aedart\Support\Properties\Mixed\ValueTrait`


### Vat

-------------------------------------------------------
`string` Value Added Tac (VAT), formatted amount or rate

*Interface* : `Aedart\Contracts\Support\Properties\Strings\VatAware`

*Trait* : `Aedart\Support\Properties\Strings\VatTrait`

-------------------------------------------------------
`int` Value Added Tac (VAT), formatted amount or rate

*Interface* : `Aedart\Contracts\Support\Properties\Integers\VatAware`

*Trait* : `Aedart\Support\Properties\Integers\VatTrait`

-------------------------------------------------------
`float` Value Added Tac (VAT), formatted amount or rate

*Interface* : `Aedart\Contracts\Support\Properties\Floats\VatAware`

*Trait* : `Aedart\Support\Properties\Floats\VatTrait`


### Vendor

-------------------------------------------------------
`string` Name or path of a vendor

*Interface* : `Aedart\Contracts\Support\Properties\Strings\VendorAware`

*Trait* : `Aedart\Support\Properties\Strings\VendorTrait`


### Version

-------------------------------------------------------
`string` Version

*Interface* : `Aedart\Contracts\Support\Properties\Strings\VersionAware`

*Trait* : `Aedart\Support\Properties\Strings\VersionTrait`





### Weight

-------------------------------------------------------
`int` Weight of something

*Interface* : `Aedart\Contracts\Support\Properties\Integers\WeightAware`

*Trait* : `Aedart\Support\Properties\Integers\WeightTrait`

-------------------------------------------------------
`float` Weight of something

*Interface* : `Aedart\Contracts\Support\Properties\Floats\WeightAware`

*Trait* : `Aedart\Support\Properties\Floats\WeightTrait`


### Width

-------------------------------------------------------
`int` Width of something

*Interface* : `Aedart\Contracts\Support\Properties\Integers\WidthAware`

*Trait* : `Aedart\Support\Properties\Integers\WidthTrait`

-------------------------------------------------------
`float` Width of something

*Interface* : `Aedart\Contracts\Support\Properties\Floats\WidthAware`

*Trait* : `Aedart\Support\Properties\Floats\WidthTrait`


### Wildcard

-------------------------------------------------------
`string` Wildcard identifier

*Interface* : `Aedart\Contracts\Support\Properties\Strings\WildcardAware`

*Trait* : `Aedart\Support\Properties\Strings\WildcardTrait`





### X

-------------------------------------------------------
`int` Co-ordinate or value

*Interface* : `Aedart\Contracts\Support\Properties\Integers\XAware`

*Trait* : `Aedart\Support\Properties\Integers\XTrait`

-------------------------------------------------------
`float` Co-ordinate or value

*Interface* : `Aedart\Contracts\Support\Properties\Floats\XAware`

*Trait* : `Aedart\Support\Properties\Floats\XTrait`

-------------------------------------------------------
`mixed` Co-ordinate or value

*Interface* : `Aedart\Contracts\Support\Properties\Mixed\XAware`

*Trait* : `Aedart\Support\Properties\Mixed\XTrait`


### Xml

-------------------------------------------------------
`string` Extensible Markup Language (XML)

*Interface* : `Aedart\Contracts\Support\Properties\Strings\XmlAware`

*Trait* : `Aedart\Support\Properties\Strings\XmlTrait`

-------------------------------------------------------
`mixed` Extensible Markup Language (XML)

*Interface* : `Aedart\Contracts\Support\Properties\Mixed\XmlAware`

*Trait* : `Aedart\Support\Properties\Mixed\XmlTrait`





### Y

-------------------------------------------------------
`int` Co-ordinate or value

*Interface* : `Aedart\Contracts\Support\Properties\Integers\YAware`

*Trait* : `Aedart\Support\Properties\Integers\YTrait`

-------------------------------------------------------
`float` Co-ordinate or value

*Interface* : `Aedart\Contracts\Support\Properties\Floats\YAware`

*Trait* : `Aedart\Support\Properties\Floats\YTrait`

-------------------------------------------------------
`mixed` Co-ordinate or value

*Interface* : `Aedart\Contracts\Support\Properties\Mixed\YAware`

*Trait* : `Aedart\Support\Properties\Mixed\YTrait`





### Z

-------------------------------------------------------
`int` Co-ordinate or value

*Interface* : `Aedart\Contracts\Support\Properties\Integers\ZAware`

*Trait* : `Aedart\Support\Properties\Integers\ZTrait`

-------------------------------------------------------
`float` Co-ordinate or value

*Interface* : `Aedart\Contracts\Support\Properties\Floats\ZAware`

*Trait* : `Aedart\Support\Properties\Floats\ZTrait`

-------------------------------------------------------
`mixed` Co-ordinate or value

*Interface* : `Aedart\Contracts\Support\Properties\Mixed\ZAware`

*Trait* : `Aedart\Support\Properties\Mixed\ZTrait`


### Zone

-------------------------------------------------------
`string` Name or identifier of area, district or division

*Interface* : `Aedart\Contracts\Support\Properties\Strings\ZoneAware`

*Trait* : `Aedart\Support\Properties\Strings\ZoneTrait`

-------------------------------------------------------
`int` Name or identifier of area, district or division

*Interface* : `Aedart\Contracts\Support\Properties\Integers\ZoneAware`

*Trait* : `Aedart\Support\Properties\Integers\ZoneTrait`




