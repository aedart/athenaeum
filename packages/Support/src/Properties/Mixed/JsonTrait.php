<?php

namespace Aedart\Support\Properties\Mixed;

/**
 * @deprecated Since v4.0, please use \Aedart\Support\Properties\Mixes\JsonTrait instead
 *
 * Json Trait
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Mixed
 */
trait JsonTrait
{
    /**
     * JavaScript Object Notation (JSON)
     *
     * @var mixed|null
     */
    protected $json = null;

    /**
     * Set json
     *
     * @param mixed|null $json JavaScript Object Notation (JSON)
     *
     * @return self
     */
    public function setJson($json)
    {
        $this->json = $json;

        return $this;
    }

    /**
     * Get json
     *
     * If no "json" value set, method
     * sets and returns a default "json".
     *
     * @see getDefaultJson()
     *
     * @return mixed|null json or null if no json has been set
     */
    public function getJson()
    {
        if (!$this->hasJson()) {
            $this->setJson($this->getDefaultJson());
        }
        return $this->json;
    }

    /**
     * Check if "json" has been set
     *
     * @return bool True if "json" has been set, false if not
     */
    public function hasJson(): bool
    {
        return isset($this->json);
    }

    /**
     * Get a default "json" value, if any is available
     *
     * @return mixed|null Default "json" value or null if no default value is available
     */
    public function getDefaultJson()
    {
        return null;
    }
}
