<?php

namespace Tests\KrzysztofMazur\ObjectMapper\Mapping;

use KrzysztofMazur\ObjectMapper\Mapping\PropertyValueReader;
use PHPUnit\Framework\TestCase;
use TestFixtures\SimpleObject;

class PropertyValueReaderTest extends TestCase
{
    public function testSuccess()
    {
        $obj = new SimpleObject();
        $obj->setProperty1('ok');

        $reader = new PropertyValueReader(SimpleObject::class, 'property1');

        $this->assertEquals('ok', $reader->read($obj));
    }

    /**
     * @expectedException \KrzysztofMazur\ObjectMapper\Exception\PropertyNotFoundException
     */
    public function testMethodNotFound()
    {
        $obj = new SimpleObject();
        $reader = new PropertyValueReader(get_class($obj), 'something');
        $reader->read($obj);
    }
}
