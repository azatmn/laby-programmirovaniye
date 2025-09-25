<?php
final class TotalSeats
{
    private int $totalSeats;

    public function __construct($totalSeats)
    {
        // должно быть числом
        if(!is_numeric($totalSeats)){
            throw new InvalidArgumentException(
                "Price $totalSeats must be numeric\n"
            );
        }
        // должно быть целым числом
        if ((int)$totalSeats != $totalSeats) {
            throw new InvalidArgumentException(
                "Price $totalSeats must be integer\n"
            );
        }
        // должно быть > 0
        if ($totalSeats <= 0) {
            throw new InvalidArgumentException(
                "Price $totalSeats must be greater than 0\n"
            );
        }
        $this->totalSeats = (int)$totalSeats;
    }

    public function getValue(): int
    {
        return $this->totalSeats;
    }
}