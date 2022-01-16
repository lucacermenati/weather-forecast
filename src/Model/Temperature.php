<?php
namespace App\Model;

class Temperature
{
    private $scale;
    private $city;
    private $date;
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
    
    public function getDate()
    {
        return $this->date;
    }
    
    public function setDate($date)
    {
        $this->date = $date;
        
        return $this;
    }
    
    public function getPredictions()
    {
        return $this->predictions;
    }
    
    public function setPredictions($predictions)
    {
        $this->predictions = $predictions;
        
        return $this;
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

