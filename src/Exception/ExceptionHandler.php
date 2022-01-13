<?php
namespace App\Exception;

use App\Enum\HttpStatusCode;

class ExceptionHandler
{
    public function handle(\Exception $exception)
    {
        if ($exception instanceof ApiException) {
            return [
                $exception->getMessage(),
                $exception->getStatusCode(),
            ];
        }
        
        return [
            "An unexpected error has occurred :" . $exception->getMessage(),
            HttpStatusCode::BAD_REQUEST,
        ];
    }
}

