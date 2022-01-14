<?php
namespace App\Services\TemperatureClient;

use App\Model\Temperature;

interface TemperatureClientInterface
{
    public function getTemperature(Temperature $temperature): Temperature;
}

