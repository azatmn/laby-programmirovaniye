<?php
require_once __DIR__ . '/../Validators/UserNameCallValidator.php';
require_once __DIR__ . '/../Validators/CityValidator.php';
require_once __DIR__ . '/../Validators/MinuteValidator.php';
class CallValueObject
{
    private UserNameCallValidator $userName;
    private CityValidator $city;
    private MinuteValidator $minutes;

    public function __construct(array $userNames, array $cityNames)
    {
        try {
            $this->setUserName($userNames);
            $this->setCity($cityNames);
            $this->setMinutes();
            echo "Звонок успешно совершен\n";
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    /**
     * @throws Exception
     */
    private function setUserName($userNames): void
    {
        $count = 0;
        do {
            $userName = (string)readline(
                'Введите пользователя, совершающего звонок (' .
                implode(', ', $userNames) . '): '
            );
            try {
                $this->userName = new UserNameCallValidator($userName, $userNames);
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
                "Выбирете город, в который хотите позвонить \n(" .
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

    /**
     * @throws Exception
     */
    private function setMinutes(): void
    {
        $count = 0;
        do {
            $minutes = (string)readline('Введите сколько минут будет идти звонок: ');
            try {
                $this->minutes = new MinuteValidator($minutes);
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

    public function getUserName(): string
    {
        return $this->userName->getValue();
    }

    public function getCity(): string
    {
        return $this->city->getValue();
    }

    public function getMinutes(): int
    {
        return $this->minutes->getValue();
    }
}