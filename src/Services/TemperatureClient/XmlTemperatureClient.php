<?php
namespace App\Services\TemperatureClient;

use App\Model\Temperature;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use App\Model\Prediction;

class XmlTemperatureClient extends BaseTemperatureClient implements TemperatureClientInterface
{
    public function getTemperature(Temperature $temperature): Temperature
    {
        $response = file_get_contents(__DIR__.'/../../Resources/temps.xml', 'r');
        
        $serializer = new Serializer([new ObjectNormalizer()], [new XmlEncoder()]);
        $xml = $serializer->decode($response, 'xml');
        
        $temperature = new Temperature();
        $temperature->setScale($xml["@scale"]);
        $temperature->setCity($xml["city"]);
        $temperature->setDay($xml["date"]);
        
        foreach ($xml["prediction"] as $currentPrediction) {
            $prediction = new Prediction();
            $prediction->setTime($currentPrediction["time"]);
            $prediction->setValue($currentPrediction["value"]);
            $temperature->addPrediction($prediction);
        }
        
        return $temperature;
    }
}

