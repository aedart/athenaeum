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

<small>**Interface** : `Aedart\Contracts\Support\Properties\Strings\ActionAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Strings\ActionTrait`</small>

-------------------------------------------------------
`callable` Callback method

<small>**Interface** : `Aedart\Contracts\Support\Properties\Callables\ActionAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Callables\ActionTrait`</small>


### Address

-------------------------------------------------------
`string` Address to someone or something

<small>**Interface** : `Aedart\Contracts\Support\Properties\Strings\AddressAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Strings\AddressTrait`</small>


### Age

-------------------------------------------------------
`int` Age of someone or something

<small>**Interface** : `Aedart\Contracts\Support\Properties\Integers\AgeAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Integers\AgeTrait`</small>


### Agency

-------------------------------------------------------
`string` Name of agency organisation

<small>**Interface** : `Aedart\Contracts\Support\Properties\Strings\AgencyAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Strings\AgencyTrait`</small>


### Agent

-------------------------------------------------------
`string` Someone or something that acts on behalf of someone else or something else

<small>**Interface** : `Aedart\Contracts\Support\Properties\Strings\AgentAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Strings\AgentTrait`</small>


### Alias

-------------------------------------------------------
`string` An alternate name of an item or component

<small>**Interface** : `Aedart\Contracts\Support\Properties\Strings\AliasAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Strings\AliasTrait`</small>


### Amount

-------------------------------------------------------
`int` The quantity of something

<small>**Interface** : `Aedart\Contracts\Support\Properties\Integers\AmountAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Integers\AmountTrait`</small>

-------------------------------------------------------
`float` The quantity of something

<small>**Interface** : `Aedart\Contracts\Support\Properties\Floats\AmountAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Floats\AmountTrait`</small>


### Anniversary

-------------------------------------------------------
`string` Date of anniversary

<small>**Interface** : `Aedart\Contracts\Support\Properties\Strings\AnniversaryAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Strings\AnniversaryTrait`</small>

-------------------------------------------------------
`int` Date of anniversary

<small>**Interface** : `Aedart\Contracts\Support\Properties\Integers\AnniversaryAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Integers\AnniversaryTrait`</small>

-------------------------------------------------------
`\DateTime` Date of anniversary

<small>**Interface** : `Aedart\Contracts\Support\Properties\Dates\AnniversaryAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Dates\AnniversaryTrait`</small>


### Area

-------------------------------------------------------
`string` Name of area, e.g. in a building, in a city, outside the city, ...etc

<small>**Interface** : `Aedart\Contracts\Support\Properties\Strings\AreaAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Strings\AreaTrait`</small>


### Author

-------------------------------------------------------
`string` Name of author

<small>**Interface** : `Aedart\Contracts\Support\Properties\Strings\AuthorAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Strings\AuthorTrait`</small>





### BasePath

-------------------------------------------------------
`string` The path to the root directory of some kind of a resource, e.g. your application, files, pictures,...etc

<small>**Interface** : `Aedart\Contracts\Support\Properties\Strings\BasePathAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Strings\BasePathTrait`</small>


### Begin

-------------------------------------------------------
`string` Location, index or some other identifier of where something begins

<small>**Interface** : `Aedart\Contracts\Support\Properties\Strings\BeginAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Strings\BeginTrait`</small>


### Birthdate

-------------------------------------------------------
`string` Date of birth

<small>**Interface** : `Aedart\Contracts\Support\Properties\Strings\BirthdateAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Strings\BirthdateTrait`</small>

-------------------------------------------------------
`int` Date of birth

<small>**Interface** : `Aedart\Contracts\Support\Properties\Integers\BirthdateAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Integers\BirthdateTrait`</small>

-------------------------------------------------------
`\DateTime` Date of birth

<small>**Interface** : `Aedart\Contracts\Support\Properties\Dates\BirthdateAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Dates\BirthdateTrait`</small>


### Brand

-------------------------------------------------------
`string` Name or identifier of a brand that is associated with a product or service

<small>**Interface** : `Aedart\Contracts\Support\Properties\Strings\BrandAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Strings\BrandTrait`</small>

-------------------------------------------------------
`int` Name or identifier of a brand that is associated with a product or service

<small>**Interface** : `Aedart\Contracts\Support\Properties\Integers\BrandAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Integers\BrandTrait`</small>


### BuildingNumber

-------------------------------------------------------
`string` The house number assigned to a building or apartment in a street or area, e.g. 12a

<small>**Interface** : `Aedart\Contracts\Support\Properties\Strings\BuildingNumberAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Strings\BuildingNumberTrait`</small>





### Callback

-------------------------------------------------------
`callable` Callback method

<small>**Interface** : `Aedart\Contracts\Support\Properties\Callables\CallbackAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Callables\CallbackTrait`</small>


### Calendar

-------------------------------------------------------
`string` Location to calendar, e.g. URI, name, ID or other identifier

<small>**Interface** : `Aedart\Contracts\Support\Properties\Strings\CalendarAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Strings\CalendarTrait`</small>


### CardNumber

-------------------------------------------------------
`string` Numeric or Alphanumeric card number, e.g. for credit cards or other types of cards

<small>**Interface** : `Aedart\Contracts\Support\Properties\Strings\CardNumberAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Strings\CardNumberTrait`</small>


### CardOwner

-------------------------------------------------------
`string` Name of the card owner (cardholder)

<small>**Interface** : `Aedart\Contracts\Support\Properties\Strings\CardOwnerAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Strings\CardOwnerTrait`</small>


### CardType

-------------------------------------------------------
`string` The type of card, e.g. VISA, MasterCard, Playing Card, Magic Card... etc

<small>**Interface** : `Aedart\Contracts\Support\Properties\Strings\CardTypeAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Strings\CardTypeTrait`</small>


### Category

-------------------------------------------------------
`string` Name of category

<small>**Interface** : `Aedart\Contracts\Support\Properties\Strings\CategoryAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Strings\CategoryTrait`</small>


### Categories

-------------------------------------------------------
`array` List of category names

<small>**Interface** : `Aedart\Contracts\Support\Properties\Arrays\CategoriesAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Arrays\CategoriesTrait`</small>


### Choices

-------------------------------------------------------
`array` Various choices that can be made

<small>**Interface** : `Aedart\Contracts\Support\Properties\Arrays\ChoicesAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Arrays\ChoicesTrait`</small>


### City

-------------------------------------------------------
`string` Name of city, town or village

<small>**Interface** : `Aedart\Contracts\Support\Properties\Strings\CityAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Strings\CityTrait`</small>


### Class

-------------------------------------------------------
`string` The class of something or perhaps a class path

<small>**Interface** : `Aedart\Contracts\Support\Properties\Strings\ClassAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Strings\ClassTrait`</small>


### Code

-------------------------------------------------------
`string` The code for something, e.g. language code, classification code, or perhaps an artifacts identifier

<small>**Interface** : `Aedart\Contracts\Support\Properties\Strings\CodeAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Strings\CodeTrait`</small>


### Colour

-------------------------------------------------------
`string` Name of colour or colour value, e.g. RGB, CMYK, HSL or other format

<small>**Interface** : `Aedart\Contracts\Support\Properties\Strings\ColourAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Strings\ColourTrait`</small>


### Column

-------------------------------------------------------
`string` Name of column

