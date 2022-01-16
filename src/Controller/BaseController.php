<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Enum\HttpStatusCode;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;

class BaseController extends AbstractController
{
    /** @var Response **/
    protected $response;
    
    /** @var Serializer **/
    protected $serializer;
    
    public function __construct()
    {
        $this->serializer = new Serializer([new ObjectNormalizer()], [new JsonEncoder()]);
    }
    
    public function setResponseSucceeded($content = [])
    {
        $content = $this->serializer->normalize($content);
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
        ], $statusCode,
        [
            "Content-Type" => "application/json"
        ]);
    }
}

