<?php
class ClientExpenses
{
    static public function calculateClientSpending(string $originCity, array $destinationCitiesAndMinutes,
                                                   array $cities, array $tariffs): void
    {
        $price = 0;
        foreach ($destinationCitiesAndMinutes as $destinationCityAndMinutes) {
            if ($destinationCityAndMinutes['destinationCity'] === $originCity) {
                $pricePerMinute = $tariffs[TariffTypeEnum::Local->value];
            }
            else if ($cities[$destinationCityAndMinutes['destinationCity']] === $cities[$originCity]) {
                $pricePerMinute = $tariffs[TariffTypeEnum::National->value];
            }
            else {
                $pricePerMinute = $tariffs[TariffTypeEnum::International->value];
            }
            $price += $pricePerMinute * $destinationCityAndMinutes['minutes'];
        }
        echo "Клиент потратил $price рублей\n";
    }
}