<?php

use App\Services\Validator\TemperatureRequestValidator;
use Symfony\Component\HttpFoundation\Request;
use App\Enum\Scale;
use App\Exception\ApiException;

/**
 * TemperatureRequestValidator test case.
 */
class TemperatureRequestValidatorTest extends PHPUnit\Framework\TestCase
{
    /** @var TemperatureRequestValidator */
    private $temperatureRequestValidator;

    protected function setUp(): void
    {
         $this->temperatureRequestValidator = new TemperatureRequestValidator();
    }

    protected function tearDown(): void
    {
        $this->temperatureRequestValidator = null;
    }

    public function testDaysInThePastThrowException()
    {
        $request = new Request();
        $request->attributes->set("date", "2000101");
        $request->attributes->set("city", "Amsterdam");
        $request->attributes->set("scale", Scale::FAHRENHEIT);
        
        $this->expectException(ApiException::class);

        $this->temperatureRequestValidator->validate($request);
    }
}

