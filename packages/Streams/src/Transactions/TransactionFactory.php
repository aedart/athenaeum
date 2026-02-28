<?php

namespace Aedart\Streams\Transactions;

use Aedart\Contracts\Streams\BufferSizes;
use Aedart\Contracts\Streams\Locks\LockType;
use Aedart\Contracts\Streams\Stream;
use Aedart\Contracts\Streams\Transactions\Factory;
use Aedart\Contracts\Streams\Transactions\Transaction;
use Aedart\Streams\Exceptions\Transactions\ProfileNotFound;
use Aedart\Streams\Transactions\Drivers\CopyWriteReplaceDriver;

/**
 * Transaction Factory
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Streams\Transactions
 */
class TransactionFactory implements Factory
{
    /**
     * Fallback profiles, when none given
     *
     * @var array
     */
    protected array $fallbackProfiles;

    /**
     * Creates a new transaction factory instance
     *
     * @param  array  $profiles  [optional] List of available profiles
     * @param  string  $defaultProfile  [optional] Name of the default profile to use
     */
    public function __construct(
        protected array $profiles = [],
        protected string $defaultProfile = 'default'
    ) {
        $this->fallbackProfiles = $this->makeFallbackProfiles();

        // Set fallback profiles, when none available
        if (empty($this->profiles)) {
            $this->usingProfiles($this->fallbackProfiles);
        }
    }

    /**
     * @inheritDoc
     */
    public function create(Stream $stream, string|null $profile = null, array $options = []): Transaction
    {
        $profile = $profile ?? $this->defaultProfile;

        // Abort if profile does not exist
        if (!isset($this->profiles[$profile])) {
            throw new ProfileNotFound(sprintf('Transaction profile %s does not exist', $profile));
        }

        // Resolve driver class and options
        $driver = $this->profiles[$profile]['driver'];
        $options = array_merge($this->profiles[$profile]['options'], $options);

        // Build and return transaction driver instance
        return new $driver($stream, $options);
    }

    /**
     * Set the available transaction profiles
     *
     * @param  array  $profiles
     *
     * @return self
     */
    public function usingProfiles(array $profiles): static
    {
        $this->profiles = $profiles;

        return $this;
    }

    /**
     * Set the name of the default transaction profile to use
     *
     * @param  string  $name
     *
     * @return self
     */
    public function defaultProfile(string $name): static
    {
        $this->defaultProfile = $name;

        return $this;
    }

    /*****************************************************************
     * Internals
     ****************************************************************/

    /**
     * Creates fallback profiles
     *
     * @return array
     */
    protected function makeFallbackProfiles(): array
    {
        return [
            'default' => [
                'driver' => CopyWriteReplaceDriver::class,
                'options' => [
                    'maxMemory' => 5 * BufferSizes::BUFFER_1MB,

                    'lock' => [
                        'enabled' => true,
                        'profile' => 'default',
                        'type' => LockType::EXCLUSIVE,
                        'timeout' => 0.5,
                    ],

                    'backup' => [
                        'enabled' => false,
                        'directory' => getcwd() . DIRECTORY_SEPARATOR . 'backup',
                        'remove_after_commit' => false,
                    ],
                ]
            ]
        ];
    }
}
