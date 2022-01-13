<?php
namespace App\Services\TemperatureAdapter;

use App\Model\Temperature;

interface TemperatureConverterInterface
{
    public function canConvert(string $actualScale, string $desiredScale): bool;
    public function convert(Temperature $temperature);
}

