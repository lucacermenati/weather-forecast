<?php
namespace App\Controller;

use App\Exception\ExceptionHandler;
use App\ParamConverter\TemperatureParameterConverter;
use App\Api\TemperatureApi;
use App\Services\Validator\TemperatureRequestValidator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Services\Cache\TemperatureCache;

class TemperatureCacheController extends BaseController
{
    public function clear(
        TemperatureCache $temperatureCache,
        ExceptionHandler $exceptionHandler
    ): Response
    {
        try {
            $this->setResponseSucceeded(
                $temperatureCache->clear()
            );
        } 
        catch (\Exception $exception) {
            $this->setResponseFailed(
                ...$exceptionHandler->handle($exception)
            );
                throw $exception;
        }
        
        return $this->response;
    }
}