<small>**Interface** : `Aedart\Contracts\Support\Properties\Strings\ColumnAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Strings\ColumnTrait`</small>


### Comment

-------------------------------------------------------
`string` A comment

<small>**Interface** : `Aedart\Contracts\Support\Properties\Strings\CommentAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Strings\CommentTrait`</small>


### Company

-------------------------------------------------------
`string` Name of company

<small>**Interface** : `Aedart\Contracts\Support\Properties\Strings\CompanyAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Strings\CompanyTrait`</small>


### Content

-------------------------------------------------------
`string` Content

<small>**Interface** : `Aedart\Contracts\Support\Properties\Strings\ContentAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Strings\ContentTrait`</small>


### Country

-------------------------------------------------------
`string` Name of country, e.g. Denmark, United Kingdom, Australia...etc

<small>**Interface** : `Aedart\Contracts\Support\Properties\Strings\CountryAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Strings\CountryTrait`</small>


### CreatedAt

-------------------------------------------------------
`string` Date of when this component, entity or resource was created

<small>**Interface** : `Aedart\Contracts\Support\Properties\Strings\CreatedAtAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Strings\CreatedAtTrait`</small>

-------------------------------------------------------
`int` Date of when this component, entity or resource was created

<small>**Interface** : `Aedart\Contracts\Support\Properties\Integers\CreatedAtAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Integers\CreatedAtTrait`</small>

-------------------------------------------------------
`\DateTime` Date of when this component, entity or resource was created

<small>**Interface** : `Aedart\Contracts\Support\Properties\Dates\CreatedAtAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Dates\CreatedAtTrait`</small>


### Currency

-------------------------------------------------------
`string` Name, code or other identifier of currency

<small>**Interface** : `Aedart\Contracts\Support\Properties\Strings\CurrencyAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Strings\CurrencyTrait`</small>





### Data

-------------------------------------------------------
`array` A list (array) containing a set of values

<small>**Interface** : `Aedart\Contracts\Support\Properties\Arrays\DataAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Arrays\DataTrait`</small>


### Database

-------------------------------------------------------
`string` Name of database

<small>**Interface** : `Aedart\Contracts\Support\Properties\Strings\DatabaseAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Strings\DatabaseTrait`</small>


### Date

-------------------------------------------------------
`string` Date of event

<small>**Interface** : `Aedart\Contracts\Support\Properties\Strings\DateAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Strings\DateTrait`</small>

-------------------------------------------------------
`int` Date of event

<small>**Interface** : `Aedart\Contracts\Support\Properties\Integers\DateAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Integers\DateTrait`</small>

-------------------------------------------------------
`\DateTime` Date of event

<small>**Interface** : `Aedart\Contracts\Support\Properties\Dates\DateAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Dates\DateTrait`</small>


### DeceasedAt

-------------------------------------------------------
`string` Date of when person, animal of something has died

<small>**Interface** : `Aedart\Contracts\Support\Properties\Strings\DeceasedAtAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Strings\DeceasedAtTrait`</small>

-------------------------------------------------------
`int` Date of when person, animal of something has died

<small>**Interface** : `Aedart\Contracts\Support\Properties\Integers\DeceasedAtAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Integers\DeceasedAtTrait`</small>

-------------------------------------------------------
`\DateTime` Date of when person, animal of something has died

<small>**Interface** : `Aedart\Contracts\Support\Properties\Dates\DeceasedAtAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Dates\DeceasedAtTrait`</small>


### DeletedAt

-------------------------------------------------------
`string` Date of when this component, entity or resource was deleted

<small>**Interface** : `Aedart\Contracts\Support\Properties\Strings\DeletedAtAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Strings\DeletedAtTrait`</small>

-------------------------------------------------------
`int` Date of when this component, entity or resource was deleted

<small>**Interface** : `Aedart\Contracts\Support\Properties\Integers\DeletedAtAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Integers\DeletedAtTrait`</small>

-------------------------------------------------------
`\DateTime` Date of when this component, entity or resource was deleted

<small>**Interface** : `Aedart\Contracts\Support\Properties\Dates\DeletedAtAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Dates\DeletedAtTrait`</small>


### DeliveredAt

-------------------------------------------------------
`string` Date of delivery

<small>**Interface** : `Aedart\Contracts\Support\Properties\Strings\DeliveredAtAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Strings\DeliveredAtTrait`</small>

-------------------------------------------------------
`int` Date of delivery

<small>**Interface** : `Aedart\Contracts\Support\Properties\Integers\DeliveredAtAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Integers\DeliveredAtTrait`</small>

-------------------------------------------------------
`\DateTime` Date of delivery

<small>**Interface** : `Aedart\Contracts\Support\Properties\Dates\DeliveredAtAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Dates\DeliveredAtTrait`</small>


### DeliveryAddress

-------------------------------------------------------
`string` Delivery address

<small>**Interface** : `Aedart\Contracts\Support\Properties\Strings\DeliveryAddressAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Strings\DeliveryAddressTrait`</small>


### DeliveryDate

-------------------------------------------------------
`string` Date of planned delivery

<small>**Interface** : `Aedart\Contracts\Support\Properties\Strings\DeliveryDateAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Strings\DeliveryDateTrait`</small>

-------------------------------------------------------
`int` Date of planned delivery

<small>**Interface** : `Aedart\Contracts\Support\Properties\Integers\DeliveryDateAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Integers\DeliveryDateTrait`</small>

-------------------------------------------------------
`\DateTime` Date of planned delivery

<small>**Interface** : `Aedart\Contracts\Support\Properties\Dates\DeliveryDateAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Dates\DeliveryDateTrait`</small>


### Depth

-------------------------------------------------------
`int` Depth of something

<small>**Interface** : `Aedart\Contracts\Support\Properties\Integers\DepthAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Integers\DepthTrait`</small>

-------------------------------------------------------
`float` Depth of something

<small>**Interface** : `Aedart\Contracts\Support\Properties\Floats\DepthAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Floats\DepthTrait`</small>


### Description

-------------------------------------------------------
`string` Description

<small>**Interface** : `Aedart\Contracts\Support\Properties\Strings\DescriptionAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Strings\DescriptionTrait`</small>


### Directory

-------------------------------------------------------
`string` Path to a given directory, relative or absolute, existing or none-existing

<small>**Interface** : `Aedart\Contracts\Support\Properties\Strings\DirectoryAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Strings\DirectoryTrait`</small>


### Discount

-------------------------------------------------------
`string` Discount amount

<small>**Interface** : `Aedart\Contracts\Support\Properties\Strings\DiscountAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Strings\DiscountTrait`</small>

-------------------------------------------------------
`int` Discount amount

<small>**Interface** : `Aedart\Contracts\Support\Properties\Integers\DiscountAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Integers\DiscountTrait`</small>

-------------------------------------------------------
`float` Discount amount

<small>**Interface** : `Aedart\Contracts\Support\Properties\Floats\DiscountAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Floats\DiscountTrait`</small>


### Distance

-------------------------------------------------------
`string` Distance to or from something

<small>**Interface** : `Aedart\Contracts\Support\Properties\Strings\DistanceAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Strings\DistanceTrait`</small>

-------------------------------------------------------
`int` Distance to or from something

<small>**Interface** : `Aedart\Contracts\Support\Properties\Integers\DistanceAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Integers\DistanceTrait`</small>

