<?php

namespace Tests\KrzysztofMazur\ObjectMapper\Mapping;

use KrzysztofMazur\ObjectMapper\Mapping\MethodValueWriter;
use KrzysztofMazur\ObjectMapper\Mapping\ValueWriter\MethodReferenceGetter;
use PHPUnit\Framework\TestCase;
use TestFixtures\SimpleObject;

class MethodValueWriterTest extends TestCase
{
    public function testWriteSuccess()
    {
        $writer = new MethodValueWriter(SimpleObject::class, 'setProperty1');
        $object = new SimpleObject();
        $writer->write($object, 'ok');

        $this->assertEquals('ok', $object->getProperty1());
    }

    public function testNestedWrite()
    {
        $writer = new MethodValueWriter(
            SimpleObject::class,
            'setProperty1',
            new MethodReferenceGetter('getProperty1')
        );
        $object = new SimpleObject();
        $object->setProperty1(new SimpleObject());
        $writer->write($object, 'ok-nested');

        $this->assertEquals('ok-nested', $object->getProperty1()->getProperty1());
    }

    /**
     * @expectedException \KrzysztofMazur\ObjectMapper\Exception\NotSupportedMappingException
     */
    public function testNotSupported()
    {
        $writer = new MethodValueWriter('SomeClass', 'setProperty1');
        $object = new SimpleObject();
        $writer->write($object, 'ok');
    }

    /**
     * @expectedException \KrzysztofMazur\ObjectMapper\Exception\NullReferenceException
     */
    public function testNullReference()
    {
        $writer = new MethodValueWriter('SomeClass', 'setProperty1');
        $writer->write(null, 'ok');
    }
}
