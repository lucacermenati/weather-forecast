<?php
namespace App\Model;

class Prediction
{
    /** @SerializedName time **/
    private $time; //or datetime
    private $value;
    
    public function getTime()
    {
        return $this->time;
    }
    
    public function setTime($time)
    {
        $this->time = $time;
        
        return $this;
    }
    
    public function getValue()
    {
        return $this->value;
    }
    
    public function setValue($value)
    {
        $this->value = $value;
        
        return $this;
    }
}

