---
description: Request File Attachments
sidebarDepth: 0
---

# Attachments

[[TOC]]

## Add Attachment

You can use `attachFile()` to attach a file to your request.
The method accepts four arguments:

- `$name`: `string` Form input name
- `$path`: `string` Path to file
- `$headers`: `array` (_optional_) Http headers for attachment
- `$filename`: `string` (_optional_) Filename to be used by request   

```php
$response = $client  
        ->attachFile('annual_report', '/reports/2020_annual.pdf')
        ->multipartFormat()
        ->post('/reports/annual');
```

## Alternative Methods

The `withAttachment()` method provides an alternative way of adding an attachment.
It allows you to specify a callback, which is provided an `Attachment` instance.
This is useful when you wish to specify a stream, rather than a path to a file.
E.g. when you are dynamically creating the contents of an attachment.

```php
use Aedart\Contracts\Http\Clients\Requests\Attachment;

$response = $client  
        ->withAttachment(function(Attachment $attachment){            
            $attachment
                ->name('annual_report')
                ->contents(fopen('data.csv', 'r'))
                ->filename('2020_annual.csv');
        })
        ->multipartFormat()
        ->post('/reports/annual');
```

### Multiple Attachments

Should you require to send multiple files using the above approach, then you may `withAttachments()`, which accepts an array of callbacks.

```php
use Aedart\Contracts\Http\Clients\Requests\Attachment;

$response = $client
        ->withAttachments([
            function(Attachment $attachment){
                $attachment
                    ->name('finance_data')
                    ->contents(fopen('data.csv', 'r'))
                    ->filename('2020_finance.csv');            
            },
            function(Attachment $attachment){
                 // ...e.g. obtain data from database... not shown here...
                 $attachment
                    ->name('users_report')
                    ->contents($usersDataStream)
                    ->filename('users-report.txt');       
            },
            function(Attachment $attachment){
                $attachment
                    ->name('trending_chart')
                    ->attachFile('online_users_2020.png')
                    ->filename('online-users.png');
            },
        ])
        ->multipartFormat()
        ->post('/reports/annual');
``` 

### Create Attachment

Using an array of callbacks, several attachments were added to a request, in the previous shown example.
However, doing so can make your code slight bulky. This is especially true when you have many files you wish to attach.
To split up the attachment logic, then you may find `makeAttachment()` useful, in that it creates an "empty" attachment instance.
This allows you to create attachments in one part of your code, and add them to the request when needed.

```php

$annualReportFile = $client->makeAttachment();
$annualReportFile
    ->name('annual_report')
    ->content(fopen('annual_report.pdf', 'r'));

$usersReportFile = $client->makeAttachment();
// ...etc

// ... later, when building your request
$response = $client
        ->withAttachments([
            $annualReportFile,
            $usersReportFile,
            $trendingChartFile,
        ])
        ->multipartFormat()
        ->post('/reports/annual');
```

::: tip
The `withAttachment()` method also accepts an `Attachment` instance directly.

```php
$response = $client  
        ->withAttachment($annualReportFile)
        ->multipartFormat()
        ->post('/reports/annual');
```
:::

## Remove Attachment

If you find yourself in a situation where you are required to remove an added attachment, then such can be done using `withoutAttachment()`.
The method expects the "form input name" of the attachment as argument.

```php
$builder = $client  
        ->withoutAttachment('annual_report');
```
