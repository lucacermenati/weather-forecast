<?php
namespace App\Services\TemperatureClient;

use App\Model\Temperature;

class XmlTemperatureClient extends BaseTemperatureClient implements TemperatureClientInterface
{
    public function getTemperature(Temperature $temperature): Temperature
    {
        
    }
}

