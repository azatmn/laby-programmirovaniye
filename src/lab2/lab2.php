<?php
require_once 'Call.php';
require_once 'Client.php';
require_once 'Tariff.php';
require_once 'ClientExpenses.php';
require_once 'ATEEarnings.php';

enum EnumTariffTypes: string
{
    case Local = 'Местный';
    case National = 'Междугородний';
    case International = 'Международный';
}
function getUsernames (array $users): array
{
    $names = [];
    foreach ($users as $user) {
        $names[] = $user->getName();
    }
    return $names;
}
function getNumbers (array $users): array
{
    $numbers = [];
    foreach ($users as $user) {
        $numbers[] = $user->getNumber();
    }
    return $numbers;
}

$cities = [
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
$users = array();
$tariffs = array();
$calls = array();

do {
    echo "1. Добавить клиента\n" .
        "2. Настроить тарифы\n" .
        "3. Совершить звонок\n" .
        "4. Посчитать сколько денег потратил денег клиент\n" .
        "5. Посчитать сколько АТС заработала\n" .
        "0. Выход\n\n";

    $input = readline();

    if ($input == 0) {
        break;
    }

    if ($input == 1) {
        $client = new Client();
        $users[$client->getName()] = $client;
    }

    if ($input == 2) {
        $tariffs = array();
        foreach (EnumTariffTypes::cases() as $tariffType) {
            $tariffs[$tariffType->value] = new Tariff($tariffType->value);
        }
    }

    if ($input == 3) {
        if (empty($users)) {
            echo "Вы не создали ни одного пользователя\n";
        }
        else if (empty($tariffs)) {
            echo "Вы не настроили тарифы\n";
        }
        else {
            $calls[] = new Call();
        }
        echo "\n";
    }

    if ($input == 4) {
        if (empty($calls)) {
            echo "Совершите хотя бы один звонок\n" . "\n";
            continue;
        }

        $count = 0;
        do {
            $username = (string)readline(
                'Введите имя клиента (' .
                implode(', ', getUsernames($users)) . '): '
            );
            try {
                new UsernameCall($username);
                break;
            } catch (Exception $e) {
                $count++;
                if ($count >= 10) {
                    echo "10 ошибок начинай сначала\n";
                    continue 2;
                }
            }
        } while(true);

        $destinationCitiesAndMinutes = array();
        foreach ($calls as $call) {
            if ($call->getUsername() === $username) {
                $destinationCitiesAndMinutes[] =
                    ['destinationCity' => $call->getCity(), 'minutes' => $call->getMinutes()];
            }
        }

        $originCity = '';
        foreach ($users as $user) {
            if ($user->getName() === $username) {
                $originCity = $user->getCity();
                break;
            }
        }
        new ClientExpenses($originCity, $destinationCitiesAndMinutes);
        echo "\n";
    }

    if ($input == 5) {
        new ATEEarnings();
        echo "\n";
    }

    else {
        echo "Попробуйте еще раз\n\n";
    }

} while (true);