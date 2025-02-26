---
description: How to setup Flysystem Database Adapter
---

# Setup

The database adapter is written such that it can be used within a regular Laravel application, as well as outside Laravel.

[[TOC]]

## Inside Laravel Application

### Register Service Provider

Register `FlysystemDatabaseAdapterServiceProvider` inside your `config/app.php`.

```php
return [

    // ... previous not shown ... //

    /*
    |--------------------------------------------------------------------------
    | Autoloaded Service Providers
    |--------------------------------------------------------------------------
    */

    'providers' => [

        \Aedart\Flysystem\Db\Providers\FlysystemDatabaseAdapterServiceProvider::class

        // ... remaining services not shown ... //
    ],
];
```

### Create custom migration

The database adapter will require two tables to be migrated. To do so, run the following command and follow the on-screen instructions:

```console
php artisan flysystem:make-adapter-migration
```

The command will generate a new migration file, with the specified table names. Once completed, migrate your database:

```console
php artisan migrate
```

### Add storage disk "profile"

In your `config/filesystems.php`, add a new storage disk profile, which uses `database` as its driver:
The followings shows a custom disk that uses the database driver and has `my_disk` as "profile" name. 

```php
return [

    // ...previous not shown...

    /*
    |--------------------------------------------------------------------------
    | Filesystem Disks
    |--------------------------------------------------------------------------
    */

    'disks' => [

        // ...previous not shown...

        'my_disk' => [
            'driver' => 'database',
            'connection' => env('DB_CONNECTION', 'mysql'),
            'files_table' => 'files',
            'contents_table' => 'files_contents',
            'hash_algo' => 'sha256',
            'path_prefix' => '',
        ]
    ],
];
```

### Use storage disk

To use the custom disk profile, use the `disk()` method on the `Storage` facade.

```php
use Illuminate\Support\Facades\Storage;
 
Storage::disk('my_disk')->put('example.txt', 'Contents');
```

See [Laravel documentation](https://laravel.com/docs/11.x/filesystem) for additional examples on how to use custom disk profiles.

## Outside Laravel

The database adapter uses [Laravel's Database package](https://packagist.org/packages/illuminate/database) as means of performing queries.
This means that you will need to establish a connection to your database, using Laravel's connection `Manager`.
But before you do that, you will need to create appropriate table schema required by the adapter.


Choose your database driver and create the required tables. Feel free to change the table names to whatever you see fit. 

::: tip SQL Generator
The shown SQL is generated via a small binary helper in this package.

Run `./vendor/aedart/athenaeum-flysystem-db/bin/table_schemas`.
:::

### SQLite

```sql
create table "files" ("id" integer not null primary key autoincrement, "type" varchar check ("type" in ('dir', 'file')) not null, "path" varchar not null, "level" integer not null default '0', "file_size" integer not null default '0', "mime_type" varchar, "visibility" varchar check ("visibility" in ('public', 'private')) not null default 'private', "content_hash" varchar, "last_modified" integer not null default '0', "extra_metadata" text)

create index "files_path_index" on "files" ("path")

create index "files_path_level_index" on "files" ("path", "level")

create index "files_content_hash_index" on "files" ("content_hash")

create unique index "files_path_unique" on "files" ("path")

create table "file_contents" ("id" integer not null primary key autoincrement, "hash" varchar not null, "reference_count" integer not null default '0', "contents" blob not null)

create index "file_contents_hash_index" on "file_contents" ("hash")

create unique index "file_contents_hash_unique" on "file_contents" ("hash")
```

### MySQL / MariaDB

```sql
create table `files` (`id` bigint unsigned not null auto_increment primary key, `type` enum('dir', 'file') not null comment 'Whether this is a file or directory', `path` varchar(255) not null comment 'Unique path of file or directory', `level` smallint unsigned not null default '0' comment 'Depth level', `file_size` bigint not null default '0' comment 'Filesize in bytes', `mime_type` varchar(127) null comment 'File media type / mimetype', `visibility` enum('public', 'private') not null default 'private' comment 'File or directory visibility', `content_hash` varchar(128) null comment 'Hash of file content', `last_modified` bigint not null default '0' comment 'Unix timestamp of when file or directory was last modified', `extra_metadata` json null comment 'Evt. custom extra meta data about file or directory') default character set utf8mb4 collate 'utf8mb4_unicode_ci'

alter table `files` add index `files_path_index`(`path`)

alter table `files` add index `files_path_level_index`(`path`, `level`)

alter table `files` add index `files_content_hash_index`(`content_hash`)

alter table `files` add unique `files_path_unique`(`path`)

create table `file_contents` (`id` bigint unsigned not null auto_increment primary key, `hash` varchar(128) not null comment 'Hash of file content', `reference_count` int not null default '0' comment 'Amount of files that references this content', `contents` blob not null comment 'File contents') default character set utf8mb4 collate 'utf8mb4_unicode_ci'

alter table `file_contents` add index `file_contents_hash_index`(`hash`)

alter table `file_contents` add unique `file_contents_hash_unique`(`hash`)
```

### PostgreSQL

```sql
create table "files" ("id" bigserial primary key not null, "type" varchar(255) check ("type" in ('dir', 'file')) not null, "path" varchar(255) not null, "level" smallint not null default '0', "file_size" bigint not null default '0', "mime_type" varchar(127) null, "visibility" varchar(255) check ("visibility" in ('public', 'private')) not null default 'private', "content_hash" varchar(128) null, "last_modified" bigint not null default '0', "extra_metadata" json null)

create index "files_path_index" on "files" ("path")

create index "files_path_level_index" on "files" ("path", "level")

create index "files_content_hash_index" on "files" ("content_hash")

alter table "files" add constraint "files_path_unique" unique ("path")

create table "file_contents" ("id" bigserial primary key not null, "hash" varchar(128) not null, "reference_count" integer not null default '0', "contents" bytea not null)

create index "file_contents_hash_index" on "file_contents" ("hash")

alter table "file_contents" add constraint "file_contents_hash_unique" unique ("hash")
```

### SQL Server

```sql
create table "files" ("id" bigint identity primary key not null, "type" nvarchar(255) check ("type" in (N'dir', N'file')) not null, "path" nvarchar(255) not null, "level" smallint not null default '0', "file_size" bigint not null default '0', "mime_type" nvarchar(127) null, "visibility" nvarchar(255) check ("visibility" in (N'public', N'private')) not null default 'private', "content_hash" nvarchar(128) null, "last_modified" bigint not null default '0', "extra_metadata" nvarchar(max) null)

create index "files_path_index" on "files" ("path")

create index "files_path_level_index" on "files" ("path", "level")

create index "files_content_hash_index" on "files" ("content_hash")

create unique index "files_path_unique" on "files" ("path")

create table "file_contents" ("id" bigint identity primary key not null, "hash" nvarchar(128) not null, "reference_count" int not null default '0', "contents" varbinary(max) not null)

create index "file_contents_hash_index" on "file_contents" ("hash")

create unique index "file_contents_hash_unique" on "file_contents" ("hash")
```

### New Adapter Instance

Depending on your database, a different configuration will be required. You can find available connection configuration in [Laravel's example configuration file](https://github.com/laravel/laravel/blob/9.x/config/database.php).   

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