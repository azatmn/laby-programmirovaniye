<?php
class UserNameCallValidator
{
    private string $name;

    /**
     * @throws Exception
     */
    public function __construct(string $name, array $userNames)
    {
        if (empty($name)) {
            throw new InvalidArgumentException(
                "Name can not be empty\n"
            );
        }
        if (!in_array($name, $userNames)) {
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