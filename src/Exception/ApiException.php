<?php
namespace App\Exception;

class ApiException extends \Exception
{
    protected $message;
    protected $statusCode;
    
    public function getStatusCode()
    {
        return $this->statusCode;
    }
    
    public function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;
        return $this;
    }
}

