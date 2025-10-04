<?php
require_once __DIR__ . '/../Validators/UserNameValidator.php';
require_once __DIR__ . '/../Validators/NumberValidator.php';
require_once __DIR__ . '/../Validators/CityValidator.php';
class ClientValueObject
{
    private UserNameValidator $name;
    private NumberValidator $number;
    private CityValidator $city;

    public function __construct(array $userNames, array $numbers, array $cityNames)
    {
        try {
            $this->setName($userNames);
            $this->setNumber($numbers);
            $this->setCity($cityNames);
            echo "Клиент успешно добавлен\n" . "\n";
        } catch (Exception $e) {
            echo $e->getMessage() . "\n";
        }
    }

    /**
     * @throws Exception
     */
    private function setName($userNames): void
    {
        $count = 0;
        do {
            $name = (string)readline('Введите имя: ');
            try {
                $this->name = new UserNameValidator($name, $userNames);
                break;
            } catch (InvalidArgumentException $e) {
                echo $e->getMessage();
                $count++;
                if ($count >= 10) {
                    throw new Exception("10 ошибок начинай сначала\n");
                }
            }
        } while (true);
    }

    /**
     * @throws Exception
     */
    private function setNumber($numbers): void
    {
        $count = 0;
        do {
            $number = (string)readline('Введите номер телефона: ');
            try {
                $this->number = new NumberValidator($number, $numbers);
                break;
            } catch (InvalidArgumentException $e) {
                echo $e->getMessage();
                $count++;
                if ($count >= 10) {
                    throw new Exception("10 ошибок начинай сначала\n");
                }
            }
        } while (true);
    }

    /**
     * @throws Exception
     */
    private function setCity($cityNames): void
    {
        $count = 0;
        do {
            $city = (string)readline(
                'Введите город проживания (' .
                implode(', ', $cityNames) . '): '
            );
            try {
                $this->city = new CityValidator($city, $cityNames);
                break;
            } catch (InvalidArgumentException $e) {
                echo $e->getMessage();
                $count++;
                if ($count >= 10) {
                    throw new Exception("10 ошибок начинай сначала\n");
                }
            }
        } while (true);
    }

    public function getName(): string
    {
        return $this->name->getValue();
    }

    public function getCity(): string
    {
        return $this->city->getValue();
    }

    public function getNumber(): string
    {
        return $this->number->getValue();
    }

}