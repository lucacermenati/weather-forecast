<?php
namespace App\Model;

class Temperature
{
    private $scale;
    private $city;
    private $day; //or date
    private $predictions;
    
    public function __construct()
    {
        $this->predictions = [];
    }
    
    public function getScale() 
    {
        return $this->scale;
    }
    
    public function setScale($scale)
    {
        $this->scale = $scale;
        
        return $this;
    }
    
    public function getCity()
    {
        return $this->city;
    }
    
    public function setCity($city)
    {
        $this->city = $city;
        
        return $this;
    }
    
    public function getDay()
    {
        return $this->day;
    }
    
    public function setDay($day)
    {
        $this->day = $day;
        
        return $this;
    }
    
    public function getPredictions()
    {
        return $this->predictions;
    }
    
    public function getPrediction($time)
    {
        foreach ($this->predictions as $prediction) {
            if($time == $prediction->getTime()) {
                return $prediction;
            }
        }
        
        return null;
    }
    
    public function addPrediction($prediction)
    {
        $this->predictions [] = $prediction;
        
        return $this;
    }
}

