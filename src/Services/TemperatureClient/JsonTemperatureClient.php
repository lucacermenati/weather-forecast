<?php
namespace App\Services\TemperatureClient;

use App\Model\Temperature;

class JsonTemperatureClient extends BaseTemperatureClient implements TemperatureClientInterface
{
    public function getTemperature(Temperature $temperature): Temperature
    {
        
    }  
}

