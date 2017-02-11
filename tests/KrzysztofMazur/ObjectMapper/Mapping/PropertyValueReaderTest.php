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

        $reader = new PropertyValueReader('property1');

        self::assertEquals('ok', $reader->read($obj));
    }

    public function testNestedSuccess()
    {
        $obj = new SimpleObject();
        $obj->setProperty1(new SimpleObject());
        $obj->getProperty1()->setProperty1('ok-nested');

        $reader = new PropertyValueReader('property1', new PropertyValueReader('property1'));

        self::assertEquals('ok-nested', $reader->read($obj));
    }

    /**
     * @expectedException \KrzysztofMazur\ObjectMapper\Exception\PropertyNotFoundException
     */
    public function testMethodNotFound()
    {
        $obj = new SimpleObject();
        $reader = new PropertyValueReader('something');
        $reader->read($obj);
    }

    /**
     * @expectedException \KrzysztofMazur\ObjectMapper\Exception\NullReferenceException
     */
    public function testNullObject()
    {
        $reader = new PropertyValueReader('something');
        $reader->read(null);
    }
}
