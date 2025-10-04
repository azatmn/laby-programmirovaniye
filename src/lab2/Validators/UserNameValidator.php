<?php
class UserNameValidator
{
    private string $name;
    public function __construct(string $name, array $userNames)
    {
        if (empty($name)) {
            throw new InvalidArgumentException(
                "Username can't be empty\n"
            );
        }
        if (in_array($name, $userNames)) {
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