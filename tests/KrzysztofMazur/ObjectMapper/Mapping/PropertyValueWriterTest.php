<?php

namespace Tests\KrzysztofMazur\ObjectMapper\Mapping;

use KrzysztofMazur\ObjectMapper\Mapping\Field\ValueWriter\PropertyValueWriter;
use KrzysztofMazur\ObjectMapper\Mapping\Field\ValueWriter\MethodReferenceGetter;
use PHPUnit\Framework\TestCase;
use TestFixtures\SimpleObject;

class PropertyValueWriterTest extends TestCase
{
    public function testWriteSuccess()
    {
        $writer = new PropertyValueWriter('property1');
        $object = new SimpleObject();
        $writer->write($object, 'ok');

        self::assertEquals('ok', $object->getProperty1());
    }

    public function testNestedWrite()
    {
        $writer = new PropertyValueWriter('property1', new MethodReferenceGetter('getProperty1'));
        $object = new SimpleObject();
        $object->setProperty1(new SimpleObject());
        $writer->write($object, 'ok-nested');

        self::assertEquals('ok-nested', $object->getProperty1()->getProperty1());
    }
}
