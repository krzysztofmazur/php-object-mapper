<?php

namespace Tests\KrzysztofMazur\ObjectMapper\Mapping\Field\ValueReader;

use KrzysztofMazur\ObjectMapper\Mapping\Field\ValueReader\MethodValueReader;
use PHPUnit\Framework\TestCase;
use TestFixtures\SimpleObject;

class MethodValueReaderTest extends TestCase
{
    public function testReadSuccess()
    {
        $obj = new SimpleObject();
        $obj->setProperty1('ok');
        $reader = new MethodValueReader('getProperty1');

        self::assertEquals('ok', $reader->read($obj));
    }

    /**
     * @expectedException \ReflectionException
     */
    public function testMethodNotFound()
    {
        $obj = new SimpleObject();
        $reader = new MethodValueReader('getSomething');
        $reader->read($obj);
    }

    public function testReadWithArgsSuccess()
    {
        $obj = new SimpleObject();
        $obj->setProperty1(new \DateTime('2017-01-01 12:00:00', new \DateTimeZone('UTC')));
        $reader = new MethodValueReader('getProperty1', [], new MethodValueReader('format', ['Y-m-d']));

        self::assertEquals('2017-01-01', $reader->read($obj));
    }
}
