<?php


namespace Shyim\StructGenerator\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Shyim\StructGenerator\Examples\Advanced\Advanced;
use Shyim\StructGenerator\Examples\Advanced\LifecycleStatus;
use Shyim\StructGenerator\Examples\Simple\Address;
use Shyim\StructGenerator\Examples\Simple\Simple;

class GeneratedStructsTest extends TestCase
{
    public function testStructSimple()
    {
        $json = json_decode(file_get_contents(__DIR__ . '/../../examples/json/simple.json'));

        $class = Simple::map($json);

        $this->assertInstanceOf(Simple::class, $class);

        $this->assertEquals($json->name, $class->name);
        $this->assertInstanceOf(Address::class, $class->address);
        $this->assertEquals($json->address->city, $class->address->city);
        $this->assertEquals($json->address->street, $class->address->street);
    }

    public function testStructAdvanced()
    {
        $json = json_decode(file_get_contents(__DIR__ . '/../../examples/json/advanced.json'))[0];

        $class = Advanced::map($json);

        $this->assertInstanceOf(Advanced::class, $class);

        $this->assertEquals($json->name, $class->name);
        $this->assertEquals($json->code, $class->code);
        $this->assertInstanceOf(LifecycleStatus::class, $class->activationStatus);
        $this->assertEquals($json->activationStatus->name, $class->activationStatus->name);
    }
}