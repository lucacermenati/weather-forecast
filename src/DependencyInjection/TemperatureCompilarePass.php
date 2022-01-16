<?php
namespace App\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Reference;
use App\Services\TemperatureConverter\TemperatureConverterFactory;
use App\Api\TemperatureApi;

class TemperatureCompilarePass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        $this->loadTaggedServices(TemperatureConverterFactory::class, 'converter', 'addConverter', $container);
        $this->loadTaggedServices(TemperatureApi::class, 'client', 'addClient', $container);
    }
    
    private function loadTaggedServices($definitionClass, $tag, $methodCall, $container)
    {
        if (!$container->has($definitionClass)) {
            return;
        }
        
        $definition = $container->findDefinition($definitionClass);
        
        $taggedServices= $container->findTaggedServiceIds($tag);
        
        foreach ($taggedServices as $id => $tags) {
            $definition->addMethodCall($methodCall, [new Reference($id)]);
        }
    }
}

