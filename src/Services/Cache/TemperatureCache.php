<?php
namespace App\Services\Cache;

use App\Model\Temperature;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Contracts\Cache\ItemInterface;
use Symfony\Component\Cache\Adapter\ArrayAdapter;
use App\Enum\DateTimeFormat;

class TemperatureCache
{
    private static $cache;
    
    public function __construct()
    {
        self::$cache = new FilesystemAdapter();
    }
    
    public function find(Temperature $temperature): ?Temperature
    {
        $item = self::$cache->get($temperature->getCity(). "" .$temperature->getDate(), function ($item) {
            
        });
        
        if($item && $this->isValid($item)) {
            return $item;
        }
        
        return null;
    }
    
    public function store(Temperature $temperature)
    {
        $temperature->setPredictionDate((new \DateTime("now"))->format(DateTimeFormat::FULL_DATE_TIME));
        $item = self::$cache->getItem($temperature->getCity(). "" .$temperature->getDate());
        $item->set($temperature);
        self::$cache->save($item);
    }
    
    public function clear()
    {
        self::$cache->clear();
    }
    
    private function isValid(Temperature $temperature): bool {
        $now = new \DateTime("now");
        $predictionDate = new \DateTime($temperature->getPredictionDate());
        $lastValidDate = $predictionDate->add(new \DateInterval("PT1M"));
        
        return $lastValidDate > $now;
    }
}

