<?php

namespace Aedart\Http\Api\Requests\Concerns;

use Illuminate\Contracts\Validation\Validator;

/**
 * Concerns Pagination
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Http\Api\Requests\Concerns
 */
trait Pagination
{
    /**
     * The current page to shown
     *
     * @var int
     */
    public int $page;

    /**
     * The amount of results to be shown per page
     *
     * @var int
     */
    public int $show;

    /**
     * Default page to be shown when none requested
     *
     * @var int
     */
    protected int $defaultPage = 1;

    /**
     * Default amount of results to be shown,
     * when none requested
     *
     * @var int
     */
    protected int $defaultShow = 15;

    /**
     * Minimum allowed value for {@see show}
     *
     * @var int
     */
    protected int $showMinimum = 1;

    /**
     * Maximum allowed value for {@see show}
     *
     * @var int
     */
    protected int $showMaximum = 100;

    /**
     * Name of the query parameter that contains requested page
     *
     * @see \Illuminate\Database\Eloquent\Builder::paginate
     * @see \Illuminate\Database\Eloquent\Builder::simplePaginate
     *
     * @var string
     */
    protected string $pageKey = 'page';

    /**
     * Name of the query parameter that contains requested amount
     * to be shown per page
     *
     * @var string
     */
    protected string $showKey = 'show';

    /**
     * Adds pagination rules for given validation rules
     *
     * @param  array  $rules  [optional]
     *
     * @return array
     */
    public function withPagination(array $rules = []): array
    {
        return array_merge($this->paginationValidationRules(), $rules);
    }

    /**
     * Validation rules for pagination
     *
     * @return array
     */
    public function paginationValidationRules(): array
    {
        $show = "digits_between:{$this->showMinimum},{$this->showMaximum}";

        return [
            $this->pageKey => ['nullable', 'integer', 'min:1'],
            $this->showKey => ['nullable', 'integer', $show]
        ];
    }

    /**
     * Prepare the pagination values
     *
     * @param  Validator  $validator
     *
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function preparePagination(Validator $validator): void
    {
        $data = $validator->validated();

        $this->page = $data[$this->pageKey] ?? $this->defaultPage;
        $this->show = $data[$this->showKey] ?? $this->defaultShow;
    }
}
