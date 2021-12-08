<?php

namespace Aedart\Filters\Query\Filters\Fields;

use Aedart\Contracts\Database\Query\FieldCriteria;
use Aedart\Utils\Str;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use InvalidArgumentException;
use LogicException;

/**
 * Belongs To Filter
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Filters\Query\Filters\Fields
 */
class BelongsToFilter extends BaseFieldFilter
{
    /**
     * Name of the belongs to relation this
     * filter must be applied on
     *
     * @var string
     */
    protected string $relation;

    /**
     * State whether relation value is expected
     * to be numeric (e.g. integer primary key)
     * or string (e.g. slug)
     *
     * @var bool
     */
    protected bool $isNumericRelation = true;

    /**
     * State whether value assertion should be skipped
     *
     * @var bool
     */
    protected bool $skipValueAssert = false;

    /**
     * {@inheritDoc}
     *
     * @param string $field [optional]
     */
    public function __construct(
        string $field = 'id',
        string $operator = 'eq',
        $value = null,
        string $logical = FieldCriteria::AND
    ) {
        // This filter is intended to be created as an instance, and not
        // stated as a class path inside a "constraints processor". The "relation"
        // name MUST be stated. However, despite all arguments being optional for
        // this constructor, if given value is null then value-assertion will fail.
        // for this reason, we disable value assertion here, when null is given.
        // This ONLY applies for this constructor! If a new value is set, then it
        // will be asserted again!
        if (is_null($value)) {
            $this->skipValueAssert = true;
        }

        parent::__construct($field, $operator, $value, $logical);
    }

    /**
     * {@inheritDoc}
     *
     * @param string $field [optional]
     */
    public static function make(
        string $field = 'id',
        string $operator = 'eq',
        $value = null,
        string $logical = FieldCriteria::AND
    ) {
        return new static($field, $operator, $value, $logical);
    }

    /**
     * @inheritDoc
     */
    public function apply($query)
    {
        $relation = $this->relation();
        $model = $query->getModel();

        // Fail if relation does not exist in model.
        if (!method_exists($model, $relation)) {
            throw new LogicException(sprintf('Relation %s does not exist in model %s', $relation, get_class($model)));
        }

        // Determine the type of relation that the constraint must be built
        // for. E.g. use "whereHas" or "whereHasMorph" constraint.
        $isMorph = false;
        $relationInstance = $model->{$relation};
        if ($relationInstance instanceof MorphTo) {
            $isMorph = true;
        }

        // Extract relation field.
        $relationField = $this->extractRelationField($this->field());

        // Determine operator and build appropriate query
        $operator = $this->operator();
        switch ($operator) {
            case 'in':
                if ($isMorph) {
                    return $this->buildWhereMorphIn($query, $relationField);
                }

                return $this->buildWhereRelationIn($query, $relationField);
            case 'not_in':
                if ($isMorph) {
                    return $this->buildWhereMorphNotIn($query, $relationField);
                }

                return $this->buildWhereRelationNotIn($query, $relationField);

            case 'is_null':
                return $this->buildWhereRelationDoesNotExists($query);
            case 'not_null':
                return $this->buildWhereRelationExists($query);

            default:
                if ($isMorph) {
                    return $this->buildWhereHasMorph($query, $relationField);
                }

                return $this->buildWhereHas($query, $relationField);
        }
    }

    /**
     * @inheritDoc
     */
    public function operatorAliases(): array
    {
        return [
            'eq' => '=',
            'ne' => '!=',

            // NOTE: Values do NOT correspond directly to sql operators for these...
            'is_null' => 'is_null',
            'not_null' => 'not_null',
            'in' => 'in',
            'not_in' => 'not_in',
        ];
    }

    /**
     * Set the name of the belongs to relation that this
     * filter must be applied on
     *
     * @param string $relation
     *
     * @return self
     */
    public function setRelation(string $relation)
    {
        $this->relation = $relation;

        return $this;
    }

