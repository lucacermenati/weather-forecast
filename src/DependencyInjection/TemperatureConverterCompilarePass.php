<?php
namespace App\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Reference;
use App\Services\TemperatureConverter\TemperatureConverterFactory;

class TemperatureConverterCompilarePass implements CompilerPassInterface 
{
    public function process(ContainerBuilder $container)
    {
        if (!$container->has(TemperatureConverterFactory::class)) {
            return;
        }
        
        $definition = $container->findDefinition(TemperatureConverterFactory::class);
        
        $taggedServices= $container->findTaggedServiceIds('converter');
        
        foreach ($taggedServices as $id => $tags) {
            // add the transport service to the TransportChain service
            $definition->addMethodCall('addConverter', [new Reference($id)]);
        }
    }
}

