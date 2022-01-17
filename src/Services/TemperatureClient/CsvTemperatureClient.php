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
    public function createRequest(Temperature $temperature): string
    {
        return __DIR__.'/../../Resources/temps.csv';
    }
    
    public function parseResponse(string $response): Temperature
    {
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
                $temperature->setDate($line["date"]);
            }
            
            $temperature->setPrediction($line["prediction__time"], 
                $line["prediction__value"]
            );
        }
        
        return $temperature;
    }
}

