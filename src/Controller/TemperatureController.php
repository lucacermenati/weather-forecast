<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use App\Model\Prediction;
use App\Model\Temperature;
use App\Exception\ExceptionHandler;
use Symfony\Component\HttpFoundation\Request;
use App\Exception\ApiException;
use App\Services\TemperaturePredictor;
use App\Enum\Scale;

class TemperatureController extends BaseController
{
    public function temperature(
        Request $request,
        TemperaturePredictor $temperaturePredictor,
        ExceptionHandler $exceptionHandler
    ): Response
    {
        try {
            $this->setResponseSucceeded($temperaturePredictor->predict(
                "Amsterdam",
                new \DateTime(),
                Scale::FAHRENHEIT
            ));
        } catch (\Exception $exception) {
            $this->setResponseFailed(...$exceptionHandler->handle(
                $exception
            ));
        }
        
        return $this->response;
    }
}

