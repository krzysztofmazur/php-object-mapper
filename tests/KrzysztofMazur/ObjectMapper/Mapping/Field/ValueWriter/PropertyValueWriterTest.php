<?php

namespace Tests\KrzysztofMazur\ObjectMapper\Mapping\Field\ValueWriter;

use KrzysztofMazur\ObjectMapper\Mapping\Field\ValueReader\MethodValueReader;
use KrzysztofMazur\ObjectMapper\Mapping\Field\ValueWriter\PropertyValueWriter;
use PHPUnit\Framework\TestCase;
use TestFixtures\SimpleObject;

/**
 * @author Krzysztof Mazur <krz@ychu.pl>
 */
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
        $writer = new PropertyValueWriter('property1', new MethodValueReader('getProperty1'));
        $object = new SimpleObject();
        $object->setProperty1(new SimpleObject());
        $writer->write($object, 'ok-nested');

        self::assertEquals('ok-nested', $object->getProperty1()->getProperty1());
    }
}
