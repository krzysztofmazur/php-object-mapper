<?php

namespace Tests\KrzysztofMazur\ObjectMapper\Mapping\ValueWriter;

use KrzysztofMazur\ObjectMapper\Mapping\ValueWriter\MethodReferenceGetter;
use PHPUnit\Framework\TestCase;
use TestFixtures\SimpleObject;

class MethodReferenceGetterTest extends TestCase
{
    public function testSuccess()
    {
        $obj1 = new SimpleObject();
        $obj2 = new SimpleObject();
        $obj2->setProperty1($obj1);
        $getter = new MethodReferenceGetter('getProperty1');

        $this->assertSame($obj1, $getter->getReference($obj2));
    }

    public function testNestedSuccess()
    {
        $obj1 = new SimpleObject();
        $obj2 = new SimpleObject();
        $obj3 = new SimpleObject();
        $obj2->setProperty1($obj1);
        $obj3->setProperty1($obj2);
        $getter = new MethodReferenceGetter('getProperty1', [], new MethodReferenceGetter('getProperty1'));

        $this->assertSame($obj1, $getter->getReference($obj3));
    }
}
