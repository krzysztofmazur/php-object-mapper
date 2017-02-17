<?php

namespace Tests\KrzysztofMazur\ObjectMapper\Mapping\Field\ValueWriter;

use KrzysztofMazur\ObjectMapper\Mapping\Field\ValueReader\MethodValueReader;
use KrzysztofMazur\ObjectMapper\Mapping\Field\ValueWriter\MethodValueWriter;
use KrzysztofMazur\ObjectMapper\Mapping\Field\ValueWriter\MethodReferenceGetter;
use PHPUnit\Framework\TestCase;
use TestFixtures\SimpleObject;

/**
 * @author Krzysztof Mazur <krz@ychu.pl>
 */
class MethodValueWriterTest extends TestCase
{
    public function testWriteSuccess()
    {
        $writer = new MethodValueWriter('setProperty1');
        $object = new SimpleObject();
        $writer->write($object, 'ok');

        self::assertEquals('ok', $object->getProperty1());
    }

    public function testNestedWrite()
    {
        $writer = new MethodValueWriter('setProperty1', new MethodValueReader('getProperty1'));
        $object = new SimpleObject();
        $object->setProperty1(new SimpleObject());
        $writer->write($object, 'ok-nested');

        self::assertEquals('ok-nested', $object->getProperty1()->getProperty1());
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testNullReference()
    {
        $writer = new MethodValueWriter('setProperty1');
        $writer->write(null, 'ok');
    }
}