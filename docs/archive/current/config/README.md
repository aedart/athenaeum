---
description: About the Configuration Package
---
# Configuration Loader

The `Loader` component is able to load various types of configuration files and parse them into a Laravel [Repository](https://github.com/laravel/framework/blob/11.x/src/Illuminate/Config/Repository.php).

## Supported File Types

| File Extension                                                             |
|----------------------------------------------------------------------------|
| *.ini                                                                      |
| *.json                                                                     |
| *.php (_php array_)                                                        |
| *.yml, *.yaml (_requires [symfony/yaml](https://github.com/symfony/yaml)_) |
| *.toml (_requires [devium/toml](https://github.com/vanodevium/toml)_)      |
| *.neon (_requires [nette/neon](https://github.com/nette/neon)_)            |


