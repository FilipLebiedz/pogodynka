<?php

namespace App\Tests\Entity;

use App\Entity\Forcast;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class MeasurementTest extends TestCase
{
    public static function dataGetFahrenheit(): array
    {
        return [
            ['0', '32'],
            ['-100', '-148'],
            ['100', '212'],
            ['0.5', '32.9'],
            ['10', '50'],
            ['25', '77'],
            ['54', '129.20'],
            ['55.5', '131.90'],
            ['93.33', '200'],
            ['90', '194'],
        ];
    }

    #[DataProvider('dataGetFahrenheit')]
    public function testGetFahrenheit(string $celsius, string $expectedFahrenheit): void
    {
        $f = new Forcast();
        $f->setTemperature((float) $celsius);

        $this->assertEquals( (float) $expectedFahrenheit, $f->getFahrenheit());
    }
}