    /**
     * Get the name of the belongs to relation that this
     * filter must be applied on
     *
     * @return string
     */
    public function relation(): string
    {
        if (!isset($this->relation)) {
            throw new LogicException('Relation not specified for belongs to filter. Unable to proceed!');
        }

        return $this->relation;
    }

    /**
     * Set state whether relation value is numeric or not.
     *
     * Use numeric relation when related field is an integer,
     * e.g. related model uses integer primary key.
     *
     * @param bool $isNumeric [optional]
     *
     * @return self
     */
    public function usingNumericValue(bool $isNumeric = true)
    {
        $this->isNumericRelation = $isNumeric;

        return $this;
    }

    /**
     * Determine whether related field is expected to be numeric
     * or not
     *
     * @return bool
     */
    public function isNumericValue(): bool
    {
        return $this->isNumericRelation;
    }

    /**
     * Set state whether relation value is string or not.
     *
     * Use string relation when related field is a string,
     * e.g. related model uses a string identifier , like a slug.
     *
     * @param bool $isString [optional]
     *
     * @return self
     */
    public function usingStringValue(bool $isString = true)
    {
        return $this->usingNumericValue(!$isString);
    }

    /**
     * Determine whether related field is expected to be a string
     * or not
     *
     * @return bool
     */
    public function isStringValue(): bool
    {
        return !$this->isNumericValue();
    }

    /*****************************************************************
     * Internals
     ****************************************************************/

    /**
     * @inheritDoc
     */
    protected function assertValue($value)
    {
        // Skip value assertion if requested. Reset state when doing so...
        if ($this->skipValueAssert) {
            $this->skipValueAssert = false;
            return;
        }

        // Allow empty values, when "is null / not null" operators are
        // chosen.
        $operator = $this->operator();
        if (empty($value) && in_array($operator, [ 'is_null', 'not_null' ])) {
            return;
        }

        // Allow list of numeric values...
        if (in_array($operator, [ 'in', 'not_in' ]) && Str::contains($value, ',')) {
            $values = $this->valueToList($value);

            foreach ($values as $v) {
                if ($this->isNumericValue()) {
                    $this->assertInteger($v);
                    continue;
                }

                $this->assertString($v);
            }

            return;
        }

        if ($this->usingNumericValue()) {
            $this->assertInteger($value);
            return;
        }

        $this->assertString($value);
    }

    /**
     * Assert given value an integer
     *
     * @param mixed $value
     *
     * @throws InvalidArgumentException
     */
    protected function assertInteger($value)
    {
        if (!ctype_digit(strval($value))) {
            $translator = $this->getTranslator();

            throw new InvalidArgumentException($translator->get('validation.numeric', [ 'attribute' => 'value' ]));
        }
    }

    /**
     * Assert given value a string
     *
     * @param mixed $value
     *
     * @throws InvalidArgumentException
     */
    protected function assertString($value)
    {
        if (!(is_string($value) && !is_numeric($value))) {
            $translator = $this->getTranslator();

            throw new InvalidArgumentException($translator->get('validation.string', [ 'attribute' => 'value' ]));
        }
    }

    /**
     * Builds "where has morph relation..." constraint
     *
     * @param MorphTo $query
     * @param string $field
     *
     * @return MorphTo
     */
    protected function buildWhereHasMorph(MorphTo $query, string $field): MorphTo
    {
        if ($this->logical() === FieldCriteria::OR) {
            return $query->orWhereHasMorph($this->relation(), '*', function ($query) use ($field) {
                $query->where($field, $this->operator(), $this->value());
            });
        }

        return $query->whereHasMorph($this->relation(), '*', function ($query) use ($field) {
            $query->where($field, $this->operator(), $this->value());
        });
    }

