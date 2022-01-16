<?php

namespace App;

use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use App\DependencyInjection\TemperatureCompilarePass;

class Kernel extends BaseKernel
{
    use MicroKernelTrait;
    
    protected function build(ContainerBuilder $container): void
    {
        $container->addCompilerPass(new TemperatureCompilarePass());
    }
}
