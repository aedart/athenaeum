---
description: How to add Custom File Parsers
---

# Custom File Parsers

If the default supported file parsers are insufficient for your, then you can create your own.
This can be achieved by extending the `ParserBase` abstraction.

```php
<?php

namespace Acme\Config\Parsers;

use Aedart\Config\Parsers\Files\ParserBase;

class XmlParser extends ParserBase
{
    public static function getFileType(): string
    {
        return 'xml';
    }

    public function parse(string $content): array
    {
        // ... implementation not shown ...
    }
}
```

## Factory

To use your custom file parser, you must either create your own file parser factory or extend the existing `FileParserFactory`.
The following example shows how you could add your custom file parser to a custom factory, by extending the default provided file parser factory.

```php
<?php

namespace Acme\Config\Parsers;

use Aedart\Config\Parsers\Factories\FileParserFactory;
use Aedart\Contracts\Config\Parsers\FileParser;
use Acme\Config\Parsers\XmlParser;

class CustomFileParserFactory extends FileParserFactory
{
    public function make(string $type): FileParser
    {
        if($type === XmlParser::getFileType()){
            return new XmlParser();
        }   

        return parent::make($type);
    }
}
```

## Use Factory

Lastly, you need to specify what factory instance the configuration loader should use.

```php
use Acme\Config\Parsers\CustomFileParserFactory;

$loader->setParserFactory(new CustomFileParserFactory());
```