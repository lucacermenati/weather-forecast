<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use App\Model\Prediction;
use App\Model\Temperature;
use App\Exception\ExceptionHandler;
use Symfony\Component\HttpFoundation\Request;

class TemperatureController extends BaseController
{
    public function temperature(Request $request): Response
    {
        try {
            $this->setResponseSucceeded();
        } catch (\Exception $exception) {
//             $this->setResponseFailed(...$exceptionHandler->handle(
//                 $exception
//                 ));
        }
        
        return $this->response;
    }
}

