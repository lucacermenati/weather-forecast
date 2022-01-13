<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Enum\HttpStatusCode;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BaseController extends AbstractController
{
    /** @var Response **/
    protected $response;
    
    public function setResponseSucceeded($content = null)
    {
        if(!$content) {
            $content = new \stdClass();
        }
        
        $content = $this->normalize($content);
        $content["success"] = true;
        
        $this->response = new JsonResponse($content, 
            HttpStatusCode::SUCCESS,[
                "Content-Type" => "application/json"
            ]
        );
    }
    
    public function setResponseFailed($message, $statusCode)
    {
        $this->response = new JsonResponse([
            "success" => false,
            "message" => $message,
        ], [
            "Content-Type" => "application/json"
        ], $statusCode);
    }
    
    private function normalize($object) {
        $reflectionClass = new \ReflectionClass(get_class($object));
        $array = array();
        
        foreach ($reflectionClass->getProperties() as $property) {
            $property->setAccessible(true);
            
            if(is_array($property->getValue($object))) {
                foreach ($property->getValue($object) as $element) {
                    $array[$property->getName()] [] = $this->normalize($element);
                }
            } elseif (is_object($property->getValue($object))) {
                $array[$property->getName()] = $this->normalize($element);
            } else {
                $array[$property->getName()] = $property->getValue($object);
            }
            
            $property->setAccessible(false);
        }
        
        return $array;
    }
}

