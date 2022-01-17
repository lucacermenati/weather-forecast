<?php

use App\Services\TemperatureConverter\CelsiusToFahrenheitConverter;
use App\Enum\Scale;
use App\Model\Temperature;
use App\Model\Prediction;

/**
 * CelsiusToFahrenheitConverter test case.
 */
class CelsiusToFahrenheitConverterTest extends PHPUnit\Framework\TestCase
{
    /** @var CelsiusToFahrenheitConverter **/
    private $celsiusToFahrenheitConverter;

    protected function setUp(): void
    {
        $this->celsiusToFahrenheitConverter = new CelsiusToFahrenheitConverter();
    }

    protected function tearDown(): void
    {
        $this->celsiusToFahrenheitConverter = null;
    }

    /**
     * @dataProvider scalesDataProvider
     */
    public function testCanConvert($actualScale, $desiredScale, $canConvert)
    {
        $result = $this->celsiusToFahrenheitConverter->canConvert($actualScale, $desiredScale);
        $this->assertEquals($canConvert, $result);
    }
    
    public function scalesDataProvider()
    {
        return [
            [Scale::CELSIUS, Scale::FAHRENHEIT, true],
            [Scale::CELSIUS, Scale::CELSIUS, false],
        ];
    }

    public function testConvert()
    {
        $temperature = new Temperature();
        $temperature->setScale(Scale::CELSIUS)
            ->setPrediction("0:0", 0);
        
        $this->celsiusToFahrenheitConverter->convert($temperature);
        
        $this->assertEquals(Scale::FAHRENHEIT, $temperature->getScale());
        $this->assertEquals(32, $temperature->getPrediction("0:0")->getValue());
    }
}

