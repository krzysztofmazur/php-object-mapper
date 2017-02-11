<?php

namespace Tests\KrzysztofMazur\ObjectMapper\Builder;

use KrzysztofMazur\ObjectMapper\Builder\FieldFactory;
use KrzysztofMazur\ObjectMapper\Mapping\CustomField;
use KrzysztofMazur\ObjectMapper\Mapping\Field;
use KrzysztofMazur\ObjectMapper\Mapping\MethodValueReader;
use KrzysztofMazur\ObjectMapper\Mapping\MethodValueWriter;
use KrzysztofMazur\ObjectMapper\Mapping\PropertyValueReader;
use KrzysztofMazur\ObjectMapper\Mapping\PropertyValueWriter;
use KrzysztofMazur\ObjectMapper\Mapping\ValueInitializer;
use PHPUnit\Framework\TestCase;
use TestFixtures\SimpleObject;

class FieldFactoryTest extends TestCase
{
    /**
     * @var FieldFactory
     */
    private $factory;

    public function setUp()
    {
        $this->factory = new FieldFactory();
    }

    public function testFromInitializer()
    {
        $field = $this->factory->factory(
            'new '.SimpleObject::class.'()',
            'property1'
        );

        $this->assertInstanceOf(Field::class, $field);
        /* @var Field $field */
        $this->assertInstanceOf(ValueInitializer::class, $field->getReader());
        $this->assertInstanceOf(PropertyValueWriter::class, $field->getWriter());
    }

    public function testFromProperty()
    {
        $field = $this->factory->factory('property1', 'property1');

        $this->assertInstanceOf(Field::class, $field);
        /* @var Field $field */
        $this->assertInstanceOf(PropertyValueReader::class, $field->getReader());
        $this->assertInstanceOf(PropertyValueWriter::class, $field->getWriter());
    }

    public function testFromMethod()
    {
        $field = $this->factory->factory('getProperty1()', 'property1');

        $this->assertInstanceOf(Field::class, $field);
        /* @var Field $field */
        $this->assertInstanceOf(MethodValueReader::class, $field->getReader());
        $this->assertInstanceOf(PropertyValueWriter::class, $field->getWriter());
    }

    public function testToMethod()
    {
        $field = $this->factory->factory('getProperty1()', 'setProperty1()');

        $this->assertInstanceOf(Field::class, $field);
        /* @var Field $field */
        $this->assertInstanceOf(MethodValueReader::class, $field->getReader());
        $this->assertInstanceOf(MethodValueWriter::class, $field->getWriter());
    }

    public function testFromCallback()
    {
        $field = $this->factory->factory(
            function ($source, $target) {
                $target->setValue($source->getValue());
            },
            'no-matter-text'
        );

        $this->assertInstanceOf(CustomField::class, $field);
    }
}
