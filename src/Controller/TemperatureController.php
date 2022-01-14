<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use App\Model\Prediction;
use App\Model\Temperature;
use App\Exception\ExceptionHandler;
use Symfony\Component\HttpFoundation\Request;
use App\Exception\ApiException;
use App\Enum\Scale;
use App\Services\PredictionRetriever;
use App\Services\TemperatureRequestValidator;
use App\ParamConverter\TemperatureParameterConverter;

class TemperatureController extends BaseController
{
    public function temperature(
        Request $request,
        TemperatureRequestValidator $requestValidator,
        TemperatureParameterConverter $parameterConverter,
        PredictionRetriever $predictionRetriever,
        ExceptionHandler $exceptionHandler
    ): Response
    {
        try {
            $requestValidator->validate($request);
            $temperature = $parameterConverter->convert($request);
            
            $this->setResponseSucceeded($predictionRetriever->retrieve($temperature));
        } catch (\Exception $exception) {
//             $this->setResponseFailed(...$exceptionHandler->handle(
//                 $exception
//             ));
            throw $exception;
        }
        
        return $this->response;
    }
}

