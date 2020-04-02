<?php


namespace Aedart\Http\Clients\Requests\Query\Grammars;

/**
 * Json Api Grammar
 *
 * Offers basic support for the Json API grammar.
 *
 * @see https://jsonapi.org/
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Http\Clients\Requests\Query\Grammars
 */
class JsonApiGrammar extends BaseGrammar
{
    /**
     * Select key, prefix for selects
     *
     * @var string
     */
    protected string $selectKey = 'fields';

    /*****************************************************************
     * Internals
     ****************************************************************/

    /**
     * @inheritdoc
     */
    protected function compileSelects(array $selects = []): string
    {
        if (empty($selects)) {
            return '';
        }

        $output = [];
        foreach ($selects as $select) {
            $output[] = $this->compileSelect($select);
        }

        return implode('&', $output);
    }

    /**
     * @inheritdoc
     */
    protected function compileRegularSelect(array $select): string
    {
        $sparseFields = [];

        // First, we need to gather all fields for the requested resource.
        $fields = $select[self::FIELDS];
        foreach ($fields as $field => $from) {
            if (is_numeric($field)) {
                $field = $from;
                $from = '';
            }

            if(!isset($sparseFields[$from])){
                $sparseFields[$from] = [];
            }

            // Append requested fields for resource
            $sparseFields[$from][] = $field;
        }

        $output = [];
        foreach ($sparseFields as $type => $fields){
            $output[] = $this->compileFieldFromResource(implode(',', $fields), $type);
        }

        return implode('&', $output);
    }

    /**
     * @inheritdoc
     */
    protected function compileFieldFromResource(string $field, string $resource): string
    {
        $prefix = $this->selectKey;

        return "{$prefix}[{$resource}]={$field}";
    }
}