-------------------------------------------------------
`float` Distance to or from something

<small>**Interface** : `Aedart\Contracts\Support\Properties\Floats\DistanceAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Floats\DistanceTrait`</small>


### Domain

-------------------------------------------------------
`string` Name, URL, territory or term that describes a given domain... etc

<small>**Interface** : `Aedart\Contracts\Support\Properties\Strings\DomainAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Strings\DomainTrait`</small>


### Duration

-------------------------------------------------------
`string` Duration of some event or media

<small>**Interface** : `Aedart\Contracts\Support\Properties\Strings\DurationAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Strings\DurationTrait`</small>

-------------------------------------------------------
`int` Duration of some event or media

<small>**Interface** : `Aedart\Contracts\Support\Properties\Integers\DurationAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Integers\DurationTrait`</small>

-------------------------------------------------------
`float` Duration of some event or media

<small>**Interface** : `Aedart\Contracts\Support\Properties\Floats\DurationAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Floats\DurationTrait`</small>





### Ean

-------------------------------------------------------
`string` International Article Number (EAN)

<small>**Interface** : `Aedart\Contracts\Support\Properties\Strings\EanAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Strings\EanTrait`</small>


### Ean8

-------------------------------------------------------
`string` International Article Number (EAN), 8-digit

<small>**Interface** : `Aedart\Contracts\Support\Properties\Strings\Ean8Aware`</small>

<small>**Trait** : `Aedart\Support\Properties\Strings\Ean8Trait`</small>


### Ean13

-------------------------------------------------------
`string` International Article Number (EAN), 13-digit

<small>**Interface** : `Aedart\Contracts\Support\Properties\Strings\Ean13Aware`</small>

<small>**Trait** : `Aedart\Support\Properties\Strings\Ean13Trait`</small>


### Edition

-------------------------------------------------------
`string` The version of a published text, e.g. book, article, newspaper, report... etc

<small>**Interface** : `Aedart\Contracts\Support\Properties\Strings\EditionAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Strings\EditionTrait`</small>

-------------------------------------------------------
`int` The version of a published text, e.g. book, article, newspaper, report... etc

<small>**Interface** : `Aedart\Contracts\Support\Properties\Integers\EditionAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Integers\EditionTrait`</small>


### Email

-------------------------------------------------------
`string` Email

<small>**Interface** : `Aedart\Contracts\Support\Properties\Strings\EmailAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Strings\EmailTrait`</small>


### End

-------------------------------------------------------
`string` Location, index or other identifier of when something ends

<small>**Interface** : `Aedart\Contracts\Support\Properties\Strings\EndAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Strings\EndTrait`</small>


### EndDate

-------------------------------------------------------
`string` Date for when some kind of event ends

<small>**Interface** : `Aedart\Contracts\Support\Properties\Strings\EndDateAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Strings\EndDateTrait`</small>

-------------------------------------------------------
`int` Date for when some kind of event ends

<small>**Interface** : `Aedart\Contracts\Support\Properties\Integers\EndDateAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Integers\EndDateTrait`</small>

-------------------------------------------------------
`\DateTime` Date for when some kind of event ends

<small>**Interface** : `Aedart\Contracts\Support\Properties\Dates\EndDateAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Dates\EndDateTrait`</small>


### Error

-------------------------------------------------------
`string` Error name or identifier

<small>**Interface** : `Aedart\Contracts\Support\Properties\Strings\ErrorAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Strings\ErrorTrait`</small>

-------------------------------------------------------
`int` Error name or identifier

<small>**Interface** : `Aedart\Contracts\Support\Properties\Integers\ErrorAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Integers\ErrorTrait`</small>


### Event

-------------------------------------------------------
`string` Event name or identifier

<small>**Interface** : `Aedart\Contracts\Support\Properties\Strings\EventAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Strings\EventTrait`</small>

-------------------------------------------------------
`int` Event name or identifier

<small>**Interface** : `Aedart\Contracts\Support\Properties\Integers\EventAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Integers\EventTrait`</small>


### ExpiresAt

-------------------------------------------------------
`string` Date of when this component, entity or resource is going to expire

<small>**Interface** : `Aedart\Contracts\Support\Properties\Strings\ExpiresAtAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Strings\ExpiresAtTrait`</small>

-------------------------------------------------------
`int` Date of when this component, entity or resource is going to expire

<small>**Interface** : `Aedart\Contracts\Support\Properties\Integers\ExpiresAtAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Integers\ExpiresAtTrait`</small>

-------------------------------------------------------
`\DateTime` Date of when this component, entity or resource is going to expire

<small>**Interface** : `Aedart\Contracts\Support\Properties\Dates\ExpiresAtAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Dates\ExpiresAtTrait`</small>





### FileExtension

-------------------------------------------------------
`string` File extension, e.g. php, avi, json, txt...etc

<small>**Interface** : `Aedart\Contracts\Support\Properties\Strings\FileExtensionAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Strings\FileExtensionTrait`</small>


### Filename

-------------------------------------------------------
`string` Name of given file, with or without path, e.g. myText.txt, /usr/docs/README.md

<small>**Interface** : `Aedart\Contracts\Support\Properties\Strings\FilenameAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Strings\FilenameTrait`</small>


### FilePath

-------------------------------------------------------
`string` Path to a file

<small>**Interface** : `Aedart\Contracts\Support\Properties\Strings\FilePathAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Strings\FilePathTrait`</small>


### FirstName

-------------------------------------------------------
`string` First name (given name) or forename of a person

<small>**Interface** : `Aedart\Contracts\Support\Properties\Strings\FirstNameAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Strings\FirstNameTrait`</small>


### Format

-------------------------------------------------------
`string` The shape, size and presentation or medium of an item or component

<small>**Interface** : `Aedart\Contracts\Support\Properties\Strings\FormatAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Strings\FormatTrait`</small>


### FormattedName

-------------------------------------------------------
`string` Formatted name of someone or something

<small>**Interface** : `Aedart\Contracts\Support\Properties\Strings\FormattedNameAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Strings\FormattedNameTrait`</small>





### Gender

-------------------------------------------------------
`string` Gender (sex) identity of a person, animal or something

<small>**Interface** : `Aedart\Contracts\Support\Properties\Strings\GenderAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Strings\GenderTrait`</small>


### Group

-------------------------------------------------------
`string` Group identifier

<small>**Interface** : `Aedart\Contracts\Support\Properties\Strings\GroupAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Strings\GroupTrait`</small>

-------------------------------------------------------
`int` Group identifier

<small>**Interface** : `Aedart\Contracts\Support\Properties\Integers\GroupAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Integers\GroupTrait`</small>





### Handler

-------------------------------------------------------
`string` Identifier of a handler

<small>**Interface** : `Aedart\Contracts\Support\Properties\Strings\HandlerAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Strings\HandlerTrait`</small>

-------------------------------------------------------
`int` Identifier of a handler

<small>**Interface** : `Aedart\Contracts\Support\Properties\Integers\HandlerAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Integers\HandlerTrait`</small>

-------------------------------------------------------
`callable` Handler callback method

<small>**Interface** : `Aedart\Contracts\Support\Properties\Callables\HandlerAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Callables\HandlerTrait`</small>


### Height

-------------------------------------------------------
`int` Height of something

