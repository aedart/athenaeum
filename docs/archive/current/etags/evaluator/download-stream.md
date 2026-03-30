---
description: Download Stream
sidebarDepth: 0
---

# Download Stream

The `DownloadStream` is a response helper that is able to create a [streamed download response](https://laravel.com/docs/13.x/responses#streamed-downloads) for an attachment.
Whenever a `Range` is requested, the helper will create either of the following stream download responses:

- The entire attachment.
- [A single part](https://httpwg.org/specs/rfc9110.html#partial.single) (_a single part of the attachment_).
- [Multiple parts](https://httpwg.org/specs/rfc9110.html#partial.multipart) (_multiple parts of the attachment_).

This chapter briefly highlights a few areas that you should be familiar with, before using the helper.  

---

[[TOC]]

## Create Streamed Download Response

By using the `for()` method, you can create a new download stream directly for your [Resource Content](./resource-context.md).

```php
use Illuminate\Support\Facades\Route;
use Aedart\ETags\Preconditions\Responses\DownloadStream;

Route::get('/downloads/{file}', function (DownloadFileRequest $request) {

    return DownloadStream::for($request->resource)
        ->setName($request->route('file'));
});
```

For a more complete example, please review the [Files and Range Support](./resource-context.md#files-and-range-support) section.

## Attachment Types

Internally, the `DownloadStream` attempts to open a [File Stream](../../streams/README.md) for the given attachment (_e.g. for the `ResourceContext` data_).
As such, the following types of "attachments" are supported:

* A file `resource` from [`fopen()`](https://www.php.net/manual/en/function.fopen).
* A [File Stream](../../streams/README.md) instance.
* A [Psr stream (`StreamInterface`)](https://www.php-fig.org/psr/psr-7/#34-psrhttpmessagestreaminterface).
* [`SplFileInfo`](https://www.php.net/manual/en/class.splfileinfo) instance, e.g. `\Illuminate\Http\File`.
* Path to existing file.

If the attachment type is not supported, then a `RuntimeException` is thrown, when the helper attempts to create a response.

### Custom

Should the default provided attachment types not cover your needs, then you can specify a callback to resolve a file stream.
This can be useful when you have the contents of a file (_e.g. from database_), but not an actual physical file. 

Use `setResolveStreamCallback()` to specify a custom resolve method. The callback **MUST** return a valid `FileStream` instance.

```php
use Aedart\Streams\FileStream;

$response = DownloadStream::for($request->resource)
        ->setResolveStreamCallback(function(mixed $data){
            return FileStream::openTemporary()
                ->append($data)
                ->positionToStart();
        });
```

## Content Disposition

The `Content-Disposition` is by default set to "attachment" with a filename. This means that browser clients are forced to download the file. 
If you wish to allow browsers to display the contents of the file directly in the website, then you can do so via the `asInlineDisposition()` method. 

```php
$response = DownloadStream::for($request->resource)
    ->asInlineDisposition();
```

See [Mozilla's documentation](https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Content-Disposition) for additional information about `Content-Disposition`.

## Headers

To set custom headers, you can use the `withHeaders()` or `header()` methods.

```php
$response = DownloadStream::for($request->resource)
    ->withHeaders([
        'X-Foo' => 'bar',
        'X-Author' => 'Charlotte Kennedy'
    ])

    // Or,...
    ->header('X-Contact', 'charlotte.kennedy@exmaple.org');
```

## Accept Ranges

By default, `bytes` is set as the [`Accept-Ranges`](https://httpwg.org/specs/rfc9110.html#field.accept-ranges) header value.
Consequently, the `DownloadStream` helper, as well as [If-Range](./rfc9110/if-range.md) and [Range](./extensions/range.md) preconditions, will process an attachment's bytes, when one or more ranges are requested via the `Range` header.

### Other Units

::: danger Recommendation !

Despite the possibility to specify other values for `Accept-Ranges` header, it is **highly discouraged** to use any other value than `bytes`.
You risk confusing Http clients and possibly cause response processing conflicts.

_Only if you are 100% in control of your clients, e.g. in a closed system, and in full control of how attachments are requested, then you could use a different kind of unit._

:::

To specify a different unit as acceptable range, use `withAcceptRanges()`.
The implementation supports all units that can be converted to and from `bytes`.
See [Memory Util](../../utils/memory.md) for details.

```php
$response = DownloadStream::for($request->resource)
    ->withAcceptRanges('kilobytes');
```

From the above example, if a single range is requested, then the streamed download response could look something like this:

```{4,5}
HTTP/1.1 206 Partial Content
Date: Fri, 05 Feb 2023 10:05:24 GMT
Last-Modified: Mon, 30 Jan 2023 11:06:13 GMT
Content-Range: kilobytes 0-2/6
Content-Length: 3000
Content-Type: plain/text
Content-Disposition: attachment; filename=contacts.txt

(3000 bytes of partial text file... not shown here)
```

Notice that the `Content-Range` is specified in kilobytes, whereas the `Content-Length` is in bytes!
According to [RFC 9110](https://httpwg.org/specs/rfc9110.html#field.content-length):

_[...] Content-Length is used for message delimitation in HTTP/1.1, its field value can impact how the message is parsed by downstream recipients [...]
If the message is forwarded by a downstream intermediary, a Content-Length field value that is inconsistent with the received message framing might cause a security failure due to request smuggling or response splitting [...]_

In other words, the `Content-Length` does not contain any information about what unit type the value represents.
But it bares significance for clients.
According to [Mozilla's documentation](https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Content-Length), the value is **_always specified in bytes_**. 
As such, it would be dangerous to convert the `Content-Length` to any other value than bytes.

## Onward

For more information about the `DownloadStream`, please review the helper's source code.
