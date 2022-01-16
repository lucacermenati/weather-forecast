<?php
namespace App\Api;

use App\Model\Temperature;
use App\Services\TemperatureClient\TemperatureClientInterface;
use App\Services\TemperatureConverter\TemperatureConverterFactory;
use App\Services\Reducer\TemperatureReducer;

class TemperatureApi
{
    /** @var TemperatureClientInterface[] **/
    private $temperatureClients;
    
    /** @var TemperatureConverterFactory **/
    private $temperatureConverterFactory;
    
    /** @var TemperatureReducer **/
    private $temperatureReducer;
    
    public function __construct(
        TemperatureConverterFactory $temperatureConverterFactory,
        TemperatureReducer $temperatureReducer
    ) {
        $this->temperatureConverterFactory = $temperatureConverterFactory;
        $this->temperatureReducer = $temperatureReducer;
    }
    
    public function getPrediction(Temperature $requestedTemperature)
    {
        $temperatures = [];
        
        foreach ($this->temperatureClients as $client) {
            $currentTemperature = $client->getPrediction($requestedTemperature);
            
            $this->temperatureConverterFactory->get($currentTemperature->getScale(),
                $requestedTemperature->getScale())->convert($currentTemperature);
            
            $temperatures [] = $currentTemperature;
        }
        
        return $this->temperatureReducer->avg($temperatures);
    }
    
    public function addClient(TemperatureClientInterface $client) 
    {
        $this->temperatureClients [] = $client;    
    }
}