<small>**Interface** : `Aedart\Contracts\Support\Properties\Integers\HeightAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Integers\HeightTrait`</small>

-------------------------------------------------------
`float` Height of something

<small>**Interface** : `Aedart\Contracts\Support\Properties\Floats\HeightAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Floats\HeightTrait`</small>


### Host

-------------------------------------------------------
`string` Identifier of a host

<small>**Interface** : `Aedart\Contracts\Support\Properties\Strings\HostAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Strings\HostTrait`</small>


### Html

-------------------------------------------------------
`string` HyperText Markup Language (HTML)

<small>**Interface** : `Aedart\Contracts\Support\Properties\Strings\HtmlAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Strings\HtmlTrait`</small>

-------------------------------------------------------
`mixed` HyperText Markup Language (HTML)

<small>**Interface** : `Aedart\Contracts\Support\Properties\Mixed\HtmlAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Mixed\HtmlTrait`</small>





### Iata

-------------------------------------------------------
`string` International Air Transport Association code

<small>**Interface** : `Aedart\Contracts\Support\Properties\Strings\IataAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Strings\IataTrait`</small>


### Iban

-------------------------------------------------------
`string` International Bank Account Number (IBAN)

<small>**Interface** : `Aedart\Contracts\Support\Properties\Strings\IbanAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Strings\IbanTrait`</small>


### Icao

-------------------------------------------------------
`string` International Civil Aviation Organization code

<small>**Interface** : `Aedart\Contracts\Support\Properties\Strings\IcaoAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Strings\IcaoTrait`</small>


### Id

-------------------------------------------------------
`string` Unique identifier

<small>**Interface** : `Aedart\Contracts\Support\Properties\Strings\IdAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Strings\IdTrait`</small>

-------------------------------------------------------
`int` Unique identifier

<small>**Interface** : `Aedart\Contracts\Support\Properties\Integers\IdAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Integers\IdTrait`</small>


### Identifier

-------------------------------------------------------
`string` Name or code that identifies a unique object, resource, class, component or thing

<small>**Interface** : `Aedart\Contracts\Support\Properties\Strings\IdentifierAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Strings\IdentifierTrait`</small>

-------------------------------------------------------
`int` Name or code that identifies a unique object, resource, class, component or thing

<small>**Interface** : `Aedart\Contracts\Support\Properties\Integers\IdentifierAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Integers\IdentifierTrait`</small>


### Image

-------------------------------------------------------
`string` Path, Uri or other type of location to an image

<small>**Interface** : `Aedart\Contracts\Support\Properties\Strings\ImageAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Strings\ImageTrait`</small>


### Index

-------------------------------------------------------
`string` Index

<small>**Interface** : `Aedart\Contracts\Support\Properties\Strings\IndexAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Strings\IndexTrait`</small>

-------------------------------------------------------
`int` Index

<small>**Interface** : `Aedart\Contracts\Support\Properties\Integers\IndexAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Integers\IndexTrait`</small>


### Info

-------------------------------------------------------
`string` Information about someone or something

<small>**Interface** : `Aedart\Contracts\Support\Properties\Strings\InfoAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Strings\InfoTrait`</small>


### Information

-------------------------------------------------------
`string` Information about someone or something

<small>**Interface** : `Aedart\Contracts\Support\Properties\Strings\InformationAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Strings\InformationTrait`</small>


### InvoiceAddress

-------------------------------------------------------
`string` Invoice Address. Can be formatted.

<small>**Interface** : `Aedart\Contracts\Support\Properties\Strings\InvoiceAddressAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Strings\InvoiceAddressTrait`</small>


### Ip

-------------------------------------------------------
`string` IP address

<small>**Interface** : `Aedart\Contracts\Support\Properties\Strings\IpAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Strings\IpTrait`</small>


### IpV4

-------------------------------------------------------
`string` IPv4 address

<small>**Interface** : `Aedart\Contracts\Support\Properties\Strings\IpV4Aware`</small>

<small>**Trait** : `Aedart\Support\Properties\Strings\IpV4Trait`</small>


### IpV6

-------------------------------------------------------
`string` IPv6 address

<small>**Interface** : `Aedart\Contracts\Support\Properties\Strings\IpV6Aware`</small>

<small>**Trait** : `Aedart\Support\Properties\Strings\IpV6Trait`</small>


### IsicV4

-------------------------------------------------------
`string` International Standard of Industrial Classification of All Economic Activities (ISIC), revision 4 code

<small>**Interface** : `Aedart\Contracts\Support\Properties\Strings\IsicV4Aware`</small>

<small>**Trait** : `Aedart\Support\Properties\Strings\IsicV4Trait`</small>


### Isbn

-------------------------------------------------------
`string` International Standard Book Number (ISBN)

<small>**Interface** : `Aedart\Contracts\Support\Properties\Strings\IsbnAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Strings\IsbnTrait`</small>


### Isbn10

-------------------------------------------------------
`string` International Standard Book Number (ISBN), 10-digits

<small>**Interface** : `Aedart\Contracts\Support\Properties\Strings\Isbn10Aware`</small>

<small>**Trait** : `Aedart\Support\Properties\Strings\Isbn10Trait`</small>


### Isbn13

-------------------------------------------------------
`string` International Standard Book Number (ISBN), 13-digits

<small>**Interface** : `Aedart\Contracts\Support\Properties\Strings\Isbn13Aware`</small>

<small>**Trait** : `Aedart\Support\Properties\Strings\Isbn13Trait`</small>





### Json

-------------------------------------------------------
`string` JavaScript Object Notation (JSON)

<small>**Interface** : `Aedart\Contracts\Support\Properties\Strings\JsonAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Strings\JsonTrait`</small>

-------------------------------------------------------
`mixed` JavaScript Object Notation (JSON)

<small>**Interface** : `Aedart\Contracts\Support\Properties\Mixed\JsonAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Mixed\JsonTrait`</small>





### Key

-------------------------------------------------------
`string` Key, e.g. indexing key, encryption key or other type of key

<small>**Interface** : `Aedart\Contracts\Support\Properties\Strings\KeyAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Strings\KeyTrait`</small>


### Kind

-------------------------------------------------------
`string` The kind of object this represents, e.g. human, organisation, group, individual...etc

<small>**Interface** : `Aedart\Contracts\Support\Properties\Strings\KindAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Strings\KindTrait`</small>





### Label

-------------------------------------------------------
`string` Label name

<small>**Interface** : `Aedart\Contracts\Support\Properties\Strings\LabelAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Strings\LabelTrait`</small>


### Language

-------------------------------------------------------
`string` Name or identifier of a language

<small>**Interface** : `Aedart\Contracts\Support\Properties\Strings\LanguageAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Strings\LanguageTrait`</small>


### LastName

-------------------------------------------------------
`string` Last Name (surname) or family name of a person

<small>**Interface** : `Aedart\Contracts\Support\Properties\Strings\LastNameAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Strings\LastNameTrait`</small>


### Latitude

-------------------------------------------------------
`string` North-South position on Earth&#039;s surface

<small>**Interface** : `Aedart\Contracts\Support\Properties\Strings\LatitudeAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Strings\LatitudeTrait`</small>

-------------------------------------------------------
`float` North-South position on Earth&#039;s surface

<small>**Interface** : `Aedart\Contracts\Support\Properties\Floats\LatitudeAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Floats\LatitudeTrait`</small>


