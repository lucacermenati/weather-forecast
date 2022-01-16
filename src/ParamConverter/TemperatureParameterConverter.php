<?php
namespace App\ParamConverter;

use Symfony\Component\HttpFoundation\Request;
use App\Model\Temperature;

class TemperatureParameterConverter
{
    public function convert(Request $request): Temperature
    {
        $temperature = new Temperature();
        $temperature->setCity($request->get('city'));
        $temperature->setDate($request->get('date'));
        $temperature->setScale($request->get('scale'));
        
        return $temperature;
    }
}

