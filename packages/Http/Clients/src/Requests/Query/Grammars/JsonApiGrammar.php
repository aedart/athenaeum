<?php


namespace Aedart\Http\Clients\Requests\Query\Grammars;

/**
 * Json Api Grammar
 *
 * Offers basic support for the Json API v1.x grammar.
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

    /**
     * Filter key
     *
     * @var string
     */
    protected string $filterKey = 'filter';

    /**
     * Limit key, prefix
     *
     * @var string
     */
    protected string $limitKey = 'page[limit]';

    /**
     * Offset key, prefix
     *
     * @var string
     */
    protected string $offsetKey = 'page[offset]';

    /**
     * Page number key, prefix
     *
     * @var string
     */
    protected string $pageNumberKey = 'page[number]';

    /**
     * Page size, prefix
     *
     * @var string
     */
    protected string $pageSizeKey = 'page[size]';

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

        return implode($this->resolveParameterSeparator(), $output);
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

            if (!isset($sparseFields[$from])) {
                $sparseFields[$from] = [];
            }

            // Append requested fields for resource
            $sparseFields[$from][] = $field;
        }

        $output = [];
        foreach ($sparseFields as $type => $fields) {
            $output[] = $this->compileFieldFromResource(implode(',', $fields), $type);
        }

        return implode($this->resolveParameterSeparator(), $output);
    }

    /**
     * @inheritdoc
     */
    protected function compileFieldFromResource(string $field, string $resource): string
    {
        $prefix = $this->selectKey;

        return "{$prefix}[{$resource}]={$field}";
    }

    /**
     * @inheritdoc
     */
    protected function compileRegularWhere(array $where): string
    {
        $prefix = $this->filterKey;
        $field = $where[self::FIELD];

        // Resolve condition conjunction
        $conjunction = $where[self::CONJUNCTION];
        $andSymbol = $this->resolveConjunction(self::AND_CONJUNCTION);
        $orSymbol = $this->resolveConjunction(self::OR_CONJUNCTION);

        if ($conjunction === self::AND_CONJUNCTION) {
            $field = "{$andSymbol}{$prefix}[{$field}]";
        } elseif ($conjunction === self::OR_CONJUNCTION) {
            $field = "{$andSymbol}{$prefix}[{$orSymbol}{$field}]";
        } else {
            $field = "{$prefix}[{$field}]";
        }

        // Overwrite the field and remove conjunction, so that the parent
        // is able to compile am output without additional conjunctions.
        $where[self::FIELD] = $field;
        $where[self::CONJUNCTION] = '';

        return parent::compileRegularWhere($where);
    }

    /**
     * @inheritdoc
     */
    protected function compileRawWhere(array $where): string
    {
        $expression = $this->compileExpression($where[self::FIELD], $where[self::BINDINGS]);

        // Sadly, since there is no good way to resolve "or" conjunction here, we have to
        // default using the "and" conjunction.
        if (!empty($where[self::CONJUNCTION])) {
            $andSymbol = $this->resolveConjunction(self::AND_CONJUNCTION);
            return trim($andSymbol . $expression);
        }

        return $expression;
    }

    /**
     * @inheritdoc
     */
    protected function compileSortingCriteria(array $criteria): string
    {
        $field = $criteria[self::FIELD];
        $direction = $criteria[self::DIRECTION];

        if ($direction === self::DESCENDING) {
            return "-{$field}";
        }

        return $field;
    }
}
