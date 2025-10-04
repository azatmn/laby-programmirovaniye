<?php
class CityValidator
{
    private string $city;
    public function     __construct(string $city, array $cityNames)
    {
        if (empty($city)) {
            throw new InvalidArgumentException(
                "CityValidator can not be empty\n"
            );
        }
        if (!in_array($city, $cityNames)) {
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