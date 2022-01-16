<?php
namespace App\Services\TemperatureClient;

use App\Model\Temperature;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use App\Model\Prediction;

class XmlTemperatureClient extends BaseTemperatureClient implements TemperatureClientInterface
{
    public function createRequest(Temperature $temperature): string
    {
        return __DIR__.'/../../Resources/temps.xml';
    }
    
    public function parseResponse(string $response): Temperature
    {
        $serializer = new Serializer([new ObjectNormalizer()], [new XmlEncoder()]);
        $xml = $serializer->decode($response, "xml");
        
        /** @var Temperature $temperature **/
        $temperature = $serializer->denormalize($xml, Temperature::class);
        $temperature->setScale($xml["@scale"]);
        
        foreach ($xml["prediction"] as $prediction) {
            $temperature->addPrediction(
                $serializer->denormalize($prediction, Prediction::class)
            );
        }
        
        return $temperature;
    }
}

