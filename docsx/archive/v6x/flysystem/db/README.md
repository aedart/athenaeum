---
description: About the Flysystem Database Adapter
sidebarDepth: 0
---

# Introduction

As the name indicates, the database adapter allows you to store files and directories in your database.
Depending on your needs, this can be handy if you only intended to store a limited amount of files (_e.g. a few thousand¹_).

¹: _This is just a "best estimate". No actual performance tests have been conducted for this adapter!_

## Supported Databases

Behind the scene, [Laravel's Database package](https://packagist.org/packages/illuminate/database) is used to execute queries, which grants support for the following databases:

* MariaDB
* MySQL
* PostgreSQL
* SQLite
* SQL Server

_See [Laravel's official documentation for more information](https://laravel.com/docs/9.x/database#introduction)._

## Data Deduplication

The adapter makes use of [Data Deduplication](https://en.wikipedia.org/wiki/Data_deduplication) technique, which means that files that have the exact same content are only stored once.
See the [Deduplication section](./deduplication.md) for more information.