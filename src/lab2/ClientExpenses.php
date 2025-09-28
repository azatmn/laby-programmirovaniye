<?php
//require_once 'Tariff.php';
class ClientExpenses
{
    private string $originCity;
    private array $destinationCitiesAndMinutes;

    public function __construct($originCity, $destinationCitiesAndMinutes)
    {
        $this->originCity = $originCity;
        $this->destinationCitiesAndMinutes = $destinationCitiesAndMinutes;
        $this->calculateClientSpending();
    }

    private function calculateClientSpending(): void
    {
        global $cities;
        global $tariffs;
        $price = 0;
        foreach ($this->destinationCitiesAndMinutes as $destinationCityAndMinutes) {
            if ($destinationCityAndMinutes['destinationCity'] == $this->originCity) {
                $pricePerMinute = $tariffs[EnumTariffTypes::Local->value]->getPricePerMinute();
            }
            else if ($cities[$destinationCityAndMinutes['destinationCity']] == $cities[$this->originCity]) {
                $pricePerMinute = $tariffs[EnumTariffTypes::National->value]->getPricePerMinute();
            }
            else {
                $pricePerMinute = $tariffs[EnumTariffTypes::International->value]->getPricePerMinute();
            }
            $price += $pricePerMinute * $destinationCityAndMinutes['minutes'];
        }
        echo "Клиент потратил $price рублей\n";
    }
}