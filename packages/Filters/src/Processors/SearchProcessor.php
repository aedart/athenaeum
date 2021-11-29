<?php

namespace Aedart\Filters\Processors;

use Aedart\Contracts\Database\Query\Criteria;
use Aedart\Contracts\Filters\BuiltFiltersMap;
use Aedart\Filters\BaseProcessor;
use Aedart\Filters\Exceptions\InvalidParameter;
use Aedart\Filters\Query\Filters\SearchFilter;
use Aedart\Support\Helpers\Translation\TranslatorTrait;
use LogicException;

/**
 * Search Processor
 *
 * Builds a search query filter, for the requested search term.
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Filters\Processors
 */
class SearchProcessor extends BaseProcessor
{
    use TranslatorTrait;

    /**
     * List of table columns to search
     *
     * @var string[]
     */
    protected array $columns;

    /**
     * To total maximum search term length
     *
     * @var int
     */
    protected int $maxSearchTermLength = 100;

    /**
     * The language to use
     *
     * @var string
     */
    protected string $language = 'en';

    /**
     * @inheritDoc
     */
    public function process(BuiltFiltersMap $built, callable $next)
    {
        // Skip if empty value given
        $value = $this->value();

        if ((is_string($value) && mb_strlen($value) === 0) || is_null($value)) {
            return $next($built);
        }

        // Abort if no columns are set
        if (empty($this->columns)) {
            throw new LogicException('No table columns specified to search in');
        }

        // Validate and sanitise search term(s)
        $search = $this->cleanSearchTerm($value);

        // Finally, add the filter...
        $built->add(
            $this->parameter(),
            $this->makeFilter($search)
        );

        return $next($built);
    }

    /**
     * Set the columns to be searched
     *
     * @param string[] $columns
     *
     * @return self
     */
    public function columns(array $columns)
    {
        $this->columns = $columns;

        return $this;
    }

    /**
     * Set maximum total search term length
     *
     * @param int $length [optional]
     *
     * @return self
     */
    public function maxSearchLength(int $length = 100)
    {
        $this->maxSearchTermLength = $length;

        return $this;
    }

    /**
     * Set the language to be used
     *
     * Language is typically used for determining the "stop words"
     * to be removed, before a query is applied.
     *
     * @param string $language [optional]
     *
     * @return self
     */
    public function language(string $language = 'en')
    {
        $this->language = $language;

        return $this;
    }

    /*****************************************************************
     * Internals
     ****************************************************************/

    /**
     * Creates filter to be applied
     *
     * @param string $search
     *
     * @return Criteria
     */
    protected function makeFilter(string $search): Criteria
    {
        return new SearchFilter($search, $this->columns, $this->language);
    }

    /**
     * Validates / sanitises the search term
     *
     * @param string $search
     *
     * @return string
     *
     * @throws InvalidParameter
     */
    protected function cleanSearchTerm(string $search): string
    {
        $search = trim($search);

        // Ensure search terms does not exceed max length
        if (mb_strlen($search) > $this->maxSearchTermLength) {
            $message = $this->getTranslator()->get('validation.max.string', [
                'attribute' => $this->parameter(),
                'max' => $this->maxSearchTermLength
            ]);

            throw InvalidParameter::make($this, $message);
        }

        // Sanitise string - this should not be needed, provided that
        // search terms are NOT inserted directly into an SQL query
        // string!
        // $search = filter_var(trim($search), FILTER_SANITIZE_STRING);

        return $search;
    }
}
