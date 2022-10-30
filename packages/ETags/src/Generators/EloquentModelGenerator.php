<?php

namespace Aedart\ETags\Generators;

use Aedart\Utils\Json;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;
use JsonException;
use LogicException;

/**
 * Eloquent Model ETag Generator
 *
 * Able to generate ETags for an Eloquent Model.
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\ETags\Generators
 */
class EloquentModelGenerator extends BaseGenerator
{
    /**
     * @inheritDoc
     *
     * @throws JsonException
     */
    public function resolveContent(mixed $content): string
    {
        if (!($content instanceof Model)) {
            throw new LogicException('Content must be instance of Eloquent model.');
        }

        return implode('_', [
            $this->resolveModelName($content),
            $this->resolveModelIdentifier($content),
            $this->resolveAttributes($content, $this->attributes())
        ]);
    }

    /**
     * Returns a name that represents the model
     *
     * @param  Model  $model
     *
     * @return string E.g. table name
     */
    protected function resolveModelName(Model $model): string
    {
        return $model->getTable();
    }

    /**
     * Returns model's primary key value
     *
     * @param  Model  $model
     *
     * @return string Empty string if model has no identifier
     */
    protected function resolveModelIdentifier(Model $model): string
    {
        $identifier = $model->getKey();

        if (!isset($identifier)) {
            return '';
        }

        return (string) $identifier;
    }

    /**
     * Resolves attributes from given model
     *
     * @param  Model  $model
     * @param  string[]  $attributes List of attribute names
     *
     * @return string
     *
     * @throws JsonException
     */
    protected function resolveAttributes(Model $model, array $attributes): string
    {
        if (empty($attributes)) {
            return '';
        }

        $resolved = [];
        foreach ($attributes as $attribute) {
            $resolved[] = $this->resolveAttribute($attribute, $model);
        }

        return implode('_', $resolved);
    }

    /**
     * Resolve attribute from model
     *
     * @param  string  $attribute Attribute name
     * @param  Model  $model
     *
     * @return string
     *
     * @throws JsonException
     */
    protected function resolveAttribute(string $attribute, Model $model): string
    {
        $value = $model[$attribute];

        return match ($value) {
            empty($value) => '',
            $value instanceof DateTimeInterface => $value->format(DateTimeInterface::RFC3339),
            is_array($value) => Json::encode($value),
            default => (string) $value,
        };
    }

    /**
     * Returns list of attributes to use from model
     *
     * @return string[]
     */
    protected function attributes(): array
    {
        return $this->options['attributes'] ?? [];
    }
}