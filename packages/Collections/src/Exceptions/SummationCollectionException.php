<?php

namespace Aedart\Collections\Exceptions;

use Aedart\Contracts\Collections\Exceptions\SummationCollectionException as SummationCollectionExceptionInterface;
use RuntimeException;

/**
 * Summation Collection Exception
 *
 * @see \Aedart\Contracts\Collections\Exceptions\SummationCollectionException
 * 
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Collections\Exceptions
 */
class SummationCollectionException extends RuntimeException implements SummationCollectionExceptionInterface
{

}
