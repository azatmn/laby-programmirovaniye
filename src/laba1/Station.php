<?php
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
                    throw new Exception("10 ошибок начинай сначала\n");
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
                    throw new Exception("10 ошибок начинай сначала\n");
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
                echo "\n" . 'Неверно введены данные! Убедитесь, что вы ввели целое положительное число' . "\n";
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