<?php

final class Name
{
    private string $name;

    public function __construct($name)
    {
        if (empty($name)) {
            throw new InvalidArgumentException(
                "'$name' is not a valid name"
            );
        }
        $this->name = $name;
    }

    public function getValue(): string
    {
        return $this->name;
    }
}

final class Price
{
    private float $price;

    public function __construct($price)
    {
        // должно быть числом
        if (!is_numeric($price)) {
            throw new InvalidArgumentException(
                'Price ' . $price . ' must be numeric'
            );
        }
        // цена должна быть > 0
        if ($price <= 0) {
            throw new InvalidArgumentException(
                'Price ' . $price . ' must be greater than 0'
            );
        }
        // проверка на два знака после запятой
        if (round($price, 2) != $price) {
            throw new InvalidArgumentException(
                'Price ' . $price . ' must have at most 2 decimal places'
            );
        }
        $this->price = (float)$price;
    }

    public function getValue(): float
    {
        return $this->price;
    }
}

final class TotalSeats
{
    private int $totalSeats;

    public function __construct($totalSeats)
    {
        if(!is_numeric($totalSeats)){
            throw new InvalidArgumentException(
                'Price ' . $totalSeats . ' must be numeric'
            );
        }
        // должно быть целым числом
        if ((int)$totalSeats != $totalSeats) {
            throw new InvalidArgumentException(
                'Price ' . $totalSeats . ' must be integer'
            );
        }
        // должно быть > 0
        if ($totalSeats <= 0) {
            throw new InvalidArgumentException(
                'Price ' . $totalSeats . ' must be greater than 0'
            );
        }
        $this->totalSeats = (int)$totalSeats;
    }

    public function getValue(): int
    {
        return $this->totalSeats;
    }
}

final class Station
{
    private Name $name;
    private Price $ticketPrice;
    private TotalSeats $totalSeats;
    private int $soldTickets = 0;

    public function __construct()
    {
        try {
            $this->setName();
            $this->setTicketPrice();
            $this->setTotalSeats();
        } catch (Exception $e) {
            echo $e->getMessage();
            exit();
        }
    }

    public function getName(): string
    {
        return $this->name->getValue();
    }

    /**
     * @throws Exception
     */
    public function setName(): void
    {
        $count = 0;
        do {
            $name = (string)readline('Введите название станции: ');
            try {
                $this->name = new Name($name);
                break;
            } catch (InvalidArgumentException $e) {
                echo "\n" . 'Неверно введены данные! Убедитесь что вы ввели не пустое название' . "\n";
                echo $e->getMessage() . "\n";
                $count++;
                if ($count >= 10) {
                    throw new Exception('10 ошибок начинай сначала');
                }
            }
        } while (true);
    }

    /**
     * @throws Exception
     */
    public function setTicketPrice(): void
    {
        $count = 0;
        do {
            $ticketPrice = (string)readline('Введите цену билета: ');
            try {
                $this->ticketPrice = new Price($ticketPrice);
                break;
            } catch (InvalidArgumentException $e) {
                echo "\n" . 'Неверно введены данные! Убедитесь, что вы ввели положительное вещественное число с двумя знаками после запятой' . "\n";
                echo $e->getMessage() . "\n";
                $count++;
                if ($count >= 10) {
                    throw new Exception('10 ошибок начинай сначала');
                }
            }
        } while (true);
    }

    /**
     * @throws Exception
     */
    public function setTotalSeats(): void
    {
        $count = 0;
        do {
            $totalSeats = (string)readline('Введите количество мест: ');
            try {
                $this->totalSeats = new TotalSeats($totalSeats);
                break;
            } catch (InvalidArgumentException $e) {
                echo "\n" . 'Неверно введены данные! Убедитесь, что вы ввели целое число' . "\n";
                echo $e->getMessage() . "\n";
                $count++;
                if ($count >= 10) {
                    throw new Exception('10 ошибок начинай сначала');
                }
            }
        } while (true);
    }

    public function setSoldTickets(int $count): void
    {
        if ($count >= 0 && ($count <= $this->totalSeats->getValue())) {
            $this->soldTickets = $count;
            echo 'Успешно куплено ' . $count . ' билетов' . "\n";
        } else {
            echo 'Ошибка. Доступно мест только ' . $this->totalSeats->getValue() . "\n";
        }
    }

    public function getUnsoldTicketsCost(): float
    {
        return ($this->totalSeats->getValue() - $this->soldTickets) * $this->ticketPrice->getValue();
    }

}

$station = new Station();
$boughtTickets = (int)readline('Введите ');
$station->setSoldTickets($boughtTickets);
echo 'Станция ' . $station->getName() . "\n";
echo "Осталось билетов на сумму: " . $station->getUnsoldTicketsCost() . ' руб' . "\n";