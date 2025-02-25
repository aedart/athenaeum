<?php

namespace Aedart\Tests\Integration\Support\Env;

use Aedart\Support\Env\Exceptions\FileNotFound;
use Aedart\Support\Env\Exceptions\KeyNotFound;
use Aedart\Support\EnvFile;
use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Tests\TestCases\Support\EnvFileTestCase;
use Aedart\Utils\Str;
use Codeception\Exception\ConfigurationException;

/**
 * EnvFileTest
 *
 * @group laravel
 * @group support
 * @group support-env
 * @group support-env-file
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Tests\Integration\Support\Env
 */
class EnvFileTest extends EnvFileTestCase
{
    /**
     * @test
     *
     * @return void
     */
    public function failsLoadingIfEnvironmentFileDoesNotExist(): void
    {
        $this->expectException(FileNotFound::class);

        EnvFile::load('/my_unknown_env_file');
    }

    /**
     * @test
     *
     * @return void
     *
     * @throws ConfigurationException
     */
    public function canLoadEnvironmentFileContents(): void
    {
        $contents = EnvFile::load($this->envFilePath())->contents();

        ConsoleDebugger::output($contents);

        $this->assertNotEmpty($contents);
    }

    /**
     * @test
     *
     * @return void
     *
     * @throws ConfigurationException
     */
    public function canDetermineIfKeyExists(): void
    {
        $env = EnvFile::load($this->envFilePath());

        $hasAppName = $env->has('APP_NAME');
        $hasUnknownKey = $env->has('UNKNOWN_KEY');

        $this->assertTrue($hasAppName, 'APP_NAME should exist');
        $this->assertFalse($hasUnknownKey, 'UNKNOWN_KEY should NOT exist');
    }

    /**
     * @test
     *
     * @return void
     *
     * @throws ConfigurationException
     */
    public function canAppendKeyValuePair(): void
    {
        $env = EnvFile::load($this->envFilePath());

        $key = 'FOO';
        $value = 'bar';

        // -------------------------------------------------------------------- //

        $contents = $env
            ->append($key, $value)
            ->contents();

        ConsoleDebugger::output($contents);

        $this->assertTrue(str_ends_with($contents, "\n{$key}={$value}"), 'Key-value pair not appended');
    }

    /**
     * @test
     *
     * @return void
     *
     * @throws ConfigurationException
     */
    public function canAppendKeyValuePairWithComment(): void
    {
        $env = EnvFile::load($this->envFilePath());

        $key = 'MY_APP_SECRET';
        $value = Str::random();
        $comment = 'Custom application secret...';

        // -------------------------------------------------------------------- //

        $contents = $env
            ->append($key, $value, $comment)
            ->contents();

        ConsoleDebugger::output($contents);

        $this->assertTrue(str_ends_with($contents, "\n# {$comment}\n{$key}={$value}"), 'Key-value pair with comment not appended');
    }

    /**
     * @test
     *
     * @return void
     *
     * @throws ConfigurationException
     */
    public function canReplaceKeyValuePair(): void
    {
        $env = EnvFile::load($this->envFilePath());

        $key = 'REDMINE_TOKEN';
        $value = Str::random();

        // -------------------------------------------------------------------- //

        $contents = $env
            ->replace($key, $value)
            ->contents();

        ConsoleDebugger::output($contents);

        $this->assertTrue(str_contains($contents, "\n{$key}={$value}"), 'Key-value pair not replaced');
    }

    /**
     * @test
     *
     * @return void
     *
     * @throws ConfigurationException
     */
    public function failsReplacingKeyValueIfKeyDoesNotExist(): void
    {
        $this->expectException(KeyNotFound::class);

        $key = 'UNKNOWN_KEY';
        $value = Str::random();

        EnvFile::load($this->envFilePath())
            ->replace($key, $value)
            ->contents();
    }

    /**
     * @test
     *
     * @return void
     *
     * @throws ConfigurationException
     */
    public function canSaveChangesToFile(): void
    {
        $env = EnvFile::load($this->envFilePath());

        $key = 'REDMINE_TOKEN';
        $value = Str::random();

        // -------------------------------------------------------------------- //

        $contents = $env
            ->replace($key, $value)
            ->save()
            ->refresh() // Important here - forces the contents to be reloaded
            ->contents();

        ConsoleDebugger::output($contents);

        $this->assertTrue(str_contains($contents, "\n{$key}={$value}"), 'Changes to environment file were not written');
    }
}
