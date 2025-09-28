<?php
require_once 'UsernameCall.php';
require_once 'City.php';
require_once 'MinuteChecker.php';
class Call
{
    private UsernameCall $username;
    private City $city;
    private MinuteChecker $minutes;

    public function __construct()
    {
        try {
            $this->setUsername();
            $this->setCity();
            $this->setMinutes();
            echo "Звонок успешно совершен\n";
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    /**
     * @throws Exception
     */
    private function setUsername(): void
    {
        $count = 0;
        global $users;
        do {
            $username = (string)readline(
                'Введите пользователя, совершающего звонок (' .
                implode(', ', getUsernames($users)) . '): '
            );
            try {
                $this->username = new UsernameCall($username);
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
        global $cities;
        $count = 0;
        do {
            $city = (string)readline(
                "Выбирете город, в который хотите позвонить \n(" .
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

    /**
     * @throws Exception
     */
    private function setMinutes(): void
    {
        $count = 0;
        do {
            $minutes = (string)readline('Введите сколько минут будет идти звонок: ');
            try {
                $this->minutes = new MinuteChecker($minutes);
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

    public function getUsername(): string
    {
        return $this->username->getValue();
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