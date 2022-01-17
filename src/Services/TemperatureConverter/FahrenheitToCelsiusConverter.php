<?php
namespace App\Services\TemperatureConverter;

use App\Model\Temperature;
use App\Enum\Scale;

class FahrenheitToCelsiusConverter implements TemperatureConverterInterface
{
    public function canConvert(string $actualScale, string $desiredScale): bool
    {
        return $actualScale == Scale::FAHRENHEIT
            && $desiredScale == Scale::CELSIUS;
    }

    public function convert(Temperature $temperature)
    {
        $temperature->setScale(Scale::FAHRENHEIT);
        
        /** @var \App\Model\Prediction $prediction **/
        foreach ($temperature->getPredictions() as $prediction) {
            $prediction->setValue(($prediction->getValue()-32) * 5/9);
        }
    }

}

