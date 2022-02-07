<?php

namespace Aedart\Contracts\Redmine;

use Countable;
use IteratorAggregate;

/**
 * Traversable Results
 *
 * @template T
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Contracts\Redmine
 */
interface TraversableResults extends IteratorAggregate,
    Countable
{
}
