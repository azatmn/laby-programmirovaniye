<?php
final class Name
{
    private string $name;

    public function __construct($name)
    {
        if (empty($name)) {
            throw new InvalidArgumentException(
                "'$name' is not a valid name\n"
            );
        }
        $this->name = $name;
    }

    public function getValue(): string
    {
        return $this->name;
    }
}