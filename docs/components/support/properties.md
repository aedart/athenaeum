---
sidebarDepth: 3
---

# Aware Of Properties

Below is a list of default aware-of components that are offered by this package.
They are suitable for usage with the [Dto abstraction](../dto/README.md) or for situations where you require your components to be aware of some kind of property.

## Make You Own

If you cannot find a specific aware-of component, then you can [request a new component](https://github.com/aedart/athenaeum/issues).
Alternatively, you can generate your own, by using the available [Dto Generator](./generator.md), which has also been used to generate these components.

## Available Aware-Of Components

The following list are the available aware-of components.

### A

#### Action

| Type | Description | Namespaces |
|------|-------------|------------|
| <small>`string`</small> | A process or fact of doing something | <small>`Aedart\Contracts\Support\Properties\Strings\ActionAware` <br> `Aedart\Support\Properties\Strings\ActionTrait`</small> |

#### Address

| Type | Description | Namespaces |
|------|-------------|------------|
| <small>`string`</small> | Address to someone or something | <small>`Aedart\Contracts\Support\Properties\Strings\AddressAware` <br> `Aedart\Support\Properties\Strings\AddressTrait`</small> |

#### Age

| Type | Description | Namespaces |
|------|-------------|------------|
| <small>`int`</small> | Age of someone or something | <small>`Aedart\Contracts\Support\Properties\Integers\AgeAware` <br> `Aedart\Support\Properties\Integers\AgeTrait`</small> |

#### Agent

| Type | Description | Namespaces |
|------|-------------|------------|
| <small>`string`</small> | Someone or something that acts on behalf of someone else or something else | <small>`Aedart\Contracts\Support\Properties\Strings\AgentAware` <br> `Aedart\Support\Properties\Strings\AgentTrait`</small> |

#### Alias

| Type | Description | Namespaces |
|------|-------------|------------|
| <small>`string`</small> | An alternate name of an item or component | <small>`Aedart\Contracts\Support\Properties\Strings\AliasAware` <br> `Aedart\Support\Properties\Strings\AliasTrait`</small> |

#### Amount

| Type | Description | Namespaces |
|------|-------------|------------|
| <small>`int`</small> | The quantity of something | <small>`Aedart\Contracts\Support\Properties\Integers\AmountAware` <br> `Aedart\Support\Properties\Integers\AmountTrait`</small> |
| <small>`float`</small> | The quantity of something | <small>`Aedart\Contracts\Support\Properties\Floats\AmountAware` <br> `Aedart\Support\Properties\Floats\AmountTrait`</small> |

#### Anniversary

| Type | Description | Namespaces |
|------|-------------|------------|
| <small>`string`</small> | Date of anniversary | <small>`Aedart\Contracts\Support\Properties\Strings\AnniversaryAware` <br> `Aedart\Support\Properties\Strings\AnniversaryTrait`</small> |
| <small>`int`</small> | Date of anniversary | <small>`Aedart\Contracts\Support\Properties\Integers\AnniversaryAware` <br> `Aedart\Support\Properties\Integers\AnniversaryTrait`</small> |

#### Area

| Type | Description | Namespaces |
|------|-------------|------------|
| <small>`string`</small> | Name of area, e.g. in a building, in a city, outside the city, ...etc | <small>`Aedart\Contracts\Support\Properties\Strings\AreaAware` <br> `Aedart\Support\Properties\Strings\AreaTrait`</small> |

#### Author

| Type | Description | Namespaces |
|------|-------------|------------|
| <small>`string`</small> | Name of author | <small>`Aedart\Contracts\Support\Properties\Strings\AuthorAware` <br> `Aedart\Support\Properties\Strings\AuthorTrait`</small> |



### B

#### BasePath

| Type | Description | Namespaces |
|------|-------------|------------|
| <small>`string`</small> | The path to the root directory of some kind of a resource, e.g. your application, files, pictures,...etc | <small>`Aedart\Contracts\Support\Properties\Strings\BasePathAware` <br> `Aedart\Support\Properties\Strings\BasePathTrait`</small> |

#### Begin

| Type | Description | Namespaces |
|------|-------------|------------|
| <small>`string`</small> | Location, index or some other identifier of where something begins | <small>`Aedart\Contracts\Support\Properties\Strings\BeginAware` <br> `Aedart\Support\Properties\Strings\BeginTrait`</small> |

#### Birthdate

| Type | Description | Namespaces |
|------|-------------|------------|
| <small>`string`</small> | Date of birth | <small>`Aedart\Contracts\Support\Properties\Strings\BirthdateAware` <br> `Aedart\Support\Properties\Strings\BirthdateTrait`</small> |
| <small>`int`</small> | Date of birth | <small>`Aedart\Contracts\Support\Properties\Integers\BirthdateAware` <br> `Aedart\Support\Properties\Integers\BirthdateTrait`</small> |

#### Brand

| Type | Description | Namespaces |
|------|-------------|------------|
| <small>`string`</small> | Name or identifier of a brand that is associated with a product or service | <small>`Aedart\Contracts\Support\Properties\Strings\BrandAware` <br> `Aedart\Support\Properties\Strings\BrandTrait`</small> |
| <small>`int`</small> | Name or identifier of a brand that is associated with a product or service | <small>`Aedart\Contracts\Support\Properties\Integers\BrandAware` <br> `Aedart\Support\Properties\Integers\BrandTrait`</small> |

#### BuildingNumber

| Type | Description | Namespaces |
|------|-------------|------------|
| <small>`string`</small> | The house number assigned to a building or apartment in a street or area, e.g. 12a | <small>`Aedart\Contracts\Support\Properties\Strings\BuildingNumberAware` <br> `Aedart\Support\Properties\Strings\BuildingNumberTrait`</small> |



### C

#### Calendar

| Type | Description | Namespaces |
|------|-------------|------------|
| <small>`string`</small> | Location to calendar, e.g. URI, name, ID or other identifier | <small>`Aedart\Contracts\Support\Properties\Strings\CalendarAware` <br> `Aedart\Support\Properties\Strings\CalendarTrait`</small> |

#### CardNumber

| Type | Description | Namespaces |
|------|-------------|------------|
| <small>`string`</small> | Numeric or Alphanumeric card number, e.g. for credit cards or other types of cards | <small>`Aedart\Contracts\Support\Properties\Strings\CardNumberAware` <br> `Aedart\Support\Properties\Strings\CardNumberTrait`</small> |

#### CardOwner

| Type | Description | Namespaces |
|------|-------------|------------|
| <small>`string`</small> | Name of the card owner (cardholder) | <small>`Aedart\Contracts\Support\Properties\Strings\CardOwnerAware` <br> `Aedart\Support\Properties\Strings\CardOwnerTrait`</small> |

#### CardType

| Type | Description | Namespaces |
|------|-------------|------------|
| <small>`string`</small> | The type of card, e.g. VISA, MasterCard, Playing Card, Magic Card... etc | <small>`Aedart\Contracts\Support\Properties\Strings\CardTypeAware` <br> `Aedart\Support\Properties\Strings\CardTypeTrait`</small> |

#### Category

| Type | Description | Namespaces |
|------|-------------|------------|
| <small>`string`</small> | Name of category | <small>`Aedart\Contracts\Support\Properties\Strings\CategoryAware` <br> `Aedart\Support\Properties\Strings\CategoryTrait`</small> |

#### Categories

| Type | Description | Namespaces |
|------|-------------|------------|
| <small>`array`</small> | List of category names | <small>`Aedart\Contracts\Support\Properties\Arrays\CategoriesAware` <br> `Aedart\Support\Properties\Arrays\CategoriesTrait`</small> |

#### Choices

| Type | Description | Namespaces |
|------|-------------|------------|
| <small>`array`</small> | Various choices that can be made | <small>`Aedart\Contracts\Support\Properties\Arrays\ChoicesAware` <br> `Aedart\Support\Properties\Arrays\ChoicesTrait`</small> |

#### City

| Type | Description | Namespaces |
|------|-------------|------------|
| <small>`string`</small> | Name of city, town or village | <small>`Aedart\Contracts\Support\Properties\Strings\CityAware` <br> `Aedart\Support\Properties\Strings\CityTrait`</small> |

#### Class

| Type | Description | Namespaces |
|------|-------------|------------|
| <small>`string`</small> | The class of something or perhaps a class path | <small>`Aedart\Contracts\Support\Properties\Strings\ClassAware` <br> `Aedart\Support\Properties\Strings\ClassTrait`</small> |

#### Code

| Type | Description | Namespaces |
|------|-------------|------------|
| <small>`string`</small> | The code for something, e.g. language code, classification code, or perhaps an artifacts identifier | <small>`Aedart\Contracts\Support\Properties\Strings\CodeAware` <br> `Aedart\Support\Properties\Strings\CodeTrait`</small> |

#### Colour

| Type | Description | Namespaces |
|------|-------------|------------|
| <small>`string`</small> | Name of colour or colour value, e.g. RGB, CMYK, HSL or other format | <small>`Aedart\Contracts\Support\Properties\Strings\ColourAware` <br> `Aedart\Support\Properties\Strings\ColourTrait`</small> |

#### Column

| Type | Description | Namespaces |
|------|-------------|------------|
| <small>`string`</small> | Name of column | <small>`Aedart\Contracts\Support\Properties\Strings\ColumnAware` <br> `Aedart\Support\Properties\Strings\ColumnTrait`</small> |

#### Comment

| Type | Description | Namespaces |
|------|-------------|------------|
| <small>`string`</small> | A comment | <small>`Aedart\Contracts\Support\Properties\Strings\CommentAware` <br> `Aedart\Support\Properties\Strings\CommentTrait`</small> |

#### Company

| Type | Description | Namespaces |
|------|-------------|------------|
| <small>`string`</small> | Name of company | <small>`Aedart\Contracts\Support\Properties\Strings\CompanyAware` <br> `Aedart\Support\Properties\Strings\CompanyTrait`</small> |

#### Content

| Type | Description | Namespaces |
|------|-------------|------------|
| <small>`string`</small> | Content | <small>`Aedart\Contracts\Support\Properties\Strings\ContentAware` <br> `Aedart\Support\Properties\Strings\ContentTrait`</small> |

#### Country

| Type | Description | Namespaces |
|------|-------------|------------|
| <small>`string`</small> | Name of country, e.g. Denmark, United Kingdom, Australia...etc | <small>`Aedart\Contracts\Support\Properties\Strings\CountryAware` <br> `Aedart\Support\Properties\Strings\CountryTrait`</small> |

#### CreatedAt

| Type | Description | Namespaces |
|------|-------------|------------|
| <small>`string`</small> | Date of when this component, entity or resource was created | <small>`Aedart\Contracts\Support\Properties\Strings\CreatedAtAware` <br> `Aedart\Support\Properties\Strings\CreatedAtTrait`</small> |
| <small>`int`</small> | Date of when this component, entity or resource was created | <small>`Aedart\Contracts\Support\Properties\Integers\CreatedAtAware` <br> `Aedart\Support\Properties\Integers\CreatedAtTrait`</small> |

#### Currency

| Type | Description | Namespaces |
|------|-------------|------------|
| <small>`string`</small> | Name, code or other identifier of currency | <small>`Aedart\Contracts\Support\Properties\Strings\CurrencyAware` <br> `Aedart\Support\Properties\Strings\CurrencyTrait`</small> |



### D

#### Data

| Type | Description | Namespaces |
|------|-------------|------------|
| <small>`array`</small> | A list (array) containing a set of values | <small>`Aedart\Contracts\Support\Properties\Arrays\DataAware` <br> `Aedart\Support\Properties\Arrays\DataTrait`</small> |

#### Database

| Type | Description | Namespaces |
|------|-------------|------------|
| <small>`string`</small> | Name of database | <small>`Aedart\Contracts\Support\Properties\Strings\DatabaseAware` <br> `Aedart\Support\Properties\Strings\DatabaseTrait`</small> |

#### Date

| Type | Description | Namespaces |
|------|-------------|------------|
| <small>`string`</small> | Date of event | <small>`Aedart\Contracts\Support\Properties\Strings\DateAware` <br> `Aedart\Support\Properties\Strings\DateTrait`</small> |
| <small>`int`</small> | Date of event | <small>`Aedart\Contracts\Support\Properties\Integers\DateAware` <br> `Aedart\Support\Properties\Integers\DateTrait`</small> |

#### DeceasedAt

| Type | Description | Namespaces |
|------|-------------|------------|
| <small>`string`</small> | Date of when person, animal of something has died | <small>`Aedart\Contracts\Support\Properties\Strings\DeceasedAtAware` <br> `Aedart\Support\Properties\Strings\DeceasedAtTrait`</small> |
| <small>`int`</small> | Date of when person, animal of something has died | <small>`Aedart\Contracts\Support\Properties\Integers\DeceasedAtAware` <br> `Aedart\Support\Properties\Integers\DeceasedAtTrait`</small> |

#### DeletedAt

| Type | Description | Namespaces |
|------|-------------|------------|
| <small>`string`</small> | Date of when this component, entity or resource was deleted | <small>`Aedart\Contracts\Support\Properties\Strings\DeletedAtAware` <br> `Aedart\Support\Properties\Strings\DeletedAtTrait`</small> |
| <small>`int`</small> | Date of when this component, entity or resource was deleted | <small>`Aedart\Contracts\Support\Properties\Integers\DeletedAtAware` <br> `Aedart\Support\Properties\Integers\DeletedAtTrait`</small> |

#### DeliveredAt

| Type | Description | Namespaces |
|------|-------------|------------|
| <small>`string`</small> | Date of delivery | <small>`Aedart\Contracts\Support\Properties\Strings\DeliveredAtAware` <br> `Aedart\Support\Properties\Strings\DeliveredAtTrait`</small> |
| <small>`int`</small> | Date of delivery | <small>`Aedart\Contracts\Support\Properties\Integers\DeliveredAtAware` <br> `Aedart\Support\Properties\Integers\DeliveredAtTrait`</small> |

#### DeliveryAddress

| Type | Description | Namespaces |
|------|-------------|------------|
| <small>`string`</small> | Delivery address | <small>`Aedart\Contracts\Support\Properties\Strings\DeliveryAddressAware` <br> `Aedart\Support\Properties\Strings\DeliveryAddressTrait`</small> |

#### DeliveryDate

| Type | Description | Namespaces |
|------|-------------|------------|
| <small>`string`</small> | Date of planned delivery | <small>`Aedart\Contracts\Support\Properties\Strings\DeliveryDateAware` <br> `Aedart\Support\Properties\Strings\DeliveryDateTrait`</small> |
| <small>`int`</small> | Date of planned delivery | <small>`Aedart\Contracts\Support\Properties\Integers\DeliveryDateAware` <br> `Aedart\Support\Properties\Integers\DeliveryDateTrait`</small> |

#### Depth

| Type | Description | Namespaces |
|------|-------------|------------|
| <small>`int`</small> | Depth of something | <small>`Aedart\Contracts\Support\Properties\Integers\DepthAware` <br> `Aedart\Support\Properties\Integers\DepthTrait`</small> |
| <small>`float`</small> | Depth of something | <small>`Aedart\Contracts\Support\Properties\Floats\DepthAware` <br> `Aedart\Support\Properties\Floats\DepthTrait`</small> |

#### Description

| Type | Description | Namespaces |
|------|-------------|------------|
| <small>`string`</small> | Description | <small>`Aedart\Contracts\Support\Properties\Strings\DescriptionAware` <br> `Aedart\Support\Properties\Strings\DescriptionTrait`</small> |

#### Directory

| Type | Description | Namespaces |
|------|-------------|------------|
| <small>`string`</small> | Path to a given directory, relative or absolute, existing or none-existing | <small>`Aedart\Contracts\Support\Properties\Strings\DirectoryAware` <br> `Aedart\Support\Properties\Strings\DirectoryTrait`</small> |

#### Discount

| Type | Description | Namespaces |
|------|-------------|------------|
| <small>`string`</small> | Discount amount | <small>`Aedart\Contracts\Support\Properties\Strings\DiscountAware` <br> `Aedart\Support\Properties\Strings\DiscountTrait`</small> |
| <small>`int`</small> | Discount amount | <small>`Aedart\Contracts\Support\Properties\Integers\DiscountAware` <br> `Aedart\Support\Properties\Integers\DiscountTrait`</small> |
| <small>`float`</small> | Discount amount | <small>`Aedart\Contracts\Support\Properties\Floats\DiscountAware` <br> `Aedart\Support\Properties\Floats\DiscountTrait`</small> |

#### Distance

| Type | Description | Namespaces |
|------|-------------|------------|
| <small>`string`</small> | Distance to or from something | <small>`Aedart\Contracts\Support\Properties\Strings\DistanceAware` <br> `Aedart\Support\Properties\Strings\DistanceTrait`</small> |
| <small>`int`</small> | Distance to or from something | <small>`Aedart\Contracts\Support\Properties\Integers\DistanceAware` <br> `Aedart\Support\Properties\Integers\DistanceTrait`</small> |
| <small>`float`</small> | Distance to or from something | <small>`Aedart\Contracts\Support\Properties\Floats\DistanceAware` <br> `Aedart\Support\Properties\Floats\DistanceTrait`</small> |

#### Domain

| Type | Description | Namespaces |
|------|-------------|------------|
| <small>`string`</small> | Name, URL, territory or term that describes a given domain... etc | <small>`Aedart\Contracts\Support\Properties\Strings\DomainAware` <br> `Aedart\Support\Properties\Strings\DomainTrait`</small> |

#### Duration

| Type | Description | Namespaces |
|------|-------------|------------|
| <small>`string`</small> | Duration of some event or media | <small>`Aedart\Contracts\Support\Properties\Strings\DurationAware` <br> `Aedart\Support\Properties\Strings\DurationTrait`</small> |
| <small>`int`</small> | Duration of some event or media | <small>`Aedart\Contracts\Support\Properties\Integers\DurationAware` <br> `Aedart\Support\Properties\Integers\DurationTrait`</small> |
| <small>`float`</small> | Duration of some event or media | <small>`Aedart\Contracts\Support\Properties\Floats\DurationAware` <br> `Aedart\Support\Properties\Floats\DurationTrait`</small> |



### E

#### Ean

| Type | Description | Namespaces |
|------|-------------|------------|
| <small>`string`</small> | International Article Number (EAN) | <small>`Aedart\Contracts\Support\Properties\Strings\EanAware` <br> `Aedart\Support\Properties\Strings\EanTrait`</small> |

#### Ean8

| Type | Description | Namespaces |
|------|-------------|------------|
| <small>`string`</small> | International Article Number (EAN), 8-digit | <small>`Aedart\Contracts\Support\Properties\Strings\Ean8Aware` <br> `Aedart\Support\Properties\Strings\Ean8Trait`</small> |

#### Ean13

| Type | Description | Namespaces |
|------|-------------|------------|
| <small>`string`</small> | International Article Number (EAN), 13-digit | <small>`Aedart\Contracts\Support\Properties\Strings\Ean13Aware` <br> `Aedart\Support\Properties\Strings\Ean13Trait`</small> |

#### Edition

| Type | Description | Namespaces |
|------|-------------|------------|
| <small>`string`</small> | The version of a published text, e.g. book, article, newspaper, report... etc | <small>`Aedart\Contracts\Support\Properties\Strings\EditionAware` <br> `Aedart\Support\Properties\Strings\EditionTrait`</small> |
| <small>`int`</small> | The version of a published text, e.g. book, article, newspaper, report... etc | <small>`Aedart\Contracts\Support\Properties\Integers\EditionAware` <br> `Aedart\Support\Properties\Integers\EditionTrait`</small> |

#### Email

| Type | Description | Namespaces |
|------|-------------|------------|
| <small>`string`</small> | Email | <small>`Aedart\Contracts\Support\Properties\Strings\EmailAware` <br> `Aedart\Support\Properties\Strings\EmailTrait`</small> |

#### End

| Type | Description | Namespaces |
|------|-------------|------------|
| <small>`string`</small> | Location, index or other identifier of when something ends | <small>`Aedart\Contracts\Support\Properties\Strings\EndAware` <br> `Aedart\Support\Properties\Strings\EndTrait`</small> |

#### EndDate

| Type | Description | Namespaces |
|------|-------------|------------|
| <small>`string`</small> | Date for when some kind of event ends | <small>`Aedart\Contracts\Support\Properties\Strings\EndDateAware` <br> `Aedart\Support\Properties\Strings\EndDateTrait`</small> |
| <small>`int`</small> | Date for when some kind of event ends | <small>`Aedart\Contracts\Support\Properties\Integers\EndDateAware` <br> `Aedart\Support\Properties\Integers\EndDateTrait`</small> |

#### Error

| Type | Description | Namespaces |
|------|-------------|------------|
| <small>`string`</small> | Error name or identifier | <small>`Aedart\Contracts\Support\Properties\Strings\ErrorAware` <br> `Aedart\Support\Properties\Strings\ErrorTrait`</small> |
| <small>`int`</small> | Error name or identifier | <small>`Aedart\Contracts\Support\Properties\Integers\ErrorAware` <br> `Aedart\Support\Properties\Integers\ErrorTrait`</small> |

#### Event

| Type | Description | Namespaces |
|------|-------------|------------|
| <small>`string`</small> | Event name or identifier | <small>`Aedart\Contracts\Support\Properties\Strings\EventAware` <br> `Aedart\Support\Properties\Strings\EventTrait`</small> |
| <small>`int`</small> | Event name or identifier | <small>`Aedart\Contracts\Support\Properties\Integers\EventAware` <br> `Aedart\Support\Properties\Integers\EventTrait`</small> |

#### ExpiresAt

| Type | Description | Namespaces |
|------|-------------|------------|
| <small>`string`</small> | Date of when this component, entity or resource is going to expire | <small>`Aedart\Contracts\Support\Properties\Strings\ExpiresAtAware` <br> `Aedart\Support\Properties\Strings\ExpiresAtTrait`</small> |
| <small>`int`</small> | Date of when this component, entity or resource is going to expire | <small>`Aedart\Contracts\Support\Properties\Integers\ExpiresAtAware` <br> `Aedart\Support\Properties\Integers\ExpiresAtTrait`</small> |



### F

#### FileExtension

| Type | Description | Namespaces |
|------|-------------|------------|
| <small>`string`</small> | File extension, e.g. php, avi, json, txt...etc | <small>`Aedart\Contracts\Support\Properties\Strings\FileExtensionAware` <br> `Aedart\Support\Properties\Strings\FileExtensionTrait`</small> |

#### Filename

| Type | Description | Namespaces |
|------|-------------|------------|
| <small>`string`</small> | Name of given file, with or without path, e.g. myText.txt, /usr/docs/README.md | <small>`Aedart\Contracts\Support\Properties\Strings\FilenameAware` <br> `Aedart\Support\Properties\Strings\FilenameTrait`</small> |

#### FilePath

| Type | Description | Namespaces |
|------|-------------|------------|
| <small>`string`</small> | Path to a file | <small>`Aedart\Contracts\Support\Properties\Strings\FilePathAware` <br> `Aedart\Support\Properties\Strings\FilePathTrait`</small> |

#### FirstName

| Type | Description | Namespaces |
|------|-------------|------------|
| <small>`string`</small> | First name (given name) or forename of a person | <small>`Aedart\Contracts\Support\Properties\Strings\FirstNameAware` <br> `Aedart\Support\Properties\Strings\FirstNameTrait`</small> |

#### Format

| Type | Description | Namespaces |
|------|-------------|------------|
| <small>`string`</small> | The shape, size and presentation or medium of an item or component | <small>`Aedart\Contracts\Support\Properties\Strings\FormatAware` <br> `Aedart\Support\Properties\Strings\FormatTrait`</small> |

#### FormattedName

| Type | Description | Namespaces |
|------|-------------|------------|
| <small>`string`</small> | Formatted name of someone or something | <small>`Aedart\Contracts\Support\Properties\Strings\FormattedNameAware` <br> `Aedart\Support\Properties\Strings\FormattedNameTrait`</small> |



### G

#### Gender

| Type | Description | Namespaces |
|------|-------------|------------|
| <small>`string`</small> | Gender (sex) identity of a person, animal or something | <small>`Aedart\Contracts\Support\Properties\Strings\GenderAware` <br> `Aedart\Support\Properties\Strings\GenderTrait`</small> |

#### Group

| Type | Description | Namespaces |
|------|-------------|------------|
| <small>`string`</small> | Group identifier | <small>`Aedart\Contracts\Support\Properties\Strings\GroupAware` <br> `Aedart\Support\Properties\Strings\GroupTrait`</small> |
| <small>`int`</small> | Group identifier | <small>`Aedart\Contracts\Support\Properties\Integers\GroupAware` <br> `Aedart\Support\Properties\Integers\GroupTrait`</small> |



### H

#### Height

| Type | Description | Namespaces |
|------|-------------|------------|
| <small>`int`</small> | Height of something | <small>`Aedart\Contracts\Support\Properties\Integers\HeightAware` <br> `Aedart\Support\Properties\Integers\HeightTrait`</small> |
| <small>`float`</small> | Height of something | <small>`Aedart\Contracts\Support\Properties\Floats\HeightAware` <br> `Aedart\Support\Properties\Floats\HeightTrait`</small> |

#### Host

| Type | Description | Namespaces |
|------|-------------|------------|
| <small>`string`</small> | Identifier of a host | <small>`Aedart\Contracts\Support\Properties\Strings\HostAware` <br> `Aedart\Support\Properties\Strings\HostTrait`</small> |

#### Html

| Type | Description | Namespaces |
|------|-------------|------------|
| <small>`string`</small> | HyperText Markup Language (HTML) | <small>`Aedart\Contracts\Support\Properties\Strings\HtmlAware` <br> `Aedart\Support\Properties\Strings\HtmlTrait`</small> |



### I

#### Iata

| Type | Description | Namespaces |
|------|-------------|------------|
| <small>`string`</small> | International Air Transport Association code | <small>`Aedart\Contracts\Support\Properties\Strings\IataAware` <br> `Aedart\Support\Properties\Strings\IataTrait`</small> |

#### Iban

| Type | Description | Namespaces |
|------|-------------|------------|
| <small>`string`</small> | International Bank Account Number (IBAN) | <small>`Aedart\Contracts\Support\Properties\Strings\IbanAware` <br> `Aedart\Support\Properties\Strings\IbanTrait`</small> |

#### Icao

| Type | Description | Namespaces |
|------|-------------|------------|
| <small>`string`</small> | International Civil Aviation Organization code | <small>`Aedart\Contracts\Support\Properties\Strings\IcaoAware` <br> `Aedart\Support\Properties\Strings\IcaoTrait`</small> |

#### Id

| Type | Description | Namespaces |
|------|-------------|------------|
| <small>`string`</small> | Unique identifier | <small>`Aedart\Contracts\Support\Properties\Strings\IdAware` <br> `Aedart\Support\Properties\Strings\IdTrait`</small> |
| <small>`int`</small> | Unique identifier | <small>`Aedart\Contracts\Support\Properties\Integers\IdAware` <br> `Aedart\Support\Properties\Integers\IdTrait`</small> |

#### Identifier

| Type | Description | Namespaces |
|------|-------------|------------|
| <small>`string`</small> | Name or code that identifies a unique object, resource, class, component or thing | <small>`Aedart\Contracts\Support\Properties\Strings\IdentifierAware` <br> `Aedart\Support\Properties\Strings\IdentifierTrait`</small> |
| <small>`int`</small> | Name or code that identifies a unique object, resource, class, component or thing | <small>`Aedart\Contracts\Support\Properties\Integers\IdentifierAware` <br> `Aedart\Support\Properties\Integers\IdentifierTrait`</small> |

#### Image

| Type | Description | Namespaces |
|------|-------------|------------|
| <small>`string`</small> | Path, Uri or other type of location to an image | <small>`Aedart\Contracts\Support\Properties\Strings\ImageAware` <br> `Aedart\Support\Properties\Strings\ImageTrait`</small> |

#### Index

| Type | Description | Namespaces |
|------|-------------|------------|
| <small>`string`</small> | Index | <small>`Aedart\Contracts\Support\Properties\Strings\IndexAware` <br> `Aedart\Support\Properties\Strings\IndexTrait`</small> |
| <small>`int`</small> | Index | <small>`Aedart\Contracts\Support\Properties\Integers\IndexAware` <br> `Aedart\Support\Properties\Integers\IndexTrait`</small> |

#### InvoiceAddress

| Type | Description | Namespaces |
|------|-------------|------------|
| <small>`string`</small> | Invoice Address. Can be formatted. | <small>`Aedart\Contracts\Support\Properties\Strings\InvoiceAddressAware` <br> `Aedart\Support\Properties\Strings\InvoiceAddressTrait`</small> |

#### Ip

| Type | Description | Namespaces |
|------|-------------|------------|
| <small>`string`</small> | IP address | <small>`Aedart\Contracts\Support\Properties\Strings\IpAware` <br> `Aedart\Support\Properties\Strings\IpTrait`</small> |

#### IpV4

| Type | Description | Namespaces |
|------|-------------|------------|
| <small>`string`</small> | IPv4 address | <small>`Aedart\Contracts\Support\Properties\Strings\IpV4Aware` <br> `Aedart\Support\Properties\Strings\IpV4Trait`</small> |

#### IpV6

| Type | Description | Namespaces |
|------|-------------|------------|
| <small>`string`</small> | IPv6 address | <small>`Aedart\Contracts\Support\Properties\Strings\IpV6Aware` <br> `Aedart\Support\Properties\Strings\IpV6Trait`</small> |

#### IsicV4

| Type | Description | Namespaces |
|------|-------------|------------|
| <small>`string`</small> | International Standard of Industrial Classification of All Economic Activities (ISIC), revision 4 code | <small>`Aedart\Contracts\Support\Properties\Strings\IsicV4Aware` <br> `Aedart\Support\Properties\Strings\IsicV4Trait`</small> |

#### Isbn

| Type | Description | Namespaces |
|------|-------------|------------|
| <small>`string`</small> | International Standard Book Number (ISBN) | <small>`Aedart\Contracts\Support\Properties\Strings\IsbnAware` <br> `Aedart\Support\Properties\Strings\IsbnTrait`</small> |

#### Isbn10

| Type | Description | Namespaces |
|------|-------------|------------|
| <small>`string`</small> | International Standard Book Number (ISBN), 10-digits | <small>`Aedart\Contracts\Support\Properties\Strings\Isbn10Aware` <br> `Aedart\Support\Properties\Strings\Isbn10Trait`</small> |

#### Isbn13

| Type | Description | Namespaces |
|------|-------------|------------|
| <small>`string`</small> | International Standard Book Number (ISBN), 13-digits | <small>`Aedart\Contracts\Support\Properties\Strings\Isbn13Aware` <br> `Aedart\Support\Properties\Strings\Isbn13Trait`</small> |



### J

#### Json

| Type | Description | Namespaces |
|------|-------------|------------|
| <small>`string`</small> | JavaScript Object Notation (JSON) | <small>`Aedart\Contracts\Support\Properties\Strings\JsonAware` <br> `Aedart\Support\Properties\Strings\JsonTrait`</small> |



### K

#### Key

| Type | Description | Namespaces |
|------|-------------|------------|
| <small>`string`</small> | Key, e.g. indexing key, encryption key or other type of key | <small>`Aedart\Contracts\Support\Properties\Strings\KeyAware` <br> `Aedart\Support\Properties\Strings\KeyTrait`</small> |

#### Kind

| Type | Description | Namespaces |
|------|-------------|------------|
| <small>`string`</small> | The kind of object this represents, e.g. human, organisation, group, individual...etc | <small>`Aedart\Contracts\Support\Properties\Strings\KindAware` <br> `Aedart\Support\Properties\Strings\KindTrait`</small> |



### L

#### Label

| Type | Description | Namespaces |
|------|-------------|------------|
| <small>`string`</small> | Label name | <small>`Aedart\Contracts\Support\Properties\Strings\LabelAware` <br> `Aedart\Support\Properties\Strings\LabelTrait`</small> |

#### Language

| Type | Description | Namespaces |
|------|-------------|------------|
| <small>`string`</small> | Name or identifier of a language | <small>`Aedart\Contracts\Support\Properties\Strings\LanguageAware` <br> `Aedart\Support\Properties\Strings\LanguageTrait`</small> |

#### LastName

| Type | Description | Namespaces |
|------|-------------|------------|
| <small>`string`</small> | Last Name (surname) or family name of a person | <small>`Aedart\Contracts\Support\Properties\Strings\LastNameAware` <br> `Aedart\Support\Properties\Strings\LastNameTrait`</small> |

#### Latitude

| Type | Description | Namespaces |
|------|-------------|------------|
| <small>`string`</small> | North-South position on Earth&#039;s surface | <small>`Aedart\Contracts\Support\Properties\Strings\LatitudeAware` <br> `Aedart\Support\Properties\Strings\LatitudeTrait`</small> |
| <small>`float`</small> | North-South position on Earth&#039;s surface | <small>`Aedart\Contracts\Support\Properties\Floats\LatitudeAware` <br> `Aedart\Support\Properties\Floats\LatitudeTrait`</small> |

#### Length

| Type | Description | Namespaces |
|------|-------------|------------|
| <small>`int`</small> | Length of something | <small>`Aedart\Contracts\Support\Properties\Integers\LengthAware` <br> `Aedart\Support\Properties\Integers\LengthTrait`</small> |
| <small>`float`</small> | Length of something | <small>`Aedart\Contracts\Support\Properties\Floats\LengthAware` <br> `Aedart\Support\Properties\Floats\LengthTrait`</small> |

#### License

| Type | Description | Namespaces |
|------|-------------|------------|
| <small>`string`</small> | License name or identifier | <small>`Aedart\Contracts\Support\Properties\Strings\LicenseAware` <br> `Aedart\Support\Properties\Strings\LicenseTrait`</small> |
| <small>`int`</small> | License name or identifier | <small>`Aedart\Contracts\Support\Properties\Integers\LicenseAware` <br> `Aedart\Support\Properties\Integers\LicenseTrait`</small> |

#### Locale

| Type | Description | Namespaces |
|------|-------------|------------|
| <small>`string`</small> | Locale language code, e.g. en_us or other format | <small>`Aedart\Contracts\Support\Properties\Strings\LocaleAware` <br> `Aedart\Support\Properties\Strings\LocaleTrait`</small> |

#### Location

| Type | Description | Namespaces |
|------|-------------|------------|
| <small>`string`</small> | Name or identifier of a location | <small>`Aedart\Contracts\Support\Properties\Strings\LocationAware` <br> `Aedart\Support\Properties\Strings\LocationTrait`</small> |
| <small>`int`</small> | Name or identifier of a location | <small>`Aedart\Contracts\Support\Properties\Integers\LocationAware` <br> `Aedart\Support\Properties\Integers\LocationTrait`</small> |

#### Locations

| Type | Description | Namespaces |
|------|-------------|------------|
| <small>`array`</small> | List of locations | <small>`Aedart\Contracts\Support\Properties\Arrays\LocationsAware` <br> `Aedart\Support\Properties\Arrays\LocationsTrait`</small> |

#### Logo

| Type | Description | Namespaces |
|------|-------------|------------|
| <small>`string`</small> | Path, Uri or other type of location to a logo | <small>`Aedart\Contracts\Support\Properties\Strings\LogoAware` <br> `Aedart\Support\Properties\Strings\LogoTrait`</small> |

#### Longitude

| Type | Description | Namespaces |
|------|-------------|------------|
| <small>`string`</small> | East-West position on Earth&#039;s surface | <small>`Aedart\Contracts\Support\Properties\Strings\LongitudeAware` <br> `Aedart\Support\Properties\Strings\LongitudeTrait`</small> |
| <small>`float`</small> | East-West position on Earth&#039;s surface | <small>`Aedart\Contracts\Support\Properties\Floats\LongitudeAware` <br> `Aedart\Support\Properties\Floats\LongitudeTrait`</small> |



### M

#### MacAddress

| Type | Description | Namespaces |
|------|-------------|------------|
| <small>`string`</small> | Media Access Control Address (MAC Address) | <small>`Aedart\Contracts\Support\Properties\Strings\MacAddressAware` <br> `Aedart\Support\Properties\Strings\MacAddressTrait`</small> |

#### Manufacturer

| Type | Description | Namespaces |
|------|-------------|------------|
| <small>`string`</small> | Name or identifier of a manufacturer | <small>`Aedart\Contracts\Support\Properties\Strings\ManufacturerAware` <br> `Aedart\Support\Properties\Strings\ManufacturerTrait`</small> |

#### Material

| Type | Description | Namespaces |
|------|-------------|------------|
| <small>`string`</small> | Name or identifier of a material, e.g. leather, wool, cotton, paper. | <small>`Aedart\Contracts\Support\Properties\Strings\MaterialAware` <br> `Aedart\Support\Properties\Strings\MaterialTrait`</small> |

#### MediaType

| Type | Description | Namespaces |
|------|-------------|------------|
| <small>`string`</small> | Media Type (also known as MIME Type), acc. to IANA standard, or perhaps a type name | <small>`Aedart\Contracts\Support\Properties\Strings\MediaTypeAware` <br> `Aedart\Support\Properties\Strings\MediaTypeTrait`</small> |

#### Message

| Type | Description | Namespaces |
|------|-------------|------------|
| <small>`string`</small> | A message | <small>`Aedart\Contracts\Support\Properties\Strings\MessageAware` <br> `Aedart\Support\Properties\Strings\MessageTrait`</small> |

#### Method

| Type | Description | Namespaces |
|------|-------------|------------|
| <small>`string`</small> | Name of method or other identifier | <small>`Aedart\Contracts\Support\Properties\Strings\MethodAware` <br> `Aedart\Support\Properties\Strings\MethodTrait`</small> |
| <small>`int`</small> | Name of method or other identifier | <small>`Aedart\Contracts\Support\Properties\Integers\MethodAware` <br> `Aedart\Support\Properties\Integers\MethodTrait`</small> |

#### MiddleName

| Type | Description | Namespaces |
|------|-------------|------------|
| <small>`string`</small> | Middle Name or names of a person | <small>`Aedart\Contracts\Support\Properties\Strings\MiddleNameAware` <br> `Aedart\Support\Properties\Strings\MiddleNameTrait`</small> |



### N

#### Name

| Type | Description | Namespaces |
|------|-------------|------------|
| <small>`string`</small> | Name | <small>`Aedart\Contracts\Support\Properties\Strings\NameAware` <br> `Aedart\Support\Properties\Strings\NameTrait`</small> |

#### NickName

| Type | Description | Namespaces |
|------|-------------|------------|
| <small>`string`</small> | Nickname of someone or something | <small>`Aedart\Contracts\Support\Properties\Strings\NickNameAware` <br> `Aedart\Support\Properties\Strings\NickNameTrait`</small> |



### O

#### OrderNumber

| Type | Description | Namespaces |
|------|-------------|------------|
| <small>`string`</small> | Number that represents a purchase or order placed by a customer | <small>`Aedart\Contracts\Support\Properties\Strings\OrderNumberAware` <br> `Aedart\Support\Properties\Strings\OrderNumberTrait`</small> |
| <small>`int`</small> | Number that represents a purchase or order placed by a customer | <small>`Aedart\Contracts\Support\Properties\Integers\OrderNumberAware` <br> `Aedart\Support\Properties\Integers\OrderNumberTrait`</small> |

#### Organisation

| Type | Description | Namespaces |
|------|-------------|------------|
| <small>`string`</small> | Name of organisation | <small>`Aedart\Contracts\Support\Properties\Strings\OrganisationAware` <br> `Aedart\Support\Properties\Strings\OrganisationTrait`</small> |

#### OutputPath

| Type | Description | Namespaces |
|------|-------------|------------|
| <small>`string`</small> | Location of where some kind of output must be placed or written to | <small>`Aedart\Contracts\Support\Properties\Strings\OutputPathAware` <br> `Aedart\Support\Properties\Strings\OutputPathTrait`</small> |



### P

#### Package

| Type | Description | Namespaces |
|------|-------------|------------|
| <small>`string`</small> | Name of package. Can evt. contain path to package as well | <small>`Aedart\Contracts\Support\Properties\Strings\PackageAware` <br> `Aedart\Support\Properties\Strings\PackageTrait`</small> |

#### Password

| Type | Description | Namespaces |
|------|-------------|------------|
| <small>`string`</small> | Password | <small>`Aedart\Contracts\Support\Properties\Strings\PasswordAware` <br> `Aedart\Support\Properties\Strings\PasswordTrait`</small> |

#### Path

| Type | Description | Namespaces |
|------|-------------|------------|
| <small>`string`</small> | Location of some kind of a resources, e.g. a file, an Url, an index | <small>`Aedart\Contracts\Support\Properties\Strings\PathAware` <br> `Aedart\Support\Properties\Strings\PathTrait`</small> |

#### Pattern

| Type | Description | Namespaces |
|------|-------------|------------|
| <small>`string`</small> | Some kind of a pattern, e.g. search or regex | <small>`Aedart\Contracts\Support\Properties\Strings\PatternAware` <br> `Aedart\Support\Properties\Strings\PatternTrait`</small> |

#### Phone

| Type | Description | Namespaces |
|------|-------------|------------|
| <small>`string`</small> | Phone number | <small>`Aedart\Contracts\Support\Properties\Strings\PhoneAware` <br> `Aedart\Support\Properties\Strings\PhoneTrait`</small> |

#### Photo

| Type | Description | Namespaces |
|------|-------------|------------|
| <small>`string`</small> | Path, Uri or other type of location to a photo | <small>`Aedart\Contracts\Support\Properties\Strings\PhotoAware` <br> `Aedart\Support\Properties\Strings\PhotoTrait`</small> |

#### PostalCode

| Type | Description | Namespaces |
|------|-------------|------------|
| <small>`string`</small> | Numeric or Alphanumeric postal code (zip code) | <small>`Aedart\Contracts\Support\Properties\Strings\PostalCodeAware` <br> `Aedart\Support\Properties\Strings\PostalCodeTrait`</small> |

#### Prefix

| Type | Description | Namespaces |
|------|-------------|------------|
| <small>`string`</small> | Prefix | <small>`Aedart\Contracts\Support\Properties\Strings\PrefixAware` <br> `Aedart\Support\Properties\Strings\PrefixTrait`</small> |

#### Price

| Type | Description | Namespaces |
|------|-------------|------------|
| <small>`string`</small> | Numeric price | <small>`Aedart\Contracts\Support\Properties\Strings\PriceAware` <br> `Aedart\Support\Properties\Strings\PriceTrait`</small> |
| <small>`int`</small> | Numeric price | <small>`Aedart\Contracts\Support\Properties\Integers\PriceAware` <br> `Aedart\Support\Properties\Integers\PriceTrait`</small> |
| <small>`float`</small> | Numeric price | <small>`Aedart\Contracts\Support\Properties\Floats\PriceAware` <br> `Aedart\Support\Properties\Floats\PriceTrait`</small> |

#### Profile

| Type | Description | Namespaces |
|------|-------------|------------|
| <small>`string`</small> | The profile or someone or something | <small>`Aedart\Contracts\Support\Properties\Strings\ProfileAware` <br> `Aedart\Support\Properties\Strings\ProfileTrait`</small> |

#### ProducedAt

| Type | Description | Namespaces |
|------|-------------|------------|
| <small>`string`</small> | Date of when this component, entity or something was produced | <small>`Aedart\Contracts\Support\Properties\Strings\ProducedAtAware` <br> `Aedart\Support\Properties\Strings\ProducedAtTrait`</small> |
| <small>`int`</small> | Date of when this component, entity or something was produced | <small>`Aedart\Contracts\Support\Properties\Integers\ProducedAtAware` <br> `Aedart\Support\Properties\Integers\ProducedAtTrait`</small> |

#### ProductionDate

| Type | Description | Namespaces |
|------|-------------|------------|
| <small>`string`</small> | Date of planned production | <small>`Aedart\Contracts\Support\Properties\Strings\ProductionDateAware` <br> `Aedart\Support\Properties\Strings\ProductionDateTrait`</small> |
| <small>`int`</small> | Date of planned production | <small>`Aedart\Contracts\Support\Properties\Integers\ProductionDateAware` <br> `Aedart\Support\Properties\Integers\ProductionDateTrait`</small> |

#### PurchaseDate

| Type | Description | Namespaces |
|------|-------------|------------|
| <small>`string`</small> | Date of planned purchase | <small>`Aedart\Contracts\Support\Properties\Strings\PurchaseDateAware` <br> `Aedart\Support\Properties\Strings\PurchaseDateTrait`</small> |
| <small>`int`</small> | Date of planned purchase | <small>`Aedart\Contracts\Support\Properties\Integers\PurchaseDateAware` <br> `Aedart\Support\Properties\Integers\PurchaseDateTrait`</small> |

#### PurchasedAt

| Type | Description | Namespaces |
|------|-------------|------------|
| <small>`string`</small> | Date of when this component, entity or resource was purchased | <small>`Aedart\Contracts\Support\Properties\Strings\PurchasedAtAware` <br> `Aedart\Support\Properties\Strings\PurchasedAtTrait`</small> |
| <small>`int`</small> | Date of when this component, entity or resource was purchased | <small>`Aedart\Contracts\Support\Properties\Integers\PurchasedAtAware` <br> `Aedart\Support\Properties\Integers\PurchasedAtTrait`</small> |



### Q

#### Quantity

| Type | Description | Namespaces |
|------|-------------|------------|
| <small>`int`</small> | The quantity of something | <small>`Aedart\Contracts\Support\Properties\Integers\QuantityAware` <br> `Aedart\Support\Properties\Integers\QuantityTrait`</small> |
| <small>`float`</small> | The quantity of something | <small>`Aedart\Contracts\Support\Properties\Floats\QuantityAware` <br> `Aedart\Support\Properties\Floats\QuantityTrait`</small> |

#### Query

| Type | Description | Namespaces |
|------|-------------|------------|
| <small>`string`</small> | Query | <small>`Aedart\Contracts\Support\Properties\Strings\QueryAware` <br> `Aedart\Support\Properties\Strings\QueryTrait`</small> |

#### Question

| Type | Description | Namespaces |
|------|-------------|------------|
| <small>`string`</small> | A question that can be asked | <small>`Aedart\Contracts\Support\Properties\Strings\QuestionAware` <br> `Aedart\Support\Properties\Strings\QuestionTrait`</small> |



### R

#### Rank

| Type | Description | Namespaces |
|------|-------------|------------|
| <small>`string`</small> | The position in a hierarchy | <small>`Aedart\Contracts\Support\Properties\Strings\RankAware` <br> `Aedart\Support\Properties\Strings\RankTrait`</small> |
| <small>`int`</small> | The position in a hierarchy | <small>`Aedart\Contracts\Support\Properties\Integers\RankAware` <br> `Aedart\Support\Properties\Integers\RankTrait`</small> |
| <small>`float`</small> | The position in a hierarchy | <small>`Aedart\Contracts\Support\Properties\Floats\RankAware` <br> `Aedart\Support\Properties\Floats\RankTrait`</small> |

#### Rate

| Type | Description | Namespaces |
|------|-------------|------------|
| <small>`string`</small> | The rate of something, e.g. growth rate, tax rate | <small>`Aedart\Contracts\Support\Properties\Strings\RateAware` <br> `Aedart\Support\Properties\Strings\RateTrait`</small> |
| <small>`int`</small> | The rate of something, e.g. growth rate, tax rate | <small>`Aedart\Contracts\Support\Properties\Integers\RateAware` <br> `Aedart\Support\Properties\Integers\RateTrait`</small> |
| <small>`float`</small> | The rate of something, e.g. growth rate, tax rate | <small>`Aedart\Contracts\Support\Properties\Floats\RateAware` <br> `Aedart\Support\Properties\Floats\RateTrait`</small> |

#### Rating

| Type | Description | Namespaces |
|------|-------------|------------|
| <small>`string`</small> | The rating of something | <small>`Aedart\Contracts\Support\Properties\Strings\RatingAware` <br> `Aedart\Support\Properties\Strings\RatingTrait`</small> |
| <small>`int`</small> | The rating of something | <small>`Aedart\Contracts\Support\Properties\Integers\RatingAware` <br> `Aedart\Support\Properties\Integers\RatingTrait`</small> |
| <small>`float`</small> | The rating of something | <small>`Aedart\Contracts\Support\Properties\Floats\RatingAware` <br> `Aedart\Support\Properties\Floats\RatingTrait`</small> |

#### ReleasedAt

| Type | Description | Namespaces |
|------|-------------|------------|
| <small>`string`</small> | Date of when this component, entity or something was released | <small>`Aedart\Contracts\Support\Properties\Strings\ReleasedAtAware` <br> `Aedart\Support\Properties\Strings\ReleasedAtTrait`</small> |
| <small>`int`</small> | Date of when this component, entity or something was released | <small>`Aedart\Contracts\Support\Properties\Integers\ReleasedAtAware` <br> `Aedart\Support\Properties\Integers\ReleasedAtTrait`</small> |

#### ReleaseDate

| Type | Description | Namespaces |
|------|-------------|------------|
| <small>`string`</small> | Date of planned release | <small>`Aedart\Contracts\Support\Properties\Strings\ReleaseDateAware` <br> `Aedart\Support\Properties\Strings\ReleaseDateTrait`</small> |
| <small>`int`</small> | Date of planned release | <small>`Aedart\Contracts\Support\Properties\Integers\ReleaseDateAware` <br> `Aedart\Support\Properties\Integers\ReleaseDateTrait`</small> |

#### Row

| Type | Description | Namespaces |
|------|-------------|------------|
| <small>`int`</small> | A row identifier | <small>`Aedart\Contracts\Support\Properties\Integers\RowAware` <br> `Aedart\Support\Properties\Integers\RowTrait`</small> |

#### Region

| Type | Description | Namespaces |
|------|-------------|------------|
| <small>`string`</small> | Name of a region, state or province | <small>`Aedart\Contracts\Support\Properties\Strings\RegionAware` <br> `Aedart\Support\Properties\Strings\RegionTrait`</small> |

#### Revision

| Type | Description | Namespaces |
|------|-------------|------------|
| <small>`string`</small> | A revision, batch number or other identifier | <small>`Aedart\Contracts\Support\Properties\Strings\RevisionAware` <br> `Aedart\Support\Properties\Strings\RevisionTrait`</small> |

#### Role

| Type | Description | Namespaces |
|------|-------------|------------|
| <small>`string`</small> | Name or identifier of role | <small>`Aedart\Contracts\Support\Properties\Strings\RoleAware` <br> `Aedart\Support\Properties\Strings\RoleTrait`</small> |



### S

#### Size

| Type | Description | Namespaces |
|------|-------------|------------|
| <small>`string`</small> | The size of something | <small>`Aedart\Contracts\Support\Properties\Strings\SizeAware` <br> `Aedart\Support\Properties\Strings\SizeTrait`</small> |
| <small>`int`</small> | The size of something | <small>`Aedart\Contracts\Support\Properties\Integers\SizeAware` <br> `Aedart\Support\Properties\Integers\SizeTrait`</small> |
| <small>`float`</small> | The size of something | <small>`Aedart\Contracts\Support\Properties\Floats\SizeAware` <br> `Aedart\Support\Properties\Floats\SizeTrait`</small> |

#### Script

| Type | Description | Namespaces |
|------|-------------|------------|
| <small>`string`</small> | Script of some kind or path to some script | <small>`Aedart\Contracts\Support\Properties\Strings\ScriptAware` <br> `Aedart\Support\Properties\Strings\ScriptTrait`</small> |

#### Slug

| Type | Description | Namespaces |
|------|-------------|------------|
| <small>`string`</small> | Human readable keyword(s) that can be part or a Url | <small>`Aedart\Contracts\Support\Properties\Strings\SlugAware` <br> `Aedart\Support\Properties\Strings\SlugTrait`</small> |

#### Source

| Type | Description | Namespaces |
|------|-------------|------------|
| <small>`string`</small> | The source of something. E.g. location, reference, index key, or other identifier that can be used to determine the source | <small>`Aedart\Contracts\Support\Properties\Strings\SourceAware` <br> `Aedart\Support\Properties\Strings\SourceTrait`</small> |

#### Sql

| Type | Description | Namespaces |
|------|-------------|------------|
| <small>`string`</small> | A Structured Query Language (SQL) query | <small>`Aedart\Contracts\Support\Properties\Strings\SqlAware` <br> `Aedart\Support\Properties\Strings\SqlTrait`</small> |

#### StartDate

| Type | Description | Namespaces |
|------|-------------|------------|
| <small>`string`</small> | Start date of event | <small>`Aedart\Contracts\Support\Properties\Strings\StartDateAware` <br> `Aedart\Support\Properties\Strings\StartDateTrait`</small> |
| <small>`int`</small> | Start date of event | <small>`Aedart\Contracts\Support\Properties\Integers\StartDateAware` <br> `Aedart\Support\Properties\Integers\StartDateTrait`</small> |

#### State

| Type | Description | Namespaces |
|------|-------------|------------|
| <small>`string`</small> | State of this component or what it represents. Alternative, state address | <small>`Aedart\Contracts\Support\Properties\Strings\StateAware` <br> `Aedart\Support\Properties\Strings\StateTrait`</small> |
| <small>`int`</small> | State of this component or what it represents | <small>`Aedart\Contracts\Support\Properties\Integers\StateAware` <br> `Aedart\Support\Properties\Integers\StateTrait`</small> |

#### Status

| Type | Description | Namespaces |
|------|-------------|------------|
| <small>`string`</small> | Situation of progress, classification, or civil status | <small>`Aedart\Contracts\Support\Properties\Strings\StatusAware` <br> `Aedart\Support\Properties\Strings\StatusTrait`</small> |
| <small>`int`</small> | Situation of progress, classification, or civil status | <small>`Aedart\Contracts\Support\Properties\Integers\StatusAware` <br> `Aedart\Support\Properties\Integers\StatusTrait`</small> |

#### Street

| Type | Description | Namespaces |
|------|-------------|------------|
| <small>`string`</small> | Full street address, which might include building or apartment number(s) | <small>`Aedart\Contracts\Support\Properties\Strings\StreetAware` <br> `Aedart\Support\Properties\Strings\StreetTrait`</small> |

#### Suffix

| Type | Description | Namespaces |
|------|-------------|------------|
| <small>`string`</small> | Suffix | <small>`Aedart\Contracts\Support\Properties\Strings\SuffixAware` <br> `Aedart\Support\Properties\Strings\SuffixTrait`</small> |

#### Swift

| Type | Description | Namespaces |
|------|-------------|------------|
| <small>`string`</small> | ISO-9362 Swift Code | <small>`Aedart\Contracts\Support\Properties\Strings\SwiftAware` <br> `Aedart\Support\Properties\Strings\SwiftTrait`</small> |



### T

#### Table

| Type | Description | Namespaces |
|------|-------------|------------|
| <small>`string`</small> | Name of table | <small>`Aedart\Contracts\Support\Properties\Strings\TableAware` <br> `Aedart\Support\Properties\Strings\TableTrait`</small> |

#### Tag

| Type | Description | Namespaces |
|------|-------------|------------|
| <small>`string`</small> | Name of tag | <small>`Aedart\Contracts\Support\Properties\Strings\TagAware` <br> `Aedart\Support\Properties\Strings\TagTrait`</small> |

#### Tags

| Type | Description | Namespaces |
|------|-------------|------------|
| <small>`array`</small> | List of tags | <small>`Aedart\Contracts\Support\Properties\Arrays\TagsAware` <br> `Aedart\Support\Properties\Arrays\TagsTrait`</small> |

#### Template

| Type | Description | Namespaces |
|------|-------------|------------|
| <small>`string`</small> | Template or location of a template file | <small>`Aedart\Contracts\Support\Properties\Strings\TemplateAware` <br> `Aedart\Support\Properties\Strings\TemplateTrait`</small> |

#### Text

| Type | Description | Namespaces |
|------|-------------|------------|
| <small>`string`</small> | The full text content for something, e.g. an article&#039;s body text | <small>`Aedart\Contracts\Support\Properties\Strings\TextAware` <br> `Aedart\Support\Properties\Strings\TextTrait`</small> |

#### Timeout

| Type | Description | Namespaces |
|------|-------------|------------|
| <small>`int`</small> | Timeout amount | <small>`Aedart\Contracts\Support\Properties\Integers\TimeoutAware` <br> `Aedart\Support\Properties\Integers\TimeoutTrait`</small> |

#### Timestamp

| Type | Description | Namespaces |
|------|-------------|------------|
| <small>`int`</small> | Unix timestamp | <small>`Aedart\Contracts\Support\Properties\Integers\TimestampAware` <br> `Aedart\Support\Properties\Integers\TimestampTrait`</small> |

#### Timezone

| Type | Description | Namespaces |
|------|-------------|------------|
| <small>`string`</small> | Name of timezone | <small>`Aedart\Contracts\Support\Properties\Strings\TimezoneAware` <br> `Aedart\Support\Properties\Strings\TimezoneTrait`</small> |

#### Title

| Type | Description | Namespaces |
|------|-------------|------------|
| <small>`string`</small> | Title | <small>`Aedart\Contracts\Support\Properties\Strings\TitleAware` <br> `Aedart\Support\Properties\Strings\TitleTrait`</small> |

#### Tld

| Type | Description | Namespaces |
|------|-------------|------------|
| <small>`string`</small> | Top Level Domain (TLD) | <small>`Aedart\Contracts\Support\Properties\Strings\TldAware` <br> `Aedart\Support\Properties\Strings\TldTrait`</small> |

#### Topic

| Type | Description | Namespaces |
|------|-------------|------------|
| <small>`string`</small> | Name of topic | <small>`Aedart\Contracts\Support\Properties\Strings\TopicAware` <br> `Aedart\Support\Properties\Strings\TopicTrait`</small> |

#### Type

| Type | Description | Namespaces |
|------|-------------|------------|
| <small>`string`</small> | Type identifier | <small>`Aedart\Contracts\Support\Properties\Strings\TypeAware` <br> `Aedart\Support\Properties\Strings\TypeTrait`</small> |
| <small>`int`</small> | Type identifier | <small>`Aedart\Contracts\Support\Properties\Integers\TypeAware` <br> `Aedart\Support\Properties\Integers\TypeTrait`</small> |



### U

#### UpdatedAt

| Type | Description | Namespaces |
|------|-------------|------------|
| <small>`string`</small> | Date of when this component, entity or resource was updated | <small>`Aedart\Contracts\Support\Properties\Strings\UpdatedAtAware` <br> `Aedart\Support\Properties\Strings\UpdatedAtTrait`</small> |
| <small>`int`</small> | Date of when this component, entity or resource was updated | <small>`Aedart\Contracts\Support\Properties\Integers\UpdatedAtAware` <br> `Aedart\Support\Properties\Integers\UpdatedAtTrait`</small> |

#### Url

| Type | Description | Namespaces |
|------|-------------|------------|
| <small>`string`</small> | Uniform Resource Locator (Url), commonly known as a web address | <small>`Aedart\Contracts\Support\Properties\Strings\UrlAware` <br> `Aedart\Support\Properties\Strings\UrlTrait`</small> |

#### Username

| Type | Description | Namespaces |
|------|-------------|------------|
| <small>`string`</small> | Identifier to be used as username | <small>`Aedart\Contracts\Support\Properties\Strings\UsernameAware` <br> `Aedart\Support\Properties\Strings\UsernameTrait`</small> |

#### Uuid

| Type | Description | Namespaces |
|------|-------------|------------|
| <small>`string`</small> | Universally Unique Identifier (UUID) | <small>`Aedart\Contracts\Support\Properties\Strings\UuidAware` <br> `Aedart\Support\Properties\Strings\UuidTrait`</small> |



### V

#### Value

| Type | Description | Namespaces |
|------|-------------|------------|
| <small>`string`</small> | Value | <small>`Aedart\Contracts\Support\Properties\Strings\ValueAware` <br> `Aedart\Support\Properties\Strings\ValueTrait`</small> |

#### Vat

| Type | Description | Namespaces |
|------|-------------|------------|
| <small>`string`</small> | Value Added Tac (VAT), formatted amount or rate | <small>`Aedart\Contracts\Support\Properties\Strings\VatAware` <br> `Aedart\Support\Properties\Strings\VatTrait`</small> |
| <small>`int`</small> | Value Added Tac (VAT), formatted amount or rate | <small>`Aedart\Contracts\Support\Properties\Integers\VatAware` <br> `Aedart\Support\Properties\Integers\VatTrait`</small> |
| <small>`float`</small> | Value Added Tac (VAT), formatted amount or rate | <small>`Aedart\Contracts\Support\Properties\Floats\VatAware` <br> `Aedart\Support\Properties\Floats\VatTrait`</small> |

#### Vendor

| Type | Description | Namespaces |
|------|-------------|------------|
| <small>`string`</small> | Name or path of a vendor | <small>`Aedart\Contracts\Support\Properties\Strings\VendorAware` <br> `Aedart\Support\Properties\Strings\VendorTrait`</small> |

#### Version

| Type | Description | Namespaces |
|------|-------------|------------|
| <small>`string`</small> | Version | <small>`Aedart\Contracts\Support\Properties\Strings\VersionAware` <br> `Aedart\Support\Properties\Strings\VersionTrait`</small> |



### W

#### Weight

| Type | Description | Namespaces |
|------|-------------|------------|
| <small>`int`</small> | Weight of something | <small>`Aedart\Contracts\Support\Properties\Integers\WeightAware` <br> `Aedart\Support\Properties\Integers\WeightTrait`</small> |
| <small>`float`</small> | Weight of something | <small>`Aedart\Contracts\Support\Properties\Floats\WeightAware` <br> `Aedart\Support\Properties\Floats\WeightTrait`</small> |

#### Width

| Type | Description | Namespaces |
|------|-------------|------------|
| <small>`int`</small> | Width of something | <small>`Aedart\Contracts\Support\Properties\Integers\WidthAware` <br> `Aedart\Support\Properties\Integers\WidthTrait`</small> |
| <small>`float`</small> | Width of something | <small>`Aedart\Contracts\Support\Properties\Floats\WidthAware` <br> `Aedart\Support\Properties\Floats\WidthTrait`</small> |

#### Wildcard

| Type | Description | Namespaces |
|------|-------------|------------|
| <small>`string`</small> | Wildcard identifier | <small>`Aedart\Contracts\Support\Properties\Strings\WildcardAware` <br> `Aedart\Support\Properties\Strings\WildcardTrait`</small> |



### X

#### X

| Type | Description | Namespaces |
|------|-------------|------------|
| <small>`int`</small> | Co-ordinate or value | <small>`Aedart\Contracts\Support\Properties\Integers\XAware` <br> `Aedart\Support\Properties\Integers\XTrait`</small> |
| <small>`float`</small> | Co-ordinate or value | <small>`Aedart\Contracts\Support\Properties\Floats\XAware` <br> `Aedart\Support\Properties\Floats\XTrait`</small> |

#### Xml

| Type | Description | Namespaces |
|------|-------------|------------|
| <small>`string`</small> | Extensible Markup Language (XML) | <small>`Aedart\Contracts\Support\Properties\Strings\XmlAware` <br> `Aedart\Support\Properties\Strings\XmlTrait`</small> |



### Y

#### Y

| Type | Description | Namespaces |
|------|-------------|------------|
| <small>`int`</small> | Co-ordinate or value | <small>`Aedart\Contracts\Support\Properties\Integers\YAware` <br> `Aedart\Support\Properties\Integers\YTrait`</small> |
| <small>`float`</small> | Co-ordinate or value | <small>`Aedart\Contracts\Support\Properties\Floats\YAware` <br> `Aedart\Support\Properties\Floats\YTrait`</small> |



### Z

#### Z

| Type | Description | Namespaces |
|------|-------------|------------|
| <small>`int`</small> | Co-ordinate or value | <small>`Aedart\Contracts\Support\Properties\Integers\ZAware` <br> `Aedart\Support\Properties\Integers\ZTrait`</small> |
| <small>`float`</small> | Co-ordinate or value | <small>`Aedart\Contracts\Support\Properties\Floats\ZAware` <br> `Aedart\Support\Properties\Floats\ZTrait`</small> |

#### Zone

| Type | Description | Namespaces |
|------|-------------|------------|
| <small>`string`</small> | Name or identifier of area, district or division | <small>`Aedart\Contracts\Support\Properties\Strings\ZoneAware` <br> `Aedart\Support\Properties\Strings\ZoneTrait`</small> |
| <small>`int`</small> | Name or identifier of area, district or division | <small>`Aedart\Contracts\Support\Properties\Integers\ZoneAware` <br> `Aedart\Support\Properties\Integers\ZoneTrait`</small> |



