<?php

namespace Aedart\Antivirus\Validation\Rules;

use Aedart\Antivirus\Facades\Antivirus;
use Aedart\Contracts\Antivirus\Exceptions\AntivirusException;
use Aedart\Contracts\Streams\FileStream;
use Aedart\Validation\Rules\BaseValidationRule;
use Closure;
use Psr\Http\Message\StreamInterface as PsrStream;
use Psr\Http\Message\UploadedFileInterface as UploadedFile;
use SplFileInfo;

/**
 * Infection Free File Validation Rule
 *
 * Ensure the file under validation is "clean" (not infected with virus, malware,...etc).
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Antivirus\Validation\Rules
 */
class InfectionFreeFile extends BaseValidationRule
{
    /**
     * Create new "infection free" file validation rule instance
     *
     * @param string|null $profile [optional] Antivirus profile to use
     * @param array $options [optional] Evt. profile options (applied only if a scanner has not
     *                       yet been created for the profile).
     */
    public function __construct(
        protected string|null $profile = null,
        protected array $options = []
    ) {
    }

    /**
     * Scan the given file for infections, e.g. virus, malware or other harmful code...
     *
     * @param string $attribute
     * @param string|SplFileInfo|UploadedFile|FileStream|PsrStream $value
     * @param Closure $fail
     *
     * @return void
     *
     * @throws AntivirusException
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $scanner = Antivirus::profile(
            name: $this->profile(),
            options: $this->options()
        );

        if (!$scanner->isClean($value)) {
            $fail('athenaeum::antivirus.infected')->translate([ 'attribute' => $attribute ]);
        }
    }

    /**
     * Get name of the antivirus profile to use
     *
     * @return string|null
     */
    public function profile(): string|null
    {
        return $this->profile;
    }

    /**
     * Get profile specific options
     *
     * @return array
     */
    public function options(): array
    {
        return $this->options;
    }
}
