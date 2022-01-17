<?php

use App\Api\TemperatureApi;
use App\Services\Cache\TemperatureCache;
use App\Services\TemperatureConverter\TemperatureConverterFactory;
use App\Services\Reducer\TemperatureReducer;
use App\Model\Temperature;
use App\Services\TemperatureClient\TemperatureClientInterface;
use App\Enum\Scale;
use App\Services\TemperatureConverter\TemperatureConverterInterface;

/**
 * TemperatureApi test case.
 */
class TemperatureApiTest extends PHPUnit\Framework\TestCase
{
    /** @var TemperatureApi **/
    private $temperatureApi;
    
    /** @var TemperatureCache **/
    private $temperatureCacheMock;
    
    /** @var TemperatureConverterFactory **/
    private $temperatureConverterFactoryMock;
    
    /** @var TemperatureReducer **/
    private $temperatureReducerMock;
    
    /** @var TemperatureClientInterface **/
    private $firstClientMock;
    
    /** @var TemperatureClientInterface **/
    private $secondClientMock;

    protected function setUp(): void
    {
        $this->temperatureCacheMock = $this->createMock(TemperatureCache::class);
        $this->temperatureConverterFactoryMock = $this->createMock(TemperatureConverterFactory::class);
        $this->temperatureReducerMock = $this->createMock(TemperatureReducer::class);
        
        $this->temperatureApi = new TemperatureApi(
            $this->temperatureCacheMock,
            $this->temperatureConverterFactoryMock,
            $this->temperatureReducerMock
        );
        
        $this->firstClientMock = $this->createMock(TemperatureClientInterface::class);
        $this->secondClientMock = $this->createMock(TemperatureClientInterface::class);
        $this->temperatureApi->addClient($this->firstClientMock);
        $this->temperatureApi->addClient($this->secondClientMock);
    }

    protected function tearDown(): void
    {
        $this->temperatureApi = null;
    }

    public function testGetPredictionFromCache()
    {   
        $requestedTemperature = new Temperature();
        $requestedTemperature->setCity("Amsterdam")
            ->setDate("20220101")
            ->setScale(Scale::FAHRENHEIT);
        
        $temperature = new Temperature();
        $temperature->setCity("Amsterdam")
            ->setDate("20220101")
            ->setScale(Scale::CELSIUS);
        
        $converterMock = $this->createMock(TemperatureConverterInterface::class);
        
        $this->temperatureCacheMock->expects($this->once())
            ->method('find')
            ->willReturn($temperature);
        
        $this->temperatureConverterFactoryMock->expects($this->once())
            ->method('get')
            ->with(Scale::CELSIUS, Scale::FAHRENHEIT)
            ->willReturn($converterMock);
        
        $converterMock->expects($this->once())
            ->method('convert')
            ->with($temperature);
        
        $result = $this->temperatureApi->getPrediction($requestedTemperature);
        
        $this->assertEquals($temperature, $result);
    }
    
    public function testGetPredictionFromClients()
    {
        $requestedTemperature = new Temperature();
        $requestedTemperature->setCity("Amsterdam")
            ->setDate("20220101")
            ->setScale(Scale::FAHRENHEIT);
        
        $temperature = new Temperature();
        $temperature->setCity("Amsterdam")
            ->setDate("20220101")
            ->setScale(Scale::CELSIUS);
        
        $temperature2 = new Temperature();
        $temperature2->setCity("Amsterdam")
            ->setDate("20220101")
            ->setScale(Scale::CELSIUS);
        
        $reducedTemperature = new Temperature();
        $reducedTemperature->setCity("Amsterdam")
            ->setDate("20220101")
            ->setScale(Scale::FAHRENHEIT);
    
        $converterMock = $this->createMock(TemperatureConverterInterface::class);
        
        $this->temperatureCacheMock->expects($this->once())
        ->method('find')
        ->willReturn(null);
        
        $this->firstClientMock->expects($this->once())
            ->method('getPrediction')
            ->with($requestedTemperature)
            ->willReturn($temperature);
        
        $this->secondClientMock->expects($this->once())
            ->method('getPrediction')
            ->with($requestedTemperature)
            ->willReturn($temperature2);
        
        $this->temperatureConverterFactoryMock->expects($this->exactly(2))
            ->method('get')
            ->with(Scale::CELSIUS, Scale::FAHRENHEIT)
            ->willReturn($converterMock);
        
        $converterMock->expects($this->exactly(2))
            ->method('convert')
            ->withConsecutive([$temperature], [$temperature2]);
        
        $this->temperatureReducerMock->expects($this->once())
            ->method('avg')
            ->with([
                $temperature,
                $temperature2
            ])
            ->willReturn($reducedTemperature);
        
        $result = $this->temperatureApi->getPrediction($requestedTemperature);
        
        $this->assertEquals($reducedTemperature, $result);
    }
}

