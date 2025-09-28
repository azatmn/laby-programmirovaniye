<?php
class ATEEarnings
{
    public function __construct()
    {
        $this->calculateEarnings();
    }

    private function calculateEarnings(): void
    {
        global $users;
        global $calls;
        global $tariffs;
        global $cities;
        $price = 0;
        foreach ($calls as $call) {
            $destinationCity = $call->getCity();
            $minutes = $call->getMinutes();
            $originCity = $users[$call->getUsername()]->getCity();
            if ($originCity === $destinationCity) {
                $pricePerMinute = $tariffs[EnumTariffTypes::Local->value]->getPricePerMinute();
            }
            else if ($cities[$originCity] === $cities[$destinationCity]) {
                $pricePerMinute = $tariffs[EnumTariffTypes::National->value]->getPricePerMinute();
            }
            else {
                $pricePerMinute = $tariffs[EnumTariffTypes::International->value]->getPricePerMinute();
            }
            $price += $pricePerMinute * $minutes;
        }
        echo "Мы заработали $price рублей\n";
    }
}