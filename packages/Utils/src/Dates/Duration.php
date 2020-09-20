<?php

namespace Aedart\Utils\Dates;


class Duration
{
    /**
     * @var \DateInterval
     */
    protected $duration;

    static public function from($time) : self
    {
        return new static($time);
    }

    static public function fromString(string $timeStr) : self
    {
        return new static(strtotime($timeStr));
    }

    static public function fromSeconds(int $seconds) : self
    {
        return new static($seconds);
    }

    static public function fromDifference(\DateTime $start, \DateTime $stop) : self
    {
        return new static($start->diff($stop));
    }

    public function __construct($time)
    {

        if ($time instanceof \DateTime) {
            $dt = new \DateTime("@0");
            $this->duration = $dt->diff($time);
        }
        elseif ($time instanceof \DateInterval) {
            $this->duration = $time;
        }
        elseif (is_integer($time)) {
            $this->duration = new \DateInterval("PT{$time}S");
        }
    }

    /**
     * @see \DateInterval::format()
     *
     * @param string $format
     * @return string
     */
    public function format(string $format) : string
    {
        return $this->duration->format($format);
    }
}
