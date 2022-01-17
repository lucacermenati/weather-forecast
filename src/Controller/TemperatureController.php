<?php
namespace App\Controller;

use App\Exception\ExceptionHandler;
use App\ParamConverter\TemperatureParameterConverter;
use App\Api\TemperatureApi;
use App\Services\Validator\TemperatureRequestValidator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class TemperatureController extends BaseController
{
    public function temperature(
        Request $request,
        TemperatureRequestValidator $requestValidator,
        TemperatureParameterConverter $parameterConverter,
        TemperatureApi $temperatureApi,
        ExceptionHandler $exceptionHandler
    ): Response
    {
        try {
            $requestValidator->validate($request);
            $temperature = $parameterConverter->convert($request);
            
            $this->setResponseSucceeded(
                $temperatureApi->getPrediction($temperature)
            );
        } 
        catch (\Exception $exception) {
//             $this->setResponseFailed(
//                 ...$exceptionHandler->handle($exception)
//             );
                throw $exception;
        }
        
        return $this->response;
    }
}

