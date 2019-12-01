<?php

namespace Aedart\Utils\Helpers;

use Exception;

/**
 * Populate Helper
 *
 * <br />
 *
 * Offers populate (hydrate) utilities.
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Utils\Helpers
 */
class PopulateHelper
{
    /**
     * Checks if given data contains the required properties
     *
     * @param array $data List of key-value pairs. Key = property name
     * @param array $required List of properties that must be present in given data-list
     *
     * @throws Exception If there are too few properties provided or if the required
     *                   properties are not present in the given data array
     */
    public static function verifyRequired(array $data, array $required) : void
    {
        // Check if the provided data has less entries, than the
        // required
        if (count($data) < count($required)) {
            throw new Exception('Cannot populate %s, incorrect amount of properties given');
        }

        // Check that all of the required are present
        foreach ($required as $requiredKey) {
            if( ! isset($data[$requiredKey])){
                throw new Exception(sprintf('Cannot populate, missing %s', $requiredKey));
            }
        }
    }
}
