<?php
namespace App\Services\TemperatureClient;

use App\Model\Temperature;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Serializer;
use App\Model\Prediction;

class JsonTemperatureClient extends BaseTemperatureClient implements TemperatureClientInterface
{
    public function getTemperature(Temperature $temperature): Temperature
    {
        $response = file_get_contents(__DIR__.'/../../Resources/temps.json', 'r');
        
        $serializer = new Serializer([new ObjectNormalizer()], [new JsonEncoder()]);
        $json = $serializer->decode($response, 'json')["predictions"];
        
        $temperature = new Temperature();
        $temperature->setScale($json["scale"]);
        $temperature->setCity($json["city"]);
        $temperature->setDay($json["date"]);
        
        foreach ($json["prediction"] as $currentPrediction) {
            $prediction = new Prediction();
            $prediction->setTime($currentPrediction["time"]);
            $prediction->setValue($currentPrediction["value"]);
            $temperature->addPrediction($prediction);
        }
        
        return $temperature;
    }  
}

