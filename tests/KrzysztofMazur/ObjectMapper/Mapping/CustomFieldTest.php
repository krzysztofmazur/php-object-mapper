<?php

namespace Tests\KrzysztofMazur\ObjectMapper\Mapping;

use KrzysztofMazur\ObjectMapper\Mapping\CustomField;
use PHPUnit\Framework\TestCase;
use TestFixtures\SimpleObject;

class CustomFieldTest extends TestCase
{
    public function testMapSuccess()
    {
        $field = new CustomField(
            function ($source, $target) {
                $target->setProperty1($source->getProperty1());
            }
        );
        $source = new SimpleObject();
        $source->setProperty1('ok');
        $target = new SimpleObject();
        $field->map($source, $target);

        self::assertEquals('ok', $target->getProperty1());
    }
}
