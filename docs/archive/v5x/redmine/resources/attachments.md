---
description: Working with Redmine's Attachments
sidebarDepth: 0
---

# Attachments

When you wish to attach a file to an issue, you must first upload it to Redmine, so that an attachment token can be obtained.

```php
use Aedart\Redmine\Attachment;

// Upload file, obtain attachment's token
$attachment = Attachment::upload('/path/to/file.pdf');
```

## Create issue with attachment

Later, you can then choose to create a new issue with the uploaded attachment (_associates attachment with issue, in Redmine_).
The `createWithAttachments()` accepts an array of attachments.

```php
use Aedart\Redmine\Issue;

$attachments = [
    $attachmentA,
    $attachmentB,
    $attachmentC,
];

$issue = Issue::createWithAttachments([
    'project_id' => 42,
    'status_id' => 1,
    'tracker_id' => 1,
    'subject' => 'Working procedures',
], $attachments); 
```

## Add attachments to existing issue

You may also associate an attachment with an existing issue

**Note**: _The attachment MUST have a token set, or Redmine will NOT perform as desired._

```php
$issue
    ->withAttachment($attachment)
    ->save();

// ...or multiple attachments

$issue
    ->withAttachments([
        $attachmentA,
        $attachmentB,
        $attachmentC,
    ])
    ->save();
```

## Download associated attachments

The `Issue` resource also allows you to obtain associated attachments, which you can download.

```php
$attachments = Issue::findOrFail(1234, [ 'attachments' ])->attachments;

foreach($attachments as $attachment) {
    $attachment->download('/dir/where/to/download');
}
```