### Length

-------------------------------------------------------
`int` Length of something

<small>**Interface** : `Aedart\Contracts\Support\Properties\Integers\LengthAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Integers\LengthTrait`</small>

-------------------------------------------------------
`float` Length of something

<small>**Interface** : `Aedart\Contracts\Support\Properties\Floats\LengthAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Floats\LengthTrait`</small>


### License

-------------------------------------------------------
`string` License name or identifier

<small>**Interface** : `Aedart\Contracts\Support\Properties\Strings\LicenseAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Strings\LicenseTrait`</small>

-------------------------------------------------------
`int` License name or identifier

<small>**Interface** : `Aedart\Contracts\Support\Properties\Integers\LicenseAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Integers\LicenseTrait`</small>


### Link

-------------------------------------------------------
`string` Hyperlink to related resource or action

<small>**Interface** : `Aedart\Contracts\Support\Properties\Strings\LinkAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Strings\LinkTrait`</small>


### Locale

-------------------------------------------------------
`string` Locale language code, e.g. en_us or other format

<small>**Interface** : `Aedart\Contracts\Support\Properties\Strings\LocaleAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Strings\LocaleTrait`</small>


### Location

-------------------------------------------------------
`string` Name or identifier of a location

<small>**Interface** : `Aedart\Contracts\Support\Properties\Strings\LocationAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Strings\LocationTrait`</small>

-------------------------------------------------------
`int` Name or identifier of a location

<small>**Interface** : `Aedart\Contracts\Support\Properties\Integers\LocationAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Integers\LocationTrait`</small>


### Locations

-------------------------------------------------------
`array` List of locations

<small>**Interface** : `Aedart\Contracts\Support\Properties\Arrays\LocationsAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Arrays\LocationsTrait`</small>


### Logo

-------------------------------------------------------
`string` Path, Uri or other type of location to a logo

<small>**Interface** : `Aedart\Contracts\Support\Properties\Strings\LogoAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Strings\LogoTrait`</small>


### Longitude

-------------------------------------------------------
`string` East-West position on Earth&#039;s surface

<small>**Interface** : `Aedart\Contracts\Support\Properties\Strings\LongitudeAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Strings\LongitudeTrait`</small>

-------------------------------------------------------
`float` East-West position on Earth&#039;s surface

<small>**Interface** : `Aedart\Contracts\Support\Properties\Floats\LongitudeAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Floats\LongitudeTrait`</small>





### MacAddress

-------------------------------------------------------
`string` Media Access Control Address (MAC Address)

<small>**Interface** : `Aedart\Contracts\Support\Properties\Strings\MacAddressAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Strings\MacAddressTrait`</small>


### Manufacturer

-------------------------------------------------------
`string` Name or identifier of a manufacturer

<small>**Interface** : `Aedart\Contracts\Support\Properties\Strings\ManufacturerAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Strings\ManufacturerTrait`</small>


### Material

-------------------------------------------------------
`string` Name or identifier of a material, e.g. leather, wool, cotton, paper.

<small>**Interface** : `Aedart\Contracts\Support\Properties\Strings\MaterialAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Strings\MaterialTrait`</small>


### MediaType

-------------------------------------------------------
`string` Media Type (also known as MIME Type), acc. to IANA standard, or perhaps a type name

<small>**Interface** : `Aedart\Contracts\Support\Properties\Strings\MediaTypeAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Strings\MediaTypeTrait`</small>


### Message

-------------------------------------------------------
`string` A message

<small>**Interface** : `Aedart\Contracts\Support\Properties\Strings\MessageAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Strings\MessageTrait`</small>


### Method

-------------------------------------------------------
`string` Name of method or other identifier

<small>**Interface** : `Aedart\Contracts\Support\Properties\Strings\MethodAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Strings\MethodTrait`</small>

-------------------------------------------------------
`int` Name of method or other identifier

<small>**Interface** : `Aedart\Contracts\Support\Properties\Integers\MethodAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Integers\MethodTrait`</small>

-------------------------------------------------------
`callable` Callback method

<small>**Interface** : `Aedart\Contracts\Support\Properties\Callables\MethodAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Callables\MethodTrait`</small>


### MiddleName

-------------------------------------------------------
`string` Middle Name or names of a person

<small>**Interface** : `Aedart\Contracts\Support\Properties\Strings\MiddleNameAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Strings\MiddleNameTrait`</small>





### Name

-------------------------------------------------------
`string` Name

<small>**Interface** : `Aedart\Contracts\Support\Properties\Strings\NameAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Strings\NameTrait`</small>


### NickName

-------------------------------------------------------
`string` Nickname of someone or something

<small>**Interface** : `Aedart\Contracts\Support\Properties\Strings\NickNameAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Strings\NickNameTrait`</small>


### Namespace

-------------------------------------------------------
`string` Namespace

<small>**Interface** : `Aedart\Contracts\Support\Properties\Strings\NamespaceAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Strings\NamespaceTrait`</small>





### On

-------------------------------------------------------
`bool` 

<small>**Interface** : `Aedart\Contracts\Support\Properties\Booleans\OnAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Booleans\OnTrait`</small>


### Off

-------------------------------------------------------
`bool` 

<small>**Interface** : `Aedart\Contracts\Support\Properties\Booleans\OffAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Booleans\OffTrait`</small>


### OrderNumber

-------------------------------------------------------
`string` Number that represents a purchase or order placed by a customer

<small>**Interface** : `Aedart\Contracts\Support\Properties\Strings\OrderNumberAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Strings\OrderNumberTrait`</small>

-------------------------------------------------------
`int` Number that represents a purchase or order placed by a customer

<small>**Interface** : `Aedart\Contracts\Support\Properties\Integers\OrderNumberAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Integers\OrderNumberTrait`</small>


### Organisation

-------------------------------------------------------
`string` Name of organisation

<small>**Interface** : `Aedart\Contracts\Support\Properties\Strings\OrganisationAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Strings\OrganisationTrait`</small>


### OutputPath

-------------------------------------------------------
`string` Location of where some kind of output must be placed or written to

<small>**Interface** : `Aedart\Contracts\Support\Properties\Strings\OutputPathAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Strings\OutputPathTrait`</small>





### Package

-------------------------------------------------------
`string` Name of package. Can evt. contain path to package as well

<small>**Interface** : `Aedart\Contracts\Support\Properties\Strings\PackageAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Strings\PackageTrait`</small>


### Password

-------------------------------------------------------
`string` Password

<small>**Interface** : `Aedart\Contracts\Support\Properties\Strings\PasswordAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Strings\PasswordTrait`</small>


### Path

-------------------------------------------------------
`string` Location of some kind of a resources, e.g. a file, an Url, an index

<small>**Interface** : `Aedart\Contracts\Support\Properties\Strings\PathAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Strings\PathTrait`</small>


### Pattern

-------------------------------------------------------
`string` Some kind of a pattern, e.g. search or regex

<small>**Interface** : `Aedart\Contracts\Support\Properties\Strings\PatternAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Strings\PatternTrait`</small>


### Percent

-------------------------------------------------------
`string` A part or other object per hundred

<small>**Interface** : `Aedart\Contracts\Support\Properties\Strings\PercentAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Strings\PercentTrait`</small>

-------------------------------------------------------
`int` A part or other object per hundred

