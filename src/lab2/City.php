<?php
class City
{
    private string $city;
    public function __construct($city)
    {
        if (empty($city)) {
            throw new InvalidArgumentException(
                "City can not be empty\n"
            );
        }
        global $cities;
        if (!in_array($city, array_keys($cities))) {
            throw new InvalidArgumentException(
                "$city is not a valid city\n"
            );
        }
        $this->city = $city;
    }

    public function getValue(): string
    {
        return $this->city;
    }
}