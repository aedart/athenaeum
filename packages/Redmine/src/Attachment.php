<?php

namespace Aedart\Redmine;

use Aedart\Contracts\Http\Clients\Exceptions\InvalidUriException;
use Aedart\Contracts\Redmine\Connection;
use Aedart\Contracts\Redmine\Deletable;
use Aedart\Contracts\Redmine\Updatable;
use Aedart\Redmine\Partials\Reference;
use Aedart\Utils\Json;
use Carbon\Carbon;
use InvalidArgumentException;
use JsonException;
use RuntimeException;
use Throwable;

/**
 * Attachment Resource
 *
 * @property int $id
 * @property string $filename
 * @property int $filesize
 * @property string $content_type
 * @property string|null $description
 * @property string $content_url
 * @property string $thumbnail_url
 * @property Reference $author
 * @property Carbon $created_on
 *
 * @property string|null $token Only available when a file is uploaded
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Redmine
 */
class Attachment extends RedmineApiResource implements
    Updatable,
    Deletable
{
    protected array $allowed = [
        'id' => 'int',
        'filename' => 'string',
        'filesize' => 'int',
        'content_type' => 'string',
        'description' => 'string',
        'content_url' => 'string',
        'thumbnail_url' => 'string',
        'author' => Reference::class,
        'created_on' => 'date',

        // Only available after file uploaded
        'token' => 'string'
    ];

    /**
     * @inheritDoc
     */
    public function resourceName(): string
    {
        return 'attachments';
    }

    /**
     * Upload a file to Redmine
     *
     * **Caution**: _By default Redmine will only return attachment `id` and `token`.
     * If you wish to obtain full attachment, set `$reload` to `true`._
     *
     * @see https://www.redmine.org/projects/redmine/wiki/rest_api#Attaching-files
     *
     * @param string $file Path to file that must be uploaded to Redmine
     * @param bool $reload [optional] Force reloaded attachment from
     *                     Redmine's API.
     * @param string|Connection|null $connection [optional] Redmine connection profile
     *
     * @return static New Attachment instance with "id" and "token" property set. The token is
     *                needed to associate attachment with issues or other resources.
     *
     *
     * @throws JsonException
     * @throws Throwable
     */
    public static function upload(string $file, bool $reload = false, string|Connection|null $connection = null): static
    {
        // Abort if file does not exist...
        if (!is_file($file)) {
            throw new InvalidArgumentException(sprintf('file "%s" does not exist', $file));
        }

        $resource = static::make([], $connection);

        // Upload file
        $response = $resource
            ->request()
            ->withContentType('application/octet-stream')
            ->withRawPayload(fopen($file, 'r'))
            ->where('filename', basename($file))
            ->post('uploads.json');

        $decoded = Json::decode($response->getBody()->getContents(), true);
        $data = $decoded['upload'];

        // Populate attachment instance
        $resource->fill($data);

        // Reload if requested
        if ($reload) {
            $resource->reload();
        }

        return $resource;
    }

    /**
     * Download this attachment from the Redmine instance
     *
     * @param string $directory Path to directory where downloaded file must be saved.
     *                          The downloaded file will have the same name as the
     *                          attachment's `filename` property.
     *
     * @return bool
     *
     * @throws RuntimeException If content_url is not specified
     * @throws InvalidArgumentException If directory is invalid
     * @throws InvalidUriException
     */
    public function download(string $directory): bool
    {
        if (empty($this->content_url)) {
            throw new RuntimeException('Unable to download attachment, no content_url specified');
        }

        if (!is_dir($directory)) {
            throw new InvalidArgumentException(sprintf('directory "%s" does not exist', $directory));
        }

        // Download the file
        $this
            ->request()
            ->withUri($this->content_url)
            ->withOption('sink', $directory . DIRECTORY_SEPARATOR . $this->filename)
            ->get();

        return true;
    }

    /**
     * Determine if this attachment has a token
     * set.
     *
     * A token is only set on an attachment after it
     * has been uploaded.
     *
     * @see upload()
     *
     * @return bool
     */
    public function hasToken(): bool
    {
        return !empty($this->token);
    }
}
