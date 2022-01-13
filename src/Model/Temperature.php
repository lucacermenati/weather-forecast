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
    
    public function getPrediction($index)
    {
        return $this->predictions[$index];
    }
    
    public function addPrediction($prediction)
    {
        $this->predictions [] = $prediction;
        
        return $this;
    }
}

