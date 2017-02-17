<?php

namespace Tests\KrzysztofMazur\ObjectMapper\Mapping\Field\ValueReader;

use KrzysztofMazur\ObjectMapper\Mapping\Field\ValueReader\PropertyValueReader;
use PHPUnit\Framework\TestCase;
use TestFixtures\SimpleObject;

/**
 * @author Krzysztof Mazur <krz@ychu.pl>
 */
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
     * @expectedException \ReflectionException
     */
    public function testMethodNotFound()
    {
        $obj = new SimpleObject();
        $reader = new PropertyValueReader('something');
        $reader->read($obj);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testNullObject()
    {
        $reader = new PropertyValueReader('something');
        $reader->read(null);
    }
}
