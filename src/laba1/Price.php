<?php
final class Price
{
    private float $price;

    public function __construct($price)
    {
        // должно быть числом
        if (!is_numeric($price)) {
            throw new InvalidArgumentException(
                "Price $price must be numeric\n"
            );
        }
        // цена должна быть > 0
        if ($price <= 0) {
            throw new InvalidArgumentException(
                "Price $price must be greater than 0\n"
            );
        }
        // проверка на два знака после запятой
        if (round($price, 2) != $price) {
            throw new InvalidArgumentException(
                "Price $price must have at most 2 decimal places\n"
            );
        }
        $this->price = (float)$price;
    }

    public function getValue(): float
    {
        return $this->price;
    }
}