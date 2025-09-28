<?php
require_once 'NewUsername.php';
require_once 'Number.php';
require_once 'City.php';
class Client
{
    private NewUsername $name;
    private Number $number;
    private City $city;

    public function __construct()
    {
        try {
            $this->setName();
            $this->setNumber();
            $this->setCity();
            echo "Клиент успешно добавлен\n" . "\n";
        } catch (Exception $e) {
            echo $e->getMessage() . "\n";
        }
    }

    /**
     * @throws Exception
     */
    private function setName(): void
    {
        $count = 0;
        do {
            $name = (string)readline('Введите имя: ');
            try {
                $this->name = new NewUsername($name);
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
    private function setNumber(): void
    {
        $count = 0;
        do {
            $number = (string)readline('Введите номер телефона: ');
            try {
                $this->number = new Number($number);
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
    private function setCity(): void
    {
        $count = 0;
        global $cities;
        do {
            $city = (string)readline(
                'Введите город проживания (' .
                implode(', ', array_keys($cities)) . '): '
            );
            try {
                $this->city = new City($city);
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