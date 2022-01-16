<?php
namespace App\Services\TemperatureClient;

use App\Model\Temperature;
use Symfony\Component\HttpFoundation\Request;

abstract class BaseTemperatureClient implements TemperatureClientInterface
{
    public function sendRequest(string $request): string
    {
        return file_get_contents($request, 'r');
    }
    
    public function getPrediction(Temperature $temperature): Temperature
    {
        $request = $this->createRequest($temperature);
        $response = $this->sendRequest($request);
        
        return $this->parseResponse($response);
    }
}

