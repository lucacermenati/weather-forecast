<?php
namespace App\Services\Cache;

use App\Model\Temperature;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Contracts\Cache\ItemInterface;
use Symfony\Component\Cache\Adapter\ArrayAdapter;

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
        
        if($item && $this->isNotExpired($item)) {
                return $item;
        }
        
        return null;
    }
    
    public function store(Temperature $temperature)
    {
        $temperature->setCreatedDate((new \DateTime("now")));
        $item = self::$cache->getItem($temperature->getCity(). "" .$temperature->getDate());
        $item->set($temperature);
        self::$cache->save($item);
    }
    
    private function isNotExpired($temperature): bool {
        if (new \DateTime($temperature->getCreatedDate()) < (new \DateTime("now"))->add(new \DateInterval("P1M"))) {
            var_dump("not expired");
            return true;
        } else {
            var_dump("expired");
            return false;
        }
    }
}

