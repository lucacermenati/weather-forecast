<?php
namespace App\Services;

use Symfony\Component\HttpFoundation\Request;
use App\Exception\ApiException;
use App\Enum\HttpStatusCode;

class TemperatureRequestValidator
{
    public function validate(Request $request)
    {
        $this->validateNotNull($request);
        $this->validateDay($request->get('date'));
    }
        
    private function validateNotNull(Request $request)
    {
        if(! $request->get('city')) {
            throw new ApiException("Missing mandatory parameter 'city'", HttpStatusCode::BAD_REQUEST);
        }
        
        if(! $request->get('date')) {
            throw new ApiException("Missing mandatory parameter 'date'", HttpStatusCode::BAD_REQUEST);
        }
    }
    
    private function validateDay(string $day)
    {
        $date = new \DateTime($day);
        $today = new \DateTime('today');
        
        if ($date < $today) {
            throw new ApiException("Can't fetch predictions for a day in the past", HttpStatusCode::BAD_REQUEST);
        }
        
        if ($date > $today->add(new \DateInterval('P10D'))) {
            throw new ApiException("Can't fetch predictions for more than 10 days in the future", HttpStatusCode::BAD_REQUEST);
        }
    }
}

