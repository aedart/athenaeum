<?php

namespace Aedart\Antivirus\Validation\Rules;

use Aedart\Antivirus\Facades\Antivirus;
use Aedart\Contracts\Antivirus\Exceptions\AntivirusException;
use Aedart\Validation\Rules\BaseValidationRule;
use Closure;

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
    ) {}

    /**
     * {@inheritDoc}
     *
     * Scans the given Uploaded File for infections. Fails if file is not "clean".
     *
     * @throws AntivirusException
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $scanner = Antivirus::profile($this->profile, $this->options);

        if (!$scanner->isClean($value)) {
            $fail('athenaeum::antivirus.infected')->translate([ 'attribute' => $attribute ]);
        }
    }
}