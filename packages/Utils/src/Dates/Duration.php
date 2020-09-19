<?php

namespace Aedart\Utils\Dates;


class Duration
{
    /**
     * @var \DateInterval
     */
    protected $duration;

    static public function from($time) : self {
        return new static($time);
    }

    public function __construct($time) {
        
        if ($time instanceof \DateTime) {
            $dt = new \DateTime("@0");
            $this->duration = $dt->diff($time);
        }
        elseif ($time instanceof \DateInterval) {
            $this->duration = $time;
        }
        elseif (is_integer($time)) {
            $this->duration = new \DateInterval("PT$timeS");
        }
    }
}
