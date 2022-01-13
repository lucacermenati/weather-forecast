<?php
namespace App\Services;

use App\Model\Temperature;
use App\Enum;
use App\Services\TemperatureConverter\TemperatureConverterFactory;
use App\Enum\Scale;
use App\Model\Prediction;

class TemperaturePredictor
{
    private $temperatureClients;
    
    /** @var TemperatureConverterFactory **/
    private $temperatureConverterFactory;
    
    public function __construct(TemperatureConverterFactory $temperatureConverterFactory)
    {
        $this->temperatureConverterFactory = $temperatureConverterFactory;
    }
    
    public function predict(string $city, \DateTime $date, string $scale): Temperature
    {
        $currentTemperature = new Temperature();
        $currentTemperature->setScale(Scale::CELSIUS);
        
        $prediction = new Prediction();
        $prediction->setValue(0);
        
        $currentTemperature->addPrediction($prediction);
        
        $this->temperatureConverterFactory->get($currentTemperature->getScale(),
            $scale)->convert($currentTemperature);
        
        return $currentTemperature;
    }
    
//     public function prediction(string $city, \DateTime $date, string $scale): Temperature
//     {
//         $adapter = AdapterFactory::create($scale);
        
//         array_reduce(array_map(function ($client) use ($adapter) {
//             //map function
//             return $this->adapter->adapt($client->getTemperature());
//         }, $this->temperatureClients), 
//         function ($temperature) use ($this->temperatureReducer) {
//             //reduce function
//             return $this->temperatureReducer->avg($temperature, $currentTemperature);
//         });
//     }
}

