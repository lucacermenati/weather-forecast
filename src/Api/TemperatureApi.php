<?php
namespace App\Api;

use App\Model\Temperature;
use App\Services\TemperatureClient\TemperatureClientInterface;
use App\Services\TemperatureConverter\TemperatureConverterFactory;
use App\Services\Reducer\TemperatureReducer;
use App\Services\Cache\TemperatureCache;

class TemperatureApi
{
    /** @var TemperatureCache **/
    private $temperatureCache;
    
    /** @var TemperatureConverterFactory **/
    private $temperatureConverterFactory;
    
    /** @var TemperatureReducer **/
    private $temperatureReducer;
    
    /** @var TemperatureClientInterface[] **/
    private $temperatureClients;
    
    public function __construct(
        TemperatureCache $temperatureCache,
        TemperatureConverterFactory $temperatureConverterFactory,
        TemperatureReducer $temperatureReducer
    ) {
        $this->temperatureCache = $temperatureCache;
        $this->temperatureConverterFactory = $temperatureConverterFactory;
        $this->temperatureReducer = $temperatureReducer;
    }
    
    public function getPrediction(Temperature $requestedTemperature)
    {
        if($temperature = $this->temperatureCache->find($requestedTemperature)) {
            $this->temperatureConverterFactory->get($temperature->getScale(),
                $requestedTemperature->getScale())->convert($temperature);
            
            return $temperature;
        }
        
        $temperature = $this->getTemperature($requestedTemperature);
        $this->temperatureCache->store($temperature);
        
        return $temperature;
    }
    
    private function getTemperature(Temperature $requestedTemperature)
    {
        $temperatures = [];
        
        foreach ($this->temperatureClients as $client) {
            $currentTemperature = $client->getPrediction($requestedTemperature);
            
            $this->temperatureConverterFactory->get($currentTemperature->getScale(),
                $requestedTemperature->getScale())->convert($currentTemperature);
                
                $temperatures [] = $currentTemperature;
        }
        
        $temperature = $this->temperatureReducer->avg($temperatures);
        
        //This is just because date is static on the files, in a real life situtation won't be there.
        $temperature->setDate($requestedTemperature->getDate());
        
        return $temperature;
    }
    
    public function addClient(TemperatureClientInterface $client) 
    {
        $this->temperatureClients [] = $client;    
    }
}

