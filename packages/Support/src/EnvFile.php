<?php

namespace Aedart\Support;

use Aedart\Support\Env\Concerns\EnvironmentFilePath;
use Aedart\Support\Env\Exceptions\EnvironmentFileException;
use Aedart\Support\Env\Exceptions\FileNotFound;
use Aedart\Support\Env\Exceptions\KeyNotFound;
use Aedart\Support\Env\Exceptions\UnableToReadContents;

/**
 * Env File
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Support
 */
class EnvFile
{
    use EnvironmentFilePath;

    /**
     * The contents of the environment file
     *
     * @var string
     */
    protected string $contents = '';

    /**
     * Create a new Environment File instance
     *
     * @param string|null $path [optional] Path to env file. Defaults to Laravel's environment file path.
     * @param bool $load [optional] If true, the contents of the environment file is loaded into memory.
     *
     * @throws EnvironmentFileException
     */
    public function __construct(string|null $path = null, bool $load = false)
    {
        $this->setEnvironmentFilePath($path);

        if ($load) {
            $this->refresh();
        }
    }

    /**
     * Load environment file content into memory
     *
     * @param string|null $path [optional] Path to env file. Defaults to Laravel's environment file path.
     *
     * @return static
     *
     * @throws EnvironmentFileException
     */
    public static function load(string|null $path = null): static
    {
        return new static($path, true);
    }

    /**
     * Reloads the contents of the environment file.
     *
     * @return self
     *
     * @throws EnvironmentFileException
     */
    public function refresh(): static
    {
        $path = $this->getEnvironmentFilePath();

        if (!file_exists($path)) {
            throw new FileNotFound("Environment file '{$path}' does not exist.");
        }

        $contents = file_get_contents($path);
        if ($contents === false) {
            throw new UnableToReadContents("Unable to read contents of '{$path}'.");
        }

        $this->contents = $contents;

        return $this;
    }

    /**
     * Write the contents into the environment file
     *
     * @return self
     */
    public function save(): static
    {
        $path = $this->getEnvironmentFilePath();

        $bytes = file_put_contents($path, $this->contents);
        if ($bytes === false) {
            throw new UnableToReadContents("Unable to write contents for '{$path}'.");
        }

        return $this;
    }

    /**
     * Determine if key exists in environment file
     *
     * @param string $key
     *
     * @return bool
     */
    public function has(string $key): bool
    {
        $key = $this->resolveKey($key);

        return str_contains($this->contents, "\n{$key}=");
    }

    /**
     * Append a new key-value pair
     *
     * @param string $key
     * @param string|int $value
     * @param string|null $comment [optional] Evt. comment for the key-value pair.
     *
     * @return self
     */
    public function append(string $key, string|int $value, string|null $comment = null): static
    {
        $key = $this->resolveKey($key);

        $prefix = '';
        if ($comment) {
            $prefix = "\n# {$comment}";
        }

        $this->contents .= "{$prefix}\n{$key}={$value}";

        return $this;
    }

    /**
     * Replace the value of an existing key in the environment file
     *
     * @param string $key
     * @param string|int $value
     *
     * @return self
     *
     * @throws EnvironmentFileException
     */
    public function replace(string $key, string|int $value): static
    {
        if (!$this->has($key)) {
            throw new KeyNotFound(sprintf('Key %s does not exist, in %s', $key, $this->getEnvironmentFilePath()));
        }

        $key = $this->resolveKey($key);

        $this->contents = preg_replace(
            pattern: $this->makeKeySearchPattern($key),
            replacement: "{$key}={$value}",
            subject: $this->contents,
            limit: 1,
        );

        return $this;
    }

    /**
     * Returns the loaded environment file's contents
     *
     * @return string
     */
    public function contents(): string
    {
        return $this->contents;
    }

    /*****************************************************************
     * Internals
     ****************************************************************/

    /**
     * Creates a RegEx search pattern for a key inside the environment file
     *
     * @param string $key
     *
     * @return string
     */
    protected function makeKeySearchPattern(string $key): string
    {
        return "/^{$key}=(.)*/m";
    }

    /**
     * Resolves given key
     *
     * @param string $key
     *
     * @return string
     */
    protected function resolveKey(string $key): string
    {
        return strtoupper($key);
    }
}
