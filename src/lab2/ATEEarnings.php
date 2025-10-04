<?php
class ATEEarnings
{
    public static function  calculateEarnings(array $destinationCitiesAndMinutes,
                                              array $tariffs, array $cities): void
    {
        $price = 0;
        foreach ($destinationCitiesAndMinutes as $destinationCityAndMinutes) {
            $destinationCity = $destinationCityAndMinutes['destinationCity'];
            $minutes = $destinationCityAndMinutes['minutes'];
            $originCity = $destinationCityAndMinutes['originCity'];
            if ($originCity === $destinationCity) {
                $pricePerMinute = $tariffs[TariffTypeEnum::Local->value];
            }
            else if ($cities[$originCity] === $cities[$destinationCity]) {
                $pricePerMinute = $tariffs[TariffTypeEnum::National->value];
            }
            else {
                $pricePerMinute = $tariffs[TariffTypeEnum::International->value];
            }
            $price += $pricePerMinute * $minutes;
        }
        echo "Мы заработали $price рублей\n";
    }
}