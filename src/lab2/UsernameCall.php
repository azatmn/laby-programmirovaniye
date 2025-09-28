<?php
class UsernameCall
{
    private string $name;

    /**
     * @throws Exception
     */
    public function __construct($name)
    {
        if (empty($name)) {
            throw new InvalidArgumentException(
                "Name can not be empty\n"
            );
        }
        global $users;
        if (!in_array($name, getUserNames($users))) {
            throw new InvalidArgumentException(
                "There is no such user\n"
            );
        }
        $this->name = $name;
    }

    public function getValue(): string
    {
        return $this->name;
    }
}