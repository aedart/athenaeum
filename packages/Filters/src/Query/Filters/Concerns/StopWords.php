<?php

namespace Aedart\Filters\Query\Filters\Concerns;

use Aedart\Utils\Str;
use voku\helper\StopWords as StopWordsRepository;

/**
 * Concerns Stop Words
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Filters\Query\Filters\Concerns
 */
trait StopWords
{
    /**
     * List of stop words to be removed
     * when searching for multiple words.
     *
     * @var array
     */
    protected array $stopWords = [];

    /**
     * Remove "stop words" from search
     *
     * @param string $search
     * @param string $language [optional]
     *
     * @return string
     */
    protected function removeStopWords(string $search, string $language = 'en'): string
    {
        $stopWords = $this->stopWordsList($language);

        return Str::replace($stopWords, '', $search);
    }

    /**
     * Returns list of stop words, for the given language
     *
     * @param string $language [optional]
     *
     * @return array
     */
    protected function stopWordsList(string $language = 'en'): array
    {
        if (!empty($this->stopWords[$language])) {
            return $this->stopWords[$language];
        }

        return $this->stopWords[$language] = (new StopWordsRepository())->getStopWordsFromLanguage($language);
    }
}
