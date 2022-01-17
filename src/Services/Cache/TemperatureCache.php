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
        $itemSearched = self::$cache->get($temperature->getCity(). "" .$temperature->getDate(), function ($item) {
            
        });
        
        /** @var \Symfony\Component\Cache\CacheItem $ItemSearched **/
        if($itemSearched) {
            self::$cache->clear();
            return $itemSearched;
        }
        
        return null;
    }
    
    public function store(Temperature $temperature)
    {
        $item = self::$cache->getItem($temperature->getCity(). "" .$temperature->getDate());
        $item->set($temperature);
        self::$cache->save($item);
        var_dump("STORED!");
    }
}

