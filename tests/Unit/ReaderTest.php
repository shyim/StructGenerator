<?php

namespace Shyim\StructGenerator\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Shyim\StructGenerator\Reader\DefaultReader;
use Shyim\StructGenerator\Struct\PropertyMeta;
use Shyim\StructGenerator\Struct\StructMeta;

class ReaderTest extends TestCase
{
    /**
     * @var DefaultReader
     */
    protected $reader;

    public function setUp(): void
    {
        $this->reader = new DefaultReader();
    }

    public function testSimpleJson()
    {
        $json = json_decode(file_get_contents(__DIR__ . '/../../examples/json/simple.json'), true);

        $configuration = Helper::getConfiguration();
        $meta = $this->reader->read($configuration, $json);

        $this->assertNotEmpty($meta);

        /**
         * @var int $key
         * @var StructMeta $item
         */
        foreach ($meta as $key => $item) {
            $this->assertInstanceOf(StructMeta::class, $item);

            foreach ($item->properties as $property) {
                $this->assertInstanceOf(PropertyMeta::class, $property);
            }
        }

        $this->assertCount(2, $meta);
        $this->assertStringContainsString($configuration->name, $meta[0]->name);

        // Property name
        $this->assertEquals('name', $meta[0]->properties[0]->name);
        $this->assertEquals('string', $meta[0]->properties[0]->type);
        $this->assertNull($meta[0]->properties[0]->mapping);

        // Property address
        $this->assertEquals('address', $meta[0]->properties[1]->name);
        $this->assertEquals($configuration->namespace . 'Address', $meta[0]->properties[1]->type);
        $this->assertNotNull($meta[0]->properties[1]->mapping);
        $this->assertEquals($configuration->namespace . 'Address', $meta[0]->properties[1]->mapping->class);
    }
}