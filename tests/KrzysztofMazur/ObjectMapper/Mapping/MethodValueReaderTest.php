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
        $reader = new MethodValueReader(get_class($obj), 'getSomething');
        $reader->read($obj);
    }
}
