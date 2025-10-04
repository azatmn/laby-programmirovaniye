<?php
require_once __DIR__ . '/../Validators/PricePerMinuteValidator.php';
class TariffValueObject
{
    private string $name;
    private PricePerMinuteValidator $pricePerMinute;

    /**
     * @throws Exception
     */
    public function __construct($name)
    {
        $this->setName($name);
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

    private function setName($name): void {
        $this->name = $name;
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
                $this->pricePerMinute = new PricePerMinuteValidator($pricePerMinute);
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