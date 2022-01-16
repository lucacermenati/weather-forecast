<?php
namespace App\Services\TemperatureConverter;

use App\Model\Temperature;
use App\Services\TemperatureAdapter\TemperatureConverterInterface;

class BaseConverter implements TemperatureConverterInterface
{
    public function canConvert(string $actualScale, string $desiredScale): bool
    {
        return $actualScale == $desiredScale;
    }

    public function convert(Temperature $temperature)
    {
        // no conversion.
    }

}

