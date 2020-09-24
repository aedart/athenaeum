<?php

namespace Aedart\Utils\Dates;


/**
 * Duration class to handle time intervals with microsecond precision.
 *
 * Needed because DateInterval has not so funny quirks.
 *
 * @author steffen
 *
 */
class Duration
{

    /**
     *
     * @var MicroTimeStamp $microTimeStamp
     */
    protected $microTimeStamp;


    /**
     * Create instance from either a DateTime, a DateInterval, a MicroTimeStamp or integer seconds
     *
     * @param mixed $time
     * @return self
     */
    static public function from($interval)
    {
        return new static($interval);
    }

    /**
     * Create instance from time string.
     *
     * @param string $timeStr
     * @return self
     */
    static public function fromString(string $timeStr) : self
    {
        return new static(strtotime($timeStr));
    }

    /**
     * Create instance from integer seconds
     *
     * @param int $seconds
     * @return self
     */
    static public function fromSeconds(int $seconds) : self
    {
        return new static($seconds);
    }

    /**
     * Create instance from integer minutes and optional microseconds.
     *
     * @param int $minutes
     * @param int $microSeconds
     * @return self
     */
    static public function fromMinutes(int $minutes, int $microSeconds=0) : self
    {
        return new static(new MicroTimeStamp($minutes, $microSeconds));
    }

    /**
     * Create instance from difference of two DateTime objects.
     *
     * @param \DateTime $start
     * @param \DateTime $stop
     * @return self
     */
    static public function fromDifference(\DateTime $start, \DateTime $stop) : self
    {
        return new static($start->diff($stop));
    }

    /**
     * Constructor that can take a DateTime, a DateInterval, a MicroTimeStamp or integer seconds
     *
     * @param mixed|null $time
     */
    public function __construct($time=null)
    {
        if ($time instanceof \DateTime) {
            $this->microTimeStamp = MicroTimeStamp::fromDateTime($time);
        }
        elseif ($time instanceof \DateInterval) {
            $this->microTimeStamp = MicroTimeStamp::fromDateInterval($time);
        }
        elseif ($time instanceof MicroTimeStamp) {
            $this->microTimeStamp = $time;
        }
        elseif (is_integer($time)) {
            $this->microTimeStamp = MicroTimeStamp::fromSeconds($time);
        }
    }

    public function start()
    {
        $this->microTimeStamp = MicroTimeStamp::fromDateTime(new \DateTime());
    }

    public function stop()
    {
        $stop = MicroTimeStamp::fromDateTime(new \DateTime());

        $this->microTimeStamp = MicroTimeStamp::fromSecondsFloat($stop->getAsSecondsFloat() - $this->microTimeStamp->getAsSecondsFloat());
    }

    /**
     * Add another Duration to this.
     *
     * @param Duration $duration
     * @return self
     */
    public function add(Duration $duration) : self
    {
        $this->microTimeStamp = MicroTimeStamp::fromSecondsFloat($this->microTimeStamp->getAsSecondsFloat() + $duration->asFloatSeconds());

        return $this;
    }

    /**
     * Subtract another Duration from this.
     *
     * @param Duration $duration
     * @return self
     */
    public function subtract(Duration $duration) : self
    {
        $this->microTimeStamp = MicroTimeStamp::fromSecondsFloat($this->microTimeStamp->getAsSecondsFloat() - $duration->asFloatSeconds());

        return $this;
    }

    /**
     * Return duration as integer seconds.
     *
     * @return int
     */
    public function asSeconds() : int
    {
        return $this->microTimeStamp->getAsSeconds();
    }

    /**
     * Return duration as decimal seconds.
     *
     * @return float
     */
    public function asFloatSeconds() : float
    {
        return $this->microTimeStamp->getAsSecondsFloat();
    }

    /**
     * Return duration as integer minutes.
     *
     * @return int
     */
    public function asMinutes() : int
    {
        return intval($this->microTimeStamp->getAsSeconds() / 60);
    }

    /**
     * Same as \DateInterval::format().
     *
     * @see \DateInterval::format()
     *
     * @param string $format
     * @return string
     */
    public function format(string $format) : string
    {
        return $this->microTimeStamp->getAsDateInterval()->format($format);
    }
}
