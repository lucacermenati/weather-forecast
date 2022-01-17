<?php
namespace App\Services\Reducer;

use App\Model\Temperature;

class TemperatureReducer
{
    private $times = [
        "00:00", "01:00", "02:00", "03:00", "04:00", "05:00", "06:00",
        "07:00", "08:00", "09:00", "10:00",
    ];
    
    public function avg($temperatures)
    {
        $previous = null;
        $times = $this->times;
        $length = count($temperatures);
        return array_reduce($temperatures, function ($previous, $current) use ($length, $times) {
            /** @var Temperature $previous **/
            /** @var Temperature $current **/
            foreach ($times as $time) {
                $current->setPrediction($time,
                    ($previous == null ? 0 : $previous->getPrediction($time)->getValue()) + 
                        $current->getPrediction($time)->getValue()/$length
                );
            }
             
            return $current;
        }, $previous);
    }
}

