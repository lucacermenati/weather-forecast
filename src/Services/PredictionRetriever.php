<?php
namespace App\Services;

use App\Model\Temperature;
use App\Enum;
use App\Services\TemperatureConverter\TemperatureConverterFactory;
use App\Enum\Scale;
use App\Model\Prediction;
use App\Services\TemperatureClient\TemperatureClientInterface;

class PredictionRetriever
{
    /** @var TemperatureClientInterface[] **/
    private $temperatureClients;
    
    /** @var TemperatureConverterFactory **/
    private $temperatureConverterFactory;
    
    public function __construct(TemperatureConverterFactory $temperatureConverterFactory)
    {
        $this->temperatureConverterFactory = $temperatureConverterFactory;
    }
    
    public function retrieve(Temperature $requestedTemperature)
    {
        $temperatures = [];
        
        foreach ($this->temperatureClients as $client) {
            $currentTemperature = $client->getTemperature($requestedTemperature);
            
            $this->temperatureConverterFactory->get($currentTemperature->getScale(),
                $requestedTemperature->getScale())->convert($currentTemperature);
            
            $temperatures [] = $currentTemperature;
        }
        
        return $this->temperatureReducer->reduce($temperatures);
    }
    
    public function addClient(TemperatureClientInterface $client) 
    {
        $this->temperatureClients [] = $client;    
    }
}

