<?php
namespace App\Services\TemperatureConverter;

use App\Model\Temperature;

interface TemperatureConverterInterface
{
    public function canConvert(string $actualScale, string $desiredScale): bool;
    public function convert(Temperature $temperature);
}

