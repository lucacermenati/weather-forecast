<?php
namespace App\Services\TemperatureClient;

use App\Model\Temperature;
use App\Model\Prediction;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Encoder\CsvEncoder;
use App\Enum\DateTimeFormat;

class CsvTemperatureClient extends BaseTemperatureClient implements TemperatureClientInterface
{
    public function getTemperature(Temperature $requestedTemperature): Temperature
    {
        $response = file_get_contents(__DIR__.'/../../Resources/temps.csv', 'r');
        
        $serializer = new Serializer([new ObjectNormalizer()], [new CsvEncoder()]);
        $csv = $serializer->decode($response, 'csv');
        
        $temperature = new Temperature();
        
        foreach ($csv as $line) {
            if($line["scale"]) {
                $temperature->setScale($line["scale"]);
            }
            
            if($line["city"]) {
                $temperature->setCity($line["city"]);
            }
            
            if($line["date"]) {
                $temperature->setDay((new \DateTime($line["date"]))->format(DateTimeFormat::DATE));
            }
            
            $prediction = new Prediction();
            $prediction->setTime((new \DateTime($line["prediction__time"]))->format(DateTimeFormat::TIME));
            $prediction->setValue((int) $line["prediction__value"]);
            
            $temperature->addPrediction($prediction);
        }
        
        return $temperature;
    }
}

