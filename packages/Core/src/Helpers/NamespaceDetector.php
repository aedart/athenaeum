<?php

namespace Aedart\Core\Helpers;

use Aedart\Contracts\Core\Helpers\NamespaceDetector as Detector;
use Aedart\Utils\Json;
use Illuminate\Support\Arr;
use JsonException;
use RuntimeException;

/**
 * Application Namespace Detector
 *
 * @see \Aedart\Contracts\Core\Helpers\NamespaceDetector
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Core\Helpers
 */
class NamespaceDetector implements Detector
{
    /**
     * @inheritdoc
     */
    public function detect(string $composerPath): string
    {
        // Laravel's version of namespace detection differs from the one below.
        // Here, we guess that the first found PSR-4 namespace is the one
        // that the application should use...
        // See https://github.com/laravel/framework/blob/6.x/src/Illuminate/Foundation/Application.php#L1222

        // Abort if unable to find composer.json
        if (!is_file($composerPath)) {
            throw new RuntimeException(sprintf('Unable to load %s', $composerPath));
        }

        // Load the content of the composer.json file
        try {
            $content = Json::decode(file_get_contents($composerPath), true);
        } catch (JsonException $e) {
            throw new RuntimeException('Unable to decode composer.json: ' . $e->getMessage(), $e->getCode(), $e);
        }

        // Get the "psr4" namespace declarations
        $psr4 = Arr::get($content, 'autoload.psr-4');
        if (!isset($psr4)) {
            throw new RuntimeException('composer.json does not contain any psr-4 namespace declaration');
        }

        // We take a lucky guess about the application's namespace.
        // It might NOT be correct, but should satisfy Laravel's application interface.
        return array_key_first($psr4);
    }
}
