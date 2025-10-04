<?php
require_once 'ValueObjects/CallValueObject.php';
require_once 'ValueObjects/ClientValueObject.php';
require_once 'ValueObjects/TariffValueObject.php';
require_once 'TariffTypeEnum.php';
require_once 'ClientExpenses.php';
require_once 'ATEEarnings.php';
class Scenarios
{
    private static array $cities = [
        'Moscow' => 'Russia',
        'Saint-Petersburg' => 'Russia',
        'Kazan' => 'Russia',
        'Dubai' => 'United Arab Emirates',
        'Tokyo' => 'Japan',
        'Paris' => 'France',
        'Berlin' => 'Germany',
        'London' => 'United Kingdom',
        'NewYork' => 'United States',
        'Miami' => 'United States',
        'SanFrancisco' => 'United States'
    ];
    private static array $users = [];
    private static array $tariffs = [];
    private static array $calls = [];

    private static function getNumbers (): array
    {
        $numbers = [];
        foreach (self::$users as $user) {
            $numbers[] = $user->getNumber();
        }
        return $numbers;
    }


//    /**
//     * @param TariffValueObject[] $tariffs
//     * @return array
//     */
    private static function getTariffsPrice(): array
    {
        $tariffAndPrice = array();
        foreach (self::$tariffs as $tariff) {
            $tariffAndPrice[$tariff->getName()] = $tariff->getPricePerMinute();
        }
        return $tariffAndPrice;
    }

    //    /**
//     * @param CallValueObject[] $calls
//     * @param ClientValueObject[] $users
//     * @return array
//     */
    private static function buildDestinationMinutesArray(string $userName = ''): array
    {
        $destinationCitiesAndMinutes = array();
        foreach (self::$calls as $call) {
            if ($userName === '') {
                $destinationCitiesAndMinutes[] =
                    ['destinationCity' => $call->getCity(), 'minutes' => $call->getMinutes(),
                        'originCity' => self::$users[$call->getUserName()]->getCity()];
            }
            else if ($call->getUserName() === $userName) {
                $destinationCitiesAndMinutes[] =
                    ['destinationCity' => $call->getCity(), 'minutes' => $call->getMinutes()];
            }
        }
        return $destinationCitiesAndMinutes;
    }

    public static function addClient(): void
    {
        $client = new ClientValueObject(array_keys(self::$users), self::getNumbers(), array_keys(self::$cities));
        self::$users[$client->getName()] = $client;
    }

    /**
     * @throws Exception
     */
    public static function addTariff(): void
    {
        foreach (TariffTypeEnum::cases() as $tariffType) {
            self::$tariffs[$tariffType->value] = new TariffValueObject($tariffType->value);
        }
    }

    public static function addCall(): void
    {
        try {
            if (empty(self::$users)) {
                throw new Exception("Вы не создали ни одного пользователя\n");
            }
            if (empty(self::$tariffs)) {
                throw new Exception("Вы не настроили тарифы\n");
            }
        } catch (Exception $exception) {
            echo $exception->getMessage();
            return;
        }
        self::$calls[] = new CallValueObject(array_keys(self::$users), array_keys(self::$cities));
        echo "\n";
    }

    public static function clientSpending(): void
    {
        try {
            if (empty(self::$calls)) {
                throw new Exception("Совершите хотя бы один звонок\n" . "\n");
            }
        } catch (Exception $exception) {
            echo $exception->getMessage();
            return;
        }

        $count = 0;
        do {
            $userName = (string)readline(
                'Введите имя клиента (' .
                implode(', ', array_keys(self::$users)) . '): '
            );
            try {
                new UserNameCallValidator($userName, array_keys(self::$users));
                break;
            } catch (Exception $e) {
                $count++;
                if ($count >= 10) {
                    echo "10 ошибок начинай сначала\n";
                    return;
                }
            }
        } while (true);

        $destinationCitiesAndMinutes = self::buildDestinationMinutesArray($userName);

        $originCity = '';
        foreach (self::$users as $user) {
            if ($user->getName() === $userName) {
                $originCity = $user->getCity();
                break;
            }
        }
        ClientExpenses::calculateClientSpending($originCity,
            $destinationCitiesAndMinutes, self::$cities, self::getTariffsPrice());
        echo "\n";
    }

    public static function ATEEarnings(): void
    {
        ATEEarnings::calculateEarnings(self::buildDestinationMinutesArray(),
            self::getTariffsPrice(), self::$cities);
        echo "\n";
    }

    public static function incorrectInput(): void
    {
        echo "Попробуйте еще раз\n\n";
    }

}