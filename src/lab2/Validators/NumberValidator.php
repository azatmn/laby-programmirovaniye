<?php
class NumberValidator
{
    private string $number;
    public function __construct(string $number, array $numbers)
    {
        if (empty($number)) {
            throw new InvalidArgumentException(
                "NumberValidator can't be empty\n"
            );
        }
        if (!ctype_digit($number)) {
            throw new InvalidArgumentException(
                "number $number does not exist\n"
            );
        }
        if (in_array($number, $numbers)) {
            throw new InvalidArgumentException(
                "NumberValidator $number already exists\n"
            );
        }
        $this->number = $number;
    }

    public function getValue(): string
    {
        return $this->number;
    }
}