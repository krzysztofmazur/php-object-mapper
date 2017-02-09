<?php

namespace Tests\KrzysztofMazur\ObjectMapper\Mapping;

use KrzysztofMazur\ObjectMapper\Mapping\MethodValueReader;
use PHPUnit\Framework\TestCase;
use TestFixtures\SimpleObject;

class MethodValueReaderTest extends TestCase
{
    public function testReadSuccess()
    {
        $obj = new SimpleObject();
        $obj->setProperty1('ok');
        $reader = new MethodValueReader(SimpleObject::class, 'getProperty1');

        $this->assertEquals('ok', $reader->read($obj));
    }

    /**
     * @expectedException \KrzysztofMazur\ObjectMapper\Exception\MethodNotFoundException
     */
    public function testMethodNotFound()
    {
        $obj = new SimpleObject();
        $reader = new MethodValueReader(SimpleObject::class, 'getSomething');
        $reader->read($obj);
    }

    public function testReadWithArgsSuccess()
    {
        $obj = new SimpleObject();
        $obj->setProperty1(new \DateTime('2017-01-01 12:00:00', new \DateTimeZone('UTC')));
        $reader = new MethodValueReader(
            SimpleObject::class,
            'getProperty1',
            [],
            new MethodValueReader(\DateTime::class, 'format', ['Y-m-d'])
        );

        $this->assertEquals('2017-01-01', $reader->read($obj));
    }
}