<small>**Interface** : `Aedart\Contracts\Support\Properties\Integers\PercentAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Integers\PercentTrait`</small>

-------------------------------------------------------
`float` A part or other object per hundred

<small>**Interface** : `Aedart\Contracts\Support\Properties\Floats\PercentAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Floats\PercentTrait`</small>


### Percentage

-------------------------------------------------------
`string` A proportion (especially per hundred)

<small>**Interface** : `Aedart\Contracts\Support\Properties\Strings\PercentageAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Strings\PercentageTrait`</small>

-------------------------------------------------------
`int` A part or other object per hundred

<small>**Interface** : `Aedart\Contracts\Support\Properties\Integers\PercentageAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Integers\PercentageTrait`</small>

-------------------------------------------------------
`float` A proportion (especially per hundred)

<small>**Interface** : `Aedart\Contracts\Support\Properties\Floats\PercentageAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Floats\PercentageTrait`</small>


### Phone

-------------------------------------------------------
`string` Phone number

<small>**Interface** : `Aedart\Contracts\Support\Properties\Strings\PhoneAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Strings\PhoneTrait`</small>


### Photo

-------------------------------------------------------
`string` Path, Uri or other type of location to a photo

<small>**Interface** : `Aedart\Contracts\Support\Properties\Strings\PhotoAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Strings\PhotoTrait`</small>


### PostalCode

-------------------------------------------------------
`string` Numeric or Alphanumeric postal code (zip code)

<small>**Interface** : `Aedart\Contracts\Support\Properties\Strings\PostalCodeAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Strings\PostalCodeTrait`</small>


### Prefix

-------------------------------------------------------
`string` Prefix

<small>**Interface** : `Aedart\Contracts\Support\Properties\Strings\PrefixAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Strings\PrefixTrait`</small>


### Price

-------------------------------------------------------
`string` Numeric price

<small>**Interface** : `Aedart\Contracts\Support\Properties\Strings\PriceAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Strings\PriceTrait`</small>

-------------------------------------------------------
`int` Numeric price

<small>**Interface** : `Aedart\Contracts\Support\Properties\Integers\PriceAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Integers\PriceTrait`</small>

-------------------------------------------------------
`float` Numeric price

<small>**Interface** : `Aedart\Contracts\Support\Properties\Floats\PriceAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Floats\PriceTrait`</small>


### Profile

-------------------------------------------------------
`string` The profile or someone or something

<small>**Interface** : `Aedart\Contracts\Support\Properties\Strings\ProfileAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Strings\ProfileTrait`</small>


### ProducedAt

-------------------------------------------------------
`string` Date of when this component, entity or something was produced

<small>**Interface** : `Aedart\Contracts\Support\Properties\Strings\ProducedAtAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Strings\ProducedAtTrait`</small>

-------------------------------------------------------
`int` Date of when this component, entity or something was produced

<small>**Interface** : `Aedart\Contracts\Support\Properties\Integers\ProducedAtAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Integers\ProducedAtTrait`</small>

-------------------------------------------------------
`\DateTime` Date of when this component, entity or something was produced

<small>**Interface** : `Aedart\Contracts\Support\Properties\Dates\ProducedAtAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Dates\ProducedAtTrait`</small>


### ProductionDate

-------------------------------------------------------
`string` Date of planned production

<small>**Interface** : `Aedart\Contracts\Support\Properties\Strings\ProductionDateAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Strings\ProductionDateTrait`</small>

-------------------------------------------------------
`int` Date of planned production

<small>**Interface** : `Aedart\Contracts\Support\Properties\Integers\ProductionDateAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Integers\ProductionDateTrait`</small>

-------------------------------------------------------
`\DateTime` Date of planned production

<small>**Interface** : `Aedart\Contracts\Support\Properties\Dates\ProductionDateAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Dates\ProductionDateTrait`</small>


### PurchaseDate

-------------------------------------------------------
`string` Date of planned purchase

<small>**Interface** : `Aedart\Contracts\Support\Properties\Strings\PurchaseDateAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Strings\PurchaseDateTrait`</small>

-------------------------------------------------------
`int` Date of planned purchase

<small>**Interface** : `Aedart\Contracts\Support\Properties\Integers\PurchaseDateAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Integers\PurchaseDateTrait`</small>

-------------------------------------------------------
`\DateTime` Date of planned purchase

<small>**Interface** : `Aedart\Contracts\Support\Properties\Dates\PurchaseDateAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Dates\PurchaseDateTrait`</small>


### PurchasedAt

-------------------------------------------------------
`string` Date of when this component, entity or resource was purchased

<small>**Interface** : `Aedart\Contracts\Support\Properties\Strings\PurchasedAtAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Strings\PurchasedAtTrait`</small>

-------------------------------------------------------
`int` Date of when this component, entity or resource was purchased

<small>**Interface** : `Aedart\Contracts\Support\Properties\Integers\PurchasedAtAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Integers\PurchasedAtTrait`</small>

-------------------------------------------------------
`\DateTime` Date of when this component, entity or resource was purchased

<small>**Interface** : `Aedart\Contracts\Support\Properties\Dates\PurchasedAtAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Dates\PurchasedAtTrait`</small>





### Quantity

-------------------------------------------------------
`int` The quantity of something

<small>**Interface** : `Aedart\Contracts\Support\Properties\Integers\QuantityAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Integers\QuantityTrait`</small>

-------------------------------------------------------
`float` The quantity of something

<small>**Interface** : `Aedart\Contracts\Support\Properties\Floats\QuantityAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Floats\QuantityTrait`</small>


### Query

-------------------------------------------------------
`string` Query

<small>**Interface** : `Aedart\Contracts\Support\Properties\Strings\QueryAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Strings\QueryTrait`</small>


### Question

-------------------------------------------------------
`string` A question that can be asked

<small>**Interface** : `Aedart\Contracts\Support\Properties\Strings\QuestionAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Strings\QuestionTrait`</small>





### Rank

-------------------------------------------------------
`string` The position in a hierarchy

<small>**Interface** : `Aedart\Contracts\Support\Properties\Strings\RankAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Strings\RankTrait`</small>

-------------------------------------------------------
`int` The position in a hierarchy

<small>**Interface** : `Aedart\Contracts\Support\Properties\Integers\RankAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Integers\RankTrait`</small>

-------------------------------------------------------
`float` The position in a hierarchy

<small>**Interface** : `Aedart\Contracts\Support\Properties\Floats\RankAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Floats\RankTrait`</small>


### Rate

-------------------------------------------------------
`string` The rate of something, e.g. growth rate, tax rate

<small>**Interface** : `Aedart\Contracts\Support\Properties\Strings\RateAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Strings\RateTrait`</small>

-------------------------------------------------------
`int` The rate of something, e.g. growth rate, tax rate

<small>**Interface** : `Aedart\Contracts\Support\Properties\Integers\RateAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Integers\RateTrait`</small>

-------------------------------------------------------
`float` The rate of something, e.g. growth rate, tax rate

<small>**Interface** : `Aedart\Contracts\Support\Properties\Floats\RateAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Floats\RateTrait`</small>


### Rating

-------------------------------------------------------
`string` The rating of something

<small>**Interface** : `Aedart\Contracts\Support\Properties\Strings\RatingAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Strings\RatingTrait`</small>

