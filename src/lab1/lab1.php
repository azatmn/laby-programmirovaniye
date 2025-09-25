<?php

require_once 'Name.php';
require_once 'Price.php';
require_once 'TotalSeats.php';
require_once 'BoughtTickets.php';
require_once 'Station.php';

$station = new Station();

$boughtTickets = new BoughtTickets();
echo "\n";

$station->setSoldTickets($boughtTickets->getValue());
echo 'Станция ' . $station->getName() . "\n";
echo 'Осталось билетов на сумму: ' . $station->getUnsoldTicketsCost() . 'руб' . "\n";