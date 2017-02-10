<?php

namespace Tests\KrzysztofMazur\ObjectMapper\Mapping\ValueWriter;

use KrzysztofMazur\ObjectMapper\Mapping\ValueWriter\PropertyReferenceGetter;
use PHPUnit\Framework\TestCase;
use TestFixtures\SimpleObject;

class PropertyReferenceGetterTest extends TestCase
{
    public function testSuccess()
    {
        $obj1 = new SimpleObject();
        $obj2 = new SimpleObject();
        $obj2->setProperty1($obj1);
        $getter = new PropertyReferenceGetter('property1');

        $this->assertSame($obj1, $getter->getReference($obj2));
    }
}