-------------------------------------------------------
`int` The rating of something

<small>**Interface** : `Aedart\Contracts\Support\Properties\Integers\RatingAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Integers\RatingTrait`</small>

-------------------------------------------------------
`float` The rating of something

<small>**Interface** : `Aedart\Contracts\Support\Properties\Floats\RatingAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Floats\RatingTrait`</small>


### ReleasedAt

-------------------------------------------------------
`string` Date of when this component, entity or something was released

<small>**Interface** : `Aedart\Contracts\Support\Properties\Strings\ReleasedAtAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Strings\ReleasedAtTrait`</small>

-------------------------------------------------------
`int` Date of when this component, entity or something was released

<small>**Interface** : `Aedart\Contracts\Support\Properties\Integers\ReleasedAtAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Integers\ReleasedAtTrait`</small>

-------------------------------------------------------
`\DateTime` Date of when this component, entity or something was released

<small>**Interface** : `Aedart\Contracts\Support\Properties\Dates\ReleasedAtAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Dates\ReleasedAtTrait`</small>


### ReleaseDate

-------------------------------------------------------
`string` Date of planned release

<small>**Interface** : `Aedart\Contracts\Support\Properties\Strings\ReleaseDateAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Strings\ReleaseDateTrait`</small>

-------------------------------------------------------
`int` Date of planned release

<small>**Interface** : `Aedart\Contracts\Support\Properties\Integers\ReleaseDateAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Integers\ReleaseDateTrait`</small>

-------------------------------------------------------
`\DateTime` Date of planned release

<small>**Interface** : `Aedart\Contracts\Support\Properties\Dates\ReleaseDateAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Dates\ReleaseDateTrait`</small>


### Row

-------------------------------------------------------
`int` A row identifier

<small>**Interface** : `Aedart\Contracts\Support\Properties\Integers\RowAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Integers\RowTrait`</small>


### Region

-------------------------------------------------------
`string` Name of a region, state or province

<small>**Interface** : `Aedart\Contracts\Support\Properties\Strings\RegionAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Strings\RegionTrait`</small>


### Revision

-------------------------------------------------------
`string` A revision, batch number or other identifier

<small>**Interface** : `Aedart\Contracts\Support\Properties\Strings\RevisionAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Strings\RevisionTrait`</small>


### Role

-------------------------------------------------------
`string` Name or identifier of role

<small>**Interface** : `Aedart\Contracts\Support\Properties\Strings\RoleAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Strings\RoleTrait`</small>





### Size

-------------------------------------------------------
`string` The size of something

<small>**Interface** : `Aedart\Contracts\Support\Properties\Strings\SizeAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Strings\SizeTrait`</small>

-------------------------------------------------------
`int` The size of something

<small>**Interface** : `Aedart\Contracts\Support\Properties\Integers\SizeAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Integers\SizeTrait`</small>

-------------------------------------------------------
`float` The size of something

<small>**Interface** : `Aedart\Contracts\Support\Properties\Floats\SizeAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Floats\SizeTrait`</small>


### Script

-------------------------------------------------------
`string` Script of some kind or path to some script

<small>**Interface** : `Aedart\Contracts\Support\Properties\Strings\ScriptAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Strings\ScriptTrait`</small>


### Slug

-------------------------------------------------------
`string` Human readable keyword(s) that can be part or a Url

<small>**Interface** : `Aedart\Contracts\Support\Properties\Strings\SlugAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Strings\SlugTrait`</small>


### Source

-------------------------------------------------------
`string` The source of something. E.g. location, reference, index key, or other identifier that can be used to determine the source

<small>**Interface** : `Aedart\Contracts\Support\Properties\Strings\SourceAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Strings\SourceTrait`</small>


### Sql

-------------------------------------------------------
`string` A Structured Query Language (SQL) query

<small>**Interface** : `Aedart\Contracts\Support\Properties\Strings\SqlAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Strings\SqlTrait`</small>


### StartDate

-------------------------------------------------------
`string` Start date of event

<small>**Interface** : `Aedart\Contracts\Support\Properties\Strings\StartDateAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Strings\StartDateTrait`</small>

-------------------------------------------------------
`int` Start date of event

<small>**Interface** : `Aedart\Contracts\Support\Properties\Integers\StartDateAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Integers\StartDateTrait`</small>

-------------------------------------------------------
`\DateTime` Start date of event

<small>**Interface** : `Aedart\Contracts\Support\Properties\Dates\StartDateAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Dates\StartDateTrait`</small>


### State

-------------------------------------------------------
`string` State of this component or what it represents. Alternative, state address

<small>**Interface** : `Aedart\Contracts\Support\Properties\Strings\StateAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Strings\StateTrait`</small>

-------------------------------------------------------
`int` State of this component or what it represents

<small>**Interface** : `Aedart\Contracts\Support\Properties\Integers\StateAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Integers\StateTrait`</small>


### Status

-------------------------------------------------------
`string` Situation of progress, classification, or civil status

<small>**Interface** : `Aedart\Contracts\Support\Properties\Strings\StatusAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Strings\StatusTrait`</small>

-------------------------------------------------------
`int` Situation of progress, classification, or civil status

<small>**Interface** : `Aedart\Contracts\Support\Properties\Integers\StatusAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Integers\StatusTrait`</small>


### Street

-------------------------------------------------------
`string` Full street address, which might include building or apartment number(s)

<small>**Interface** : `Aedart\Contracts\Support\Properties\Strings\StreetAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Strings\StreetTrait`</small>


### Suffix

-------------------------------------------------------
`string` Suffix

<small>**Interface** : `Aedart\Contracts\Support\Properties\Strings\SuffixAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Strings\SuffixTrait`</small>


### Swift

-------------------------------------------------------
`string` ISO-9362 Swift Code

<small>**Interface** : `Aedart\Contracts\Support\Properties\Strings\SwiftAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Strings\SwiftTrait`</small>





### Table

-------------------------------------------------------
`string` Name of table

<small>**Interface** : `Aedart\Contracts\Support\Properties\Strings\TableAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Strings\TableTrait`</small>


### Tag

-------------------------------------------------------
`string` Name of tag

<small>**Interface** : `Aedart\Contracts\Support\Properties\Strings\TagAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Strings\TagTrait`</small>


### Tags

-------------------------------------------------------
`array` List of tags

<small>**Interface** : `Aedart\Contracts\Support\Properties\Arrays\TagsAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Arrays\TagsTrait`</small>


### Template

-------------------------------------------------------
`string` Template or location of a template file

<small>**Interface** : `Aedart\Contracts\Support\Properties\Strings\TemplateAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Strings\TemplateTrait`</small>


### Text

-------------------------------------------------------
`string` The full text content for something, e.g. an article&#039;s body text

<small>**Interface** : `Aedart\Contracts\Support\Properties\Strings\TextAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Strings\TextTrait`</small>


### Timeout

-------------------------------------------------------
`int` Timeout amount

<small>**Interface** : `Aedart\Contracts\Support\Properties\Integers\TimeoutAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Integers\TimeoutTrait`</small>


### Timestamp

-------------------------------------------------------
`int` Unix timestamp

<small>**Interface** : `Aedart\Contracts\Support\Properties\Integers\TimestampAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Integers\TimestampTrait`</small>


### Timezone

-------------------------------------------------------
`string` Name of timezone