    /**
     * Builds "where morph relation is in xyz" constraint
     *
     * @param MorphTo $query
     * @param string $field
     *
     * @return MorphTo
     */
    protected function buildWhereMorphIn(MorphTo $query, string $field): MorphTo
    {
        $value = $this->valueToList($this->value());

        if ($this->logical() === FieldCriteria::OR) {
            return $query->orWhereHasMorph($this->relation(), '*', function ($query) use ($field, $value) {
                $query->whereIn($field, $value);
            });
        }

        return $query->whereHasMorph($this->relation(), '*', function ($query) use ($field, $value) {
            $query->whereIn($field, $value);
        });
    }

    /**
     * Builds "where morph relation is NOT in xyz" constraint
     *
     * @param MorphTo $query
     * @param string $field
     *
     * @return MorphTo
     */
    protected function buildWhereMorphNotIn(MorphTo $query, string $field): MorphTo
    {
        $value = $this->valueToList($this->value());

        if ($this->logical() === FieldCriteria::OR) {
            return $query->orWhereHasMorph($this->relation(), '*', function ($query) use ($field, $value) {
                $query->whereNotIn($field, $value);
            });
        }

        return $query->whereHasMorph($this->relation(), '*', function ($query) use ($field, $value) {
            $query->whereNotIn($field, $value);
        });
    }

    /**
     * Builds "where has relation..." constraint
     *
     * @param \Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Relations\Relation $query
     * @param string $field
     *
     * @return \Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Relations\Relation
     */
    protected function buildWhereHas($query, string $field)
    {
        if ($this->logical() === FieldCriteria::OR) {
            return $query->orWhereHas($this->relation(), function ($query) use ($field) {
                $query->where($field, $this->operator(), $this->value());
            });
        }

        return $query->whereHas($this->relation(), function ($query) use ($field) {
            $query->where($field, $this->operator(), $this->value());
        });
    }

    /**
     * Builds "where relation is in xyz" constraint
     *
     * @param \Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Relations\Relation $query
     * @param string $field
     *
     * @return \Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Relations\Relation
     */
    protected function buildWhereRelationIn($query, string $field)
    {
        $value = $this->valueToList($this->value());

        if ($this->logical() === FieldCriteria::OR) {
            return $query->orWhereHas($this->relation(), function ($query) use ($field, $value) {
                $query->whereIn($field, $value);
            });
        }

        return $query->whereHas($this->relation(), function ($query) use ($field, $value) {
            $query->whereIn($field, $value);
        });
    }

    /**
     * Builds "where relation is NOT in xyz" constraint
     *
     * @param \Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Relations\Relation $query
     * @param string $field
     *
     * @return \Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Relations\Relation
     */
    protected function buildWhereRelationNotIn($query, string $field)
    {
        $value = $this->valueToList($this->value());

        if ($this->logical() === FieldCriteria::OR) {
            return $query->orWhereHas($this->relation(), function ($query) use ($field, $value) {
                $query->whereNotIn($field, $value);
            });
        }

        return $query->whereHas($this->relation(), function ($query) use ($field, $value) {
            $query->whereNotIn($field, $value);
        });
    }

    /**
     * Builds "where relation exists..." constraint
     *
     * @param \Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Relations\Relation $query
     *
     * @return \Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Relations\Relation
     */
    protected function buildWhereRelationExists($query)
    {
        if ($this->logical() === FieldCriteria::OR) {
            return $query->orHas($this->relation());
        }

        return $query->has($this->relation());
    }

    /**
     * Builds "where relation does not exists..." constraint
     *
     * @param \Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Relations\Relation $query
     *
     * @return \Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Relations\Relation
     */
    protected function buildWhereRelationDoesNotExists($query)
    {
        if ($this->logical() === FieldCriteria::OR) {
            return $query->orDoesntHave($this->relation());
        }

        return $query->doesntHave($this->relation());
    }

    /**
     * Extract the related field name
     *
     * Method removes evt. table prefix from given field.
     *
     * @param string $field
     *
     * @return string
     */
    protected function extractRelationField(string $field): string
    {
        if (!Str::contains($field, '.')) {
            return $field;
        }

        $parts = explode('.', $field);

        return array_pop($parts);
    }
}
