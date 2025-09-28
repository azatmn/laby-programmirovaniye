<?php
require 'PricePerMinute.php';
class Tariff
{
//    private int $id;
    private string $name;
    private PricePerMinute $pricePerMinute;

    public function __construct($name)
    {
        $this->name = $name;
        try {
            $this->setPricePerMinute();
            echo "Тариф успешно добавлен\n" . "\n";
        } catch (Exception $e) {
            echo $e->getMessage() . "\n";
        }
    }

    /**
     * @throws Exception
     */
    private function setPricePerMinute(): void
    {
        $count = 0;
        do {
            $pricePerMinute = (string)readline(
                "Введите цену за минуту для тарифа '$this->name': "
            );
            try {
                $this->pricePerMinute = new PricePerMinute($pricePerMinute);
                break;
            } catch (InvalidArgumentException $e) {
                echo $e->getMessage() . "\n";
                $count++;
                if ($count >= 10) {
                    throw new Exception("10 ошибок начинай сначала\n");
                }
            }
        } while(true);
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPricePerMinute(): float
    {
        return $this->pricePerMinute->getValue();
    }
}