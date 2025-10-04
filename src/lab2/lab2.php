<?php
require_once 'Scenarios.php';

do {
    echo "1. Добавить клиента\n" .
        "2. Настроить тарифы\n" .
        "3. Совершить звонок\n" .
        "4. Посчитать сколько денег потратил денег клиент\n" .
        "5. Посчитать сколько АТС заработала\n" .
        "0. Выход\n\n";

    $input = readline();

    match ($input) {
        '0' => exit(),
        '1' => Scenarios::addClient(),
        '2' => Scenarios::addTariff(),
        '3' => Scenarios::addCall(),
        '4' => Scenarios::clientSpending(),
        '5' => Scenarios::ATEearnings(),
        default => Scenarios::incorrectInput()
    };

} while (true);