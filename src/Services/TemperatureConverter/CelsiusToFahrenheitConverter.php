<?php
namespace App\Services\TemperatureConverter;

use App\Model\Temperature;
use App\Services\TemperatureAdapter\TemperatureConverterInterface;
use App\Enum\Scale;

class CelsiusToFahrenheitConverter implements TemperatureConverterInterface
{
    public function canConvert(string $actualScale, string $desiredScale): bool
    {
        return strtoupper($actualScale) == Scale::CELSIUS
        && strtoupper($desiredScale) == Scale::FAHRENHEIT;
    }

    public function convert(Temperature $temperature)
    {
        $temperature->setScale(Scale::FAHRENHEIT);
        
        /** @var \App\Model\Prediction $prediction **/
        foreach ($temperature->getPredictions() as $prediction) {
            $prediction->setValue(($prediction->getValue() * 9/5) + 32);
        }
    }

}

