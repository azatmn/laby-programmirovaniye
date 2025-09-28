<?php
class MinuteChecker
{
    private int $minutes;

    public function __construct($minutes)
    {
        if (empty($minutes)) {
            throw new InvalidArgumentException(
                "Minutes must be set\n"
            );
        }
        if (!is_numeric($minutes)) {
            throw new InvalidArgumentException(
                "Minutes must be numeric\n"
            );
        }
        if ((int)$minutes != $minutes) {
            throw new InvalidArgumentException(
                "Minutes must be integer\n"
            );
        }
        if ((int)$minutes <= 0) {
            throw new InvalidArgumentException(
                "Minutes must be greater than 0\n"
            );
        }
        $this->minutes = (int)$minutes;
    }

    public function getValue(): int
    {
        return $this->minutes;
    }
}