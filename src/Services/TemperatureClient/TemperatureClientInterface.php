<?php
namespace App\Services\TemperatureClient;

use App\Model\Temperature;

interface TemperatureClientInterface
{
    public function createRequest(Temperature $temperature): string;
    public function sendRequest(string $request): string;
    public function parseResponse(string $response): Temperature;
    public function getPrediction(Temperature $temperature): Temperature;
}

