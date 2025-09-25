<?php
final class BoughtTickets
{
    private int $boughtTickets;

    public function __construct()
    {
        try {
            $this->setBoughtTickets();
        } catch (Exception $e) {
            echo $e->getMessage();
            exit();
        }
    }

    /**
     * @throws Exception
     */
    public function setBoughtTickets(): void
    {
        $count = 0;
        do {
            $boughtTickets = (string)readline('Сколько билетов хотите купить: ');
            try{
                $this->checkBoughtTickets($boughtTickets);
                $this->boughtTickets = (int)$boughtTickets;
                break;
            } catch (InvalidArgumentException $e) {
                echo "\n" . 'Неверно введены данные! Убедитесь, что вы ввели целое положительное число' . "\n";
                echo $e->getMessage() . "\n";
                $count++;
                if ($count >= 10) {
                    throw new Exception("10 ошибок начинай сначала\n");
                }
            }
        } while(true);
    }
    public function checkBoughtTickets($boughtTickets): void
    {
        // должно быть числом
        if(!is_numeric($boughtTickets)) {
            throw new InvalidArgumentException(
                "Price $boughtTickets must be numeric\n"
            );
        }
        // должно быть целым числом
        if ((int)$boughtTickets != $boughtTickets) {
            throw new InvalidArgumentException(
                "Price  $boughtTickets must be integer\n"
            );
        }
        // должно быть > 0
        if ($boughtTickets <= 0) {
            throw new InvalidArgumentException(
                "Price $boughtTickets must be greater than 0\n"
            );
        }
    }
    public function getValue(): int
    {
        return $this->boughtTickets;
    }
}