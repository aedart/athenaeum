---
description: Database Adapter Data Deduplication
sidebarDepth: 0
---

# Data Deduplication

Imagine that you are building a small application that allows users to upload small text files containing greeting messages (_or other types of files_).
Chances are good that multiple users will upload the exact same greeting messages, as previously uploaded.
Thus, your storage will contain duplicates.

To avoid this kind of situation, the database adapter makes use of data deduplication: "_[...] a technique for eliminating duplicate copies of repeating data [...]_" ([_Wiki_](https://en.wikipedia.org/wiki/Data_deduplication))
Consider the following:

```php
$content = 'Hi there';

$filesystem->write('home/message.txt', $content);
$filesystem->write('home/other_message.txt', $content);
```

In the above example, two files are written to the database. However, the adapter ensures that the content is only stored once.

## Content Hashing

The adapter hashes each written file's content and performs a simple check.
If the hash already exists, then an internal `reference_count` is incremented. Content is not inserted if this is the case.
However, if the hash does not exist, then content is inserted.

By default, `sha256` hashing algorithm is used when hashing contents. You can change this via the `setHashAlgorithm()`:

```php
$adapter->setHashAlgorithm('md5')
```

::: warning Caution
Be careful of what hashing algorithm you choose. Some are fast, but might have a high risk of hash-collision.
See [wiki](https://en.wikipedia.org/wiki/Hash_collision) for more information.
:::

## When files are deleted

When files are deleted, the adapter automatically cleans up its file-content records.
Content records' `reference_count` is decreased when a file is deleted. When the reference counter reaches `0`, actual content is automatically removed.

## Performance Considerations

Due to this applied deduplication technique, this adapter _SHOULD NOT_ be expected to be very fast.
It will get the job done. But, if performance is very important for your application, then you _SHOULD_ choose a different flysystem adapter!  