<small>**Interface** : `Aedart\Contracts\Support\Properties\Strings\TimezoneAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Strings\TimezoneTrait`</small>


### Title

-------------------------------------------------------
`string` Title

<small>**Interface** : `Aedart\Contracts\Support\Properties\Strings\TitleAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Strings\TitleTrait`</small>


### Tld

-------------------------------------------------------
`string` Top Level Domain (TLD)

<small>**Interface** : `Aedart\Contracts\Support\Properties\Strings\TldAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Strings\TldTrait`</small>


### Topic

-------------------------------------------------------
`string` Name of topic

<small>**Interface** : `Aedart\Contracts\Support\Properties\Strings\TopicAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Strings\TopicTrait`</small>


### Type

-------------------------------------------------------
`string` Type identifier

<small>**Interface** : `Aedart\Contracts\Support\Properties\Strings\TypeAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Strings\TypeTrait`</small>

-------------------------------------------------------
`int` Type identifier

<small>**Interface** : `Aedart\Contracts\Support\Properties\Integers\TypeAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Integers\TypeTrait`</small>





### UpdatedAt

-------------------------------------------------------
`string` Date of when this component, entity or resource was updated

<small>**Interface** : `Aedart\Contracts\Support\Properties\Strings\UpdatedAtAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Strings\UpdatedAtTrait`</small>

-------------------------------------------------------
`int` Date of when this component, entity or resource was updated

<small>**Interface** : `Aedart\Contracts\Support\Properties\Integers\UpdatedAtAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Integers\UpdatedAtTrait`</small>

-------------------------------------------------------
`\DateTime` Date of when this component, entity or resource was updated

<small>**Interface** : `Aedart\Contracts\Support\Properties\Dates\UpdatedAtAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Dates\UpdatedAtTrait`</small>


### Url

-------------------------------------------------------
`string` Uniform Resource Locator (Url), commonly known as a web address

<small>**Interface** : `Aedart\Contracts\Support\Properties\Strings\UrlAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Strings\UrlTrait`</small>


### Username

-------------------------------------------------------
`string` Identifier to be used as username

<small>**Interface** : `Aedart\Contracts\Support\Properties\Strings\UsernameAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Strings\UsernameTrait`</small>


### Uuid

-------------------------------------------------------
`string` Universally Unique Identifier (UUID)

<small>**Interface** : `Aedart\Contracts\Support\Properties\Strings\UuidAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Strings\UuidTrait`</small>





### Value

-------------------------------------------------------
`string` Value

<small>**Interface** : `Aedart\Contracts\Support\Properties\Strings\ValueAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Strings\ValueTrait`</small>

-------------------------------------------------------
`mixed` Value

<small>**Interface** : `Aedart\Contracts\Support\Properties\Mixed\ValueAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Mixed\ValueTrait`</small>


### Vat

-------------------------------------------------------
`string` Value Added Tac (VAT), formatted amount or rate

<small>**Interface** : `Aedart\Contracts\Support\Properties\Strings\VatAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Strings\VatTrait`</small>

-------------------------------------------------------
`int` Value Added Tac (VAT), formatted amount or rate

<small>**Interface** : `Aedart\Contracts\Support\Properties\Integers\VatAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Integers\VatTrait`</small>

-------------------------------------------------------
`float` Value Added Tac (VAT), formatted amount or rate

<small>**Interface** : `Aedart\Contracts\Support\Properties\Floats\VatAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Floats\VatTrait`</small>


### Vendor

-------------------------------------------------------
`string` Name or path of a vendor

<small>**Interface** : `Aedart\Contracts\Support\Properties\Strings\VendorAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Strings\VendorTrait`</small>


### Version

-------------------------------------------------------
`string` Version

<small>**Interface** : `Aedart\Contracts\Support\Properties\Strings\VersionAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Strings\VersionTrait`</small>





### Weight

-------------------------------------------------------
`int` Weight of something

<small>**Interface** : `Aedart\Contracts\Support\Properties\Integers\WeightAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Integers\WeightTrait`</small>

-------------------------------------------------------
`float` Weight of something

<small>**Interface** : `Aedart\Contracts\Support\Properties\Floats\WeightAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Floats\WeightTrait`</small>


### Width

-------------------------------------------------------
`int` Width of something

<small>**Interface** : `Aedart\Contracts\Support\Properties\Integers\WidthAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Integers\WidthTrait`</small>

-------------------------------------------------------
`float` Width of something

<small>**Interface** : `Aedart\Contracts\Support\Properties\Floats\WidthAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Floats\WidthTrait`</small>


### Wildcard

-------------------------------------------------------
`string` Wildcard identifier

<small>**Interface** : `Aedart\Contracts\Support\Properties\Strings\WildcardAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Strings\WildcardTrait`</small>





### X

-------------------------------------------------------
`int` Co-ordinate or value

<small>**Interface** : `Aedart\Contracts\Support\Properties\Integers\XAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Integers\XTrait`</small>

-------------------------------------------------------
`float` Co-ordinate or value

<small>**Interface** : `Aedart\Contracts\Support\Properties\Floats\XAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Floats\XTrait`</small>

-------------------------------------------------------
`mixed` Co-ordinate or value

<small>**Interface** : `Aedart\Contracts\Support\Properties\Mixed\XAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Mixed\XTrait`</small>


### Xml

-------------------------------------------------------
`string` Extensible Markup Language (XML)

<small>**Interface** : `Aedart\Contracts\Support\Properties\Strings\XmlAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Strings\XmlTrait`</small>

-------------------------------------------------------
`mixed` Extensible Markup Language (XML)

<small>**Interface** : `Aedart\Contracts\Support\Properties\Mixed\XmlAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Mixed\XmlTrait`</small>





### Y

-------------------------------------------------------
`int` Co-ordinate or value

<small>**Interface** : `Aedart\Contracts\Support\Properties\Integers\YAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Integers\YTrait`</small>

-------------------------------------------------------
`float` Co-ordinate or value

<small>**Interface** : `Aedart\Contracts\Support\Properties\Floats\YAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Floats\YTrait`</small>

-------------------------------------------------------
`mixed` Co-ordinate or value

<small>**Interface** : `Aedart\Contracts\Support\Properties\Mixed\YAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Mixed\YTrait`</small>





### Z

-------------------------------------------------------
`int` Co-ordinate or value

<small>**Interface** : `Aedart\Contracts\Support\Properties\Integers\ZAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Integers\ZTrait`</small>

-------------------------------------------------------
`float` Co-ordinate or value

<small>**Interface** : `Aedart\Contracts\Support\Properties\Floats\ZAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Floats\ZTrait`</small>

-------------------------------------------------------
`mixed` Co-ordinate or value

<small>**Interface** : `Aedart\Contracts\Support\Properties\Mixed\ZAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Mixed\ZTrait`</small>


### Zone

-------------------------------------------------------
`string` Name or identifier of area, district or division

<small>**Interface** : `Aedart\Contracts\Support\Properties\Strings\ZoneAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Strings\ZoneTrait`</small>

-------------------------------------------------------
`int` Name or identifier of area, district or division

<small>**Interface** : `Aedart\Contracts\Support\Properties\Integers\ZoneAware`</small>

<small>**Trait** : `Aedart\Support\Properties\Integers\ZoneTrait`</small>




