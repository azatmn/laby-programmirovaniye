<?php
class PricePerMinute
{
    private float $pricePerMinute;

    public function __construct($pricePerMinute)
    {
        if (empty($pricePerMinute)) {
            throw new InvalidArgumentException(
                "Price per minute needs to be set\n"
            );
        }
        if (!is_numeric($pricePerMinute)) {
            throw new InvalidArgumentException(
                "Price per minute must be a number\n"
            );
        }
        if (round((float)$pricePerMinute, 2) != $pricePerMinute) {
            throw new InvalidArgumentException(
                "Price per minute must have 2 decimal places\n"
            );
        }
        if ($pricePerMinute <= 0) {
            throw new InvalidArgumentException(
                "Price per minute must be greater than 0\n"
            );
        }
        $this->pricePerMinute = (float)$pricePerMinute;
    }

    public function getValue(): float
    {
        return $this->pricePerMinute;
    }
}