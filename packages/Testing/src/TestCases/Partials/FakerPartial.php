<?php


namespace Aedart\Testing\TestCases\Partials;

use Aedart\Testing\Traits\FakerTrait;
use Faker\Factory;
use Faker\Generator;

/**
 * Faker Partial
 *
 * @see \Faker\Generator
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Testing\TestCases\Partials
 */
trait FakerPartial
{
    use FakerTrait;

    /**
     * Language locale to be used by the faker
     * Generator
     *
     * @see \Faker\Factory::DEFAULT_LOCALE
     *
     * @var string|null
     */
    protected ?string $fakerLocale = Factory::DEFAULT_LOCALE;

    /**
     * Setup the faker generator
     */
    protected function setupFaker()
    {
        $this->setFaker($this->makeFaker(
            $this->fakerLocale
        ));
    }

    /**
     * Create a new faker instance
     *
     * @param string|null $locale [optional] Language locale. Defaults to "en_US" if none specified
     *
     * @return Generator|null
     */
    protected function makeFaker(?string $locale = null): ?Generator
    {
        return Factory::create($locale);
    }

    /**
     * Get a default faker value, if any is available
     *
     * @return Generator|null A default faker value or Null if no default value is available
     */
    public function getDefaultFaker(): ?Generator
    {
        return $this->makeFaker($this->fakerLocale);
    }
}
