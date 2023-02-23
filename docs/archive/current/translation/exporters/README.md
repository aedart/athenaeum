---
description: About the Translations Exporter
sidebarDepth: 0
---

# Introduction

When you need to export your application's available translations, you can use the `Exporter` component.
It offers a "profile-based" approach, in which you can have multiple [exporter profiles](./setup.md#configuration). 

## Example

```php
use Aedart\Translation\Traits\TranslationsExporterManagerTrait;

class MyController
{
    use TranslationsExporterManagerTrait;
    
    public function index()
    {
        $exporter = $this->getTranslationsExporterManager()
            ->profile();
            
        $translations = $exporter->export(['en', 'en-uk']);
        
        // ...do something with the translations... 
    }
}
```