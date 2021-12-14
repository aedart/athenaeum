<?php

namespace Aedart\Filters\Query\Filters\Concerns;

use Aedart\Utils\Str;
use voku\helper\StopWords as StopWordsRepository;

/**
 * @deprecated Since v5.25.x - stop words language no longer supported, due to undesired behaviour.
 *
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

        // Wrap each stop-word with white-spaces or the given
        // search term might be manipulated in an undesirable fashion.
        $formatted = array_map(function ($word) {
            return " {$word} ";
        }, $stopWords);

        return Str::replace($formatted, '', $search);
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
