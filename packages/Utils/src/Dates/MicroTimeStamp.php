<?php
namespace Aedart\Utils\Dates;

/**
 * TimeStamp with microseconds resolution.
 *
 * Can hold very large values, but with some limitations:
 *   Years are always 365 days.
 *   Months are always 30 days.
 *
 * @author steffen
 *
 */
class MicroTimeStamp
{
    /**
     * Property to hold minutes.
     *
     * @var int $minutes
     */
    protected $minutes;

    /**
     * Property to hold microseconds
     *
     * @var int $microSeconds
     */
    protected $microSeconds;

    /**
     * Constructor that can populate the timestamp
     *
     * @param int $minutes
     * @param int $microSeconds
     */
    public function __construct(int $minutes=0, int $microSeconds=0)
    {
        $this->minutes = $minutes;
        $this->microSeconds = $microSeconds;
    }

    /**
     * Factory to create from seconds and optional microseconds
     *
     * @param int $seconds
     * @param int $microSeconds
     * @return MicroTimeStamp
     */
    static public function fromSeconds(int $seconds, int $microSeconds=0) : MicroTimeStamp
    {
        return new MicroTimeStamp($seconds / 60, (($seconds % 60) * 1000000) + $microSeconds);
    }

    /**
     * Factory to create from a DateTime object.
     * Time is relative to Unix epoch.
     *
     * @param \DateTime $dt
     * @return MicroTimeStamp
     */
    static public function fromDateTime(\DateTime $dt) : MicroTimeStamp
    {
        list($seconds, $microSeconds) = explode(' ', $dt->format('U u'));

        return MicroTimeStamp::fromSeconds($seconds, $microSeconds);
    }

    /**
     * Factory to create from DateInterval.
     * Only support intervals up to day field.
     *
     * @param \DateInterval $dt
     * @return MicroTimeStamp
     */
    static public function fromDateInterval(\DateInterval $dt) : MicroTimeStamp
    {
        $minutes = ($dt->y * 365 * 24 * 60) + ($dt->m * 30 * 24 * 60) + ($dt->d * 24 * 60) + ($dt->h * 60) + $dt->i + intval($dt->s / 60);
        $microSeconds = intval((($dt->s % 60) + $dt->f) * 1000000);

        if ($dt->invert) {
            $minutes *= -1;
            $microSeconds *= -1;
        }

        return new MicroTimeStamp($minutes, $microSeconds);
    }

    /**
     * Factory to create from seconds with fractions.
     *
     * @param float $seconds
     * @return MicroTimeStamp
     */
    static public function fromSecondsFloat(float $seconds) : MicroTimeStamp
    {
        $minutes = intval($seconds / 60);
        $microSeconds = intval(($seconds * 1000000) % 60000000);

        return new MicroTimeStamp($minutes, $microSeconds);
    }

    /**
     * Get the actual minutes content.
     *
     * @return int
     */
    public function getMinutes() : int
    {
        return $this->minutes;
    }

    /**
     * Get the actual microseconds content.
     * @return int
     */
    public function getMicroSeconds() : int
    {
        return $this->microSeconds;
    }

    /**
     * Get as integer seconds.
     *
     * @return int
     */
    public function getAsSeconds() : int
    {
        return ($this->minutes * 60) + intval($this->microSeconds / 1000000);
    }

    /**
     * Get as float seconds.
     *
     * @return float
     */
    public function getAsSecondsFloat() : float
    {
        return ($this->minutes * 60) + ($this->microSeconds / 1000000);
    }

    /**
     * Get a correctly populated DateInterval.
     *
     * @return \DateInterval
     */
    public function getAsDateInterval() : \DateInterval
    {
        $minutes = abs($this->minutes);
        $microSeconds = abs($this->microSeconds);

        $dt = new \DateInterval('PT0S');
        $dt->y = intval($minutes / (365 * 24 * 60));
        $minutes %= (365 * 24 * 60);

        $dt->m = intval($minutes / (30 * 24 * 60));
        $minutes %= (30 * 24 * 60);

        $dt->d = intval($minutes / (24 * 60));
        $minutes %= (24 * 60);

        $dt->h = intval($minutes / 60);
        $minutes %= 60;

        $dt->i = $minutes;

        $dt->s = intval($microSeconds / 1000000);
        $microSeconds %= 1000000;

        $dt->f = ($microSeconds / 1000000);

        if ($this->minutes < 0 || $this->microSeconds < 0) {
            $dt->invert = 1;
        }

        return $dt;
    }
}
