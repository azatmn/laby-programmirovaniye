<?php
class NewUsername
{
    private string $name;
    public function __construct($name)
    {
        global $users;
        if (empty($name)) {
            throw new InvalidArgumentException(
                "Username can't be empty\n"
            );
        }
        if (in_array($name, getUserNames($users))) {
            throw new InvalidArgumentException(
                "Username $name already exists\n"
            );
        }
        $this->name = $name;
    }
    public function getValue(): string
    {
        return $this->name;
    }
}