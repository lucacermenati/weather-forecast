<?php
namespace App\Services\TemperatureConverter;

use App\Enum\Scale;
use App\Exception\ApiException;
use App\Services\TemperatureAdapter\TemperatureConverterInterface;

class TemperatureConverterFactory
{
    private $converters = [];
    
    public function get(string $actualScale, string $desiredScale): TemperatureConverterInterface
    {
        foreach ($this->converters as $converter) {
            if ($converter->canConvert($actualScale, $desiredScale)) {
                return $converter;
            }
        }
        
        throw new ApiException("No coverter found for scales: ". $actualScale . ", " . $desiredScale);
    }
    
    public function addConverter(TemperatureConverterInterface $converter) 
    {
        $this->converters[] = $converter;
    }
}

