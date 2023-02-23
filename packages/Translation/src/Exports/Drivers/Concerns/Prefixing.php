<?php

namespace Aedart\Translation\Exports\Drivers\Concerns;

/**
 * Concerns Prefixing
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Translation\Exports\Drivers\Concerns
 */
trait Prefixing
{
    /**
     * Prefix each group with given namespace
     *
     * @param string[] $groups
     * @param string $namespace [optional]
     *
     * @return string[]
     */
    protected function prefixGroups(array $groups, string $namespace = ''): array
    {
        if (empty($namespace) || empty($groups)) {
            return $groups;
        }

        return array_map(function ($group) use ($namespace) {
            return $this->prefixGroup($group, $namespace);
        }, $groups);
    }

    /**
     * Prefix group with given namespace
     *
     * @param string $group
     * @param string $namespace [optional]
     *
     * @return string
     */
    protected function prefixGroup(string $group, string $namespace = ''): string
    {
        if (empty($namespace)) {
            return $group;
        }

        $separator = $this->prefixSeparator();

        return "{$namespace}{$separator}{$group}";
    }

    /**
     * Returns a namespace prefix separator
     *
     * @return string
     */
    protected function prefixSeparator(): string
    {
        // Use same kind of namespacing as shown in Laravel's documentation.
        // @see https://laravel.com/docs/10.x/packages#language-files
        return '::';
    }

    /**
     * Removes wildcard namespace prefix from group
     *
     * @param string $group
     *
     * @return string
     */
    protected function removeWildcardPrefix(string $group): string
    {
        $prefix = '*' . $this->prefixSeparator();
        if (str_starts_with($group, $prefix)) {
            return str_replace($prefix, '', $group);
        }

        return $group;
    }
}
