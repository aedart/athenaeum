<?php

namespace Aedart\Tests\Integration\Antivirus\Validation\Rules;

use Aedart\Antivirus\Validation\Rules\InfectionFreeFile;
use Aedart\Contracts\Antivirus\Events\FileWasScanned;
use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Testing\Helpers\Http\Response;
use Aedart\Tests\TestCases\Antivirus\AntivirusTestCase;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Route;
use Illuminate\Testing\Fluent\AssertableJson;
use JsonException;
use SplFileInfo;

/**
 * InfectionFreeFileRuleTest
 *
 * @group antivirus
 * @group antivirus-validation
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Antivirus\Validation\Rules
 */
class InfectionFreeFileRuleTest extends AntivirusTestCase
{
    /**
     * @inheritdoc
     */
    protected function _before()
    {
        parent::_before();

        // Debugging
        //$this->withoutExceptionHandling();

        Event::listen(FileWasScanned::class, function (FileWasScanned $event) {
            ConsoleDebugger::output($event->result()->toArray());
        });
    }

    /*****************************************************************
     * Helpers
     ****************************************************************/

    /**
     * Makes validation rule
     *
     * @param bool $shouldPass
     *
     * @return ValidationRule
     */
    public function makeRule(bool $shouldPass): ValidationRule
    {
        $profile = null;

        // When not running live tests, use null (pass / fail) profiles.
        if (!$this->isLive()) {
            $profile = $shouldPass
                ? 'pass'
                : 'fail';
        }

        $rule = new InfectionFreeFile($profile);

        ConsoleDebugger::output(sprintf('Validation rule using "%s" as antivirus profile', $rule->profile() ?? 'default'));

        return $rule;
    }

    /**
     * Makes a new test uploaded file
     *
     * @param string $path
     * @param string $name
     *
     * @return SplFileInfo
     */
    public function makeUploadedFile(string $path, string $name): SplFileInfo
    {
        return new UploadedFile(
            path: $path,
            originalName: $name,
            test: true
        );
    }

    /*****************************************************************
     * Actual Tests
     ****************************************************************/

    /**
     * @test
     *
     * @return void
     */
    public function passesCleanFile(): void
    {
        Route::post('/files', function (Request $request) {
            $request->validate([
                'file' => [
                    'required',
                    'file',
                    $this->makeRule(true)
                ]
            ]);

            return response()->noContent();
        })->name('file.upload');

        Route::getRoutes()->refreshNameLookups();

        // ----------------------------------------------------------------- //

        $file = $this->makeUploadedFile(
            $this->cleanFile(),
            'myFile.txt'
        );

        $url = route('file.upload');
        $this
            ->post($url, [
                'file' => $file
            ])
            //->dump()
            ->assertNoContent();
    }

    /**
     * @test
     *
     * @return void
     *
     * @throws JsonException
     */
    public function failsInfectedFile(): void
    {
        Route::post('/files', function (Request $request) {
            $request->validate([
                'file' => [
                    'required',
                    'file',
                    $this->makeRule(false)
                ]
            ]);

            return response()->noContent();
        })->name('file.upload');

        Route::getRoutes()->refreshNameLookups();

        // ----------------------------------------------------------------- //

        $file = $this->makeUploadedFile(
            $this->infectedFile(),
            'myFile.txt'
        );

        $url = route('file.upload');
        $response = $this
            ->post($url, [
                'file' => $file
            ], [ 'accept' => 'application/json' ])
            //->dump()
            ->assertUnprocessable()
            ->assertJson(
                fn (AssertableJson $json) =>
                $json
                    ->has('errors.file')
                    ->etc()
            );

        Response::decode($response);
    }

    /**
     * @test
     *
     * @return void
     */
    public function canApplyRuleOnMultipleFiles(): void
    {
        Route::post('/files', function (Request $request) {
            $request->validate([
                'files' => [ 'array' ],
                'files.*' => [
                    'required',
                    'file',
                    $this->makeRule(true)
                ]
            ]);

            return response()->noContent();
        })->name('file.upload');

        Route::getRoutes()->refreshNameLookups();

        // ----------------------------------------------------------------- //

        $files = [
            $this->makeUploadedFile(
                $this->cleanFile(),
                'file_a.txt'
            ),
            $this->makeUploadedFile(
                $this->cleanFile(),
                'file_b.txt'
            ),
            $this->makeUploadedFile(
                $this->cleanFile(),
                'file_c.txt'
            ),
        ];

        $url = route('file.upload');
        $this
            ->post($url, [
                'files' => $files
            ])
            //->dump()
            ->assertNoContent();
    }

    /**
     * @test
     *
     * @return void
     *
     * @throws JsonException
     */
    public function failsWhenInvalidFilePathGiven(): void
    {
        Route::post('/files', function (Request $request) {
            $request->validate([
                'file' => [
                    'nullable',
                    'file',
                    $this->makeRule(true) // "shouldPass" does not apply for this test...
                ]
            ]);

            return response()->noContent();
        })->name('file.upload');

        Route::getRoutes()->refreshNameLookups();

        // ----------------------------------------------------------------- //

        // NOTE: Invalid "file" to trigger underlying "unable to open stream..." exception, and thereby
        // validation failure.
        $file = 'null';

        // ----------------------------------------------------------------- //

        //        $this->withoutExceptionHandling();

        $url = route('file.upload');
        $response = $this
            ->post($url, [
                'file' => $file
            ], [ 'accept' => 'application/json' ])
            //->dump()
            ->assertUnprocessable()
            ->assertJson(
                fn (AssertableJson $json) =>
                $json
                    ->has('errors.file')
                    ->etc()
            );

        Response::decode($response);
    }
}
