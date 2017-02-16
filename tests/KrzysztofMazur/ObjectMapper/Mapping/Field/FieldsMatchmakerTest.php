<?php

namespace Tests\KrzysztofMazur\ObjectMapper\Mapping\Field;

use KrzysztofMazur\ObjectMapper\Mapping\Field\FieldsMatchmaker;
use KrzysztofMazur\ObjectMapper\Util\PropertyNameConverter;
use PHPUnit\Framework\TestCase;
use TestFixtures\TestSourceObject;
use TestFixtures\TestTargetObject;

class FieldsMatchmakerTest extends TestCase
{
    public function testMatchSuccess()
    {
        $matchmaker = new FieldsMatchmaker(new PropertyNameConverter());
        $fields = $matchmaker->match(TestSourceObject::class, TestTargetObject::class);

        self::assertArrayHasKey('width', $fields);
        self::assertEquals($fields['width'], 'width');
        self::assertArrayHasKey('area', $fields);
        self::assertEquals($fields['area'], 'getArea()');
    }
}
