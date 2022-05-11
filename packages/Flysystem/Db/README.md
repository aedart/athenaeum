# Athenaeum Flysystem Database Adapter

A [Flysystem](https://flysystem.thephpleague.com/docs/) adapter that store files and directories in your database.

## Supported Databases

Behind the scene, [Laravel's Database package](https://packagist.org/packages/illuminate/database) is used to execute queries, which grants support for the following databases:

* MariaDB
* MySQL
* PostgreSQL
* SQLite
* SQL Server

```php
use Aedart\Flysystem\Db\Adapters\DatabaseAdapter;
use Illuminate\Database\Capsule\Manager as Capsule;
use League\Flysystem\Filesystem;

// Establish database connection
$capsule = new Capsule;
$capsule->addConnection([
    'driver' => 'mysql',
    'host' => 'localhost',
    'database' => 'database',
    'username' => 'root',
    'password' => 'password',
    'charset' => 'utf8',
    'collation' => 'utf8_unicode_ci',
    'prefix' => '',
]);

$connection = $capsule->getConnection();

// Create Database Adapter instance
$adapter = new DatabaseAdapter(
    filesTable: 'files',
    contentsTable: 'files_contents',
    connection: $connection
);

// Finally, create filesystem instance
$filesystem = new Filesystem($adapter);
```

**Note**: _If you wish to use this adapter within your Laravel Application, then you can choose register this package's Service Provider. See official documentation for more information._

## Data Deduplication

The adapter makes use of [Data Deduplication](https://en.wikipedia.org/wiki/Data_deduplication) technique, which means that files that have the exact same content are only stored once.

## Documentation

Please read the [official documentation](https://aedart.github.io/athenaeum/) for additional information.

## Repository

The mono repository is located at [github.com/aedart/athenaeum](https://github.com/aedart/athenaeum)

## Versioning

This package follows [Semantic Versioning 2.0.0](http://semver.org/)

## License

[BSD-3-Clause](http://spdx.org/licenses/BSD-3-Clause), Read the LICENSE file included in this package
