<?php
namespace App\Services\TemperatureClient;

use App\Model\Temperature;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Serializer;
use App\Model\Prediction;

class JsonTemperatureClient extends BaseTemperatureClient implements TemperatureClientInterface
{
    public function createRequest(Temperature $temperature): string
    {
        return __DIR__.'/../../Resources/temps.json';
    }
    
    public function parseResponse(string $response): Temperature
    {
        $serializer = new Serializer([new ObjectNormalizer()], [new JsonEncoder()]);
        $json = $serializer->decode($response, "json")["predictions"];
        
        /** @var Temperature $temperature **/
        $temperature = $serializer->denormalize($json, Temperature::class);
        
        foreach ($json["prediction"] as $prediction) {
            $temperature->addPrediction(
                $serializer->denormalize($prediction, Prediction::class)
            );
        }
        
        return $temperature;
    }
}

