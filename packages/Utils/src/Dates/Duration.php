<?php

namespace Aedart\Utils\Dates;


/**
 * Duration class to easen usage of the DateInterval class.
 *
 * @author steffen
 *
 */
class Duration
{
    /**
     * Note:
     *  The DateInterval object is a bit funny:
     *   It has internal properties for year, month, day, hours, minutes, seconds and microseconds.
     *   They are populated as one would expect if instantiated from a DateTime or DateTime->diff() call.
     *   But if instantiated from seconds, all seconds are simply put into the seconds property.
     *   E.g. dd(new \DateInterval('PT4200S'));
     *   The same will happen if instatiated from any other direct value.
     * @var \DateInterval
     */
    protected $duration;

    /**
     * Create instance from either a DateTime, a DateInterval or integer seconds
     *
     * @param mixed $time
     * @return self
     */
    static public function from($time) : self
    {
        return new static($time);
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
     * Constructor that cane take a DateTime, a DateInterval or integer seconds
     *
     * @param mixed|null $time
     */
    public function __construct($time=null)
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
     * Add another Duration to this.
     *
     * @param Duration $duration
     * @return self
     */
    public function add(Duration $duration) : self
    {
        $temp = new \DateTime('@0');
        $temp->add($this->duration);

        $temp->add($duration->duration);

        $this->duration = $temp->diff(new \DateTime('@0'));

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
        $temp = new \DateTime('@0');
        $temp->add($this->duration);

        $duration->duration->invert = 1;
        $temp->add($duration->duration);

        $this->duration = $temp->diff(new \DateTime('@0'));

        return $this;
    }

    /**
     * Return duration as integer seconds.
     *
     * @return int
     */
    public function asSeconds() : int
    {
        return (($this->duration->d * 24 * 3600)
            + ($this->duration->h * 3600)
            + ($this->duration->i * 60)
            + ($this->duration->s));
    }

    /**
     * Return duration as decimal seconds.
     *
     * @return float
     */
    public function asFloatSeconds() : float
    {
        return $this->asSeconds() + $this->duration->f;
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
