<?php
class Number
{
    private string $number;
    public function __construct($number)
    {
        if (empty($number)) {
            throw new InvalidArgumentException(
                "Number can't be empty\n"
            );
        }
        if (!ctype_digit($number)) {
            throw new InvalidArgumentException(
                "number $number does not exist\n"
            );
        }
        global $users;
        if (in_array($number, getNumbers($users))) {
            throw new InvalidArgumentException(
                "Number $number already exists\n"
            );
        }
        $this->number = $number;
    }

    public function getValue(): string
    {
        return $this->number;
    }
}