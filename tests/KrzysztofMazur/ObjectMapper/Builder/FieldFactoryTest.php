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
use KrzysztofMazur\ObjectMapper\Mapping\ValueWriter\MethodReferenceGetter;
use KrzysztofMazur\ObjectMapper\Mapping\ValueWriter\PropertyReferenceGetter;
use KrzysztofMazur\ObjectMapper\Util\InitializerInterface;
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
        /** @var InitializerInterface $initializer */
        $initializer = $this->createMock(InitializerInterface::class);
        $this->factory = new FieldFactory($initializer);
    }

    /**
     * @return array
     */
    public function dataForFieldTests()
    {
        return [
            ['new '.SimpleObject::class.'()', 'property1', ValueInitializer::class, PropertyValueWriter::class],
            ['new '.SimpleObject::class.'()', 'setProperty1()', ValueInitializer::class, MethodValueWriter::class],
            ['property1', 'property1', PropertyValueReader::class, PropertyValueWriter::class],
            ['property1', 'setProperty1()', PropertyValueReader::class, MethodValueWriter::class],
            ['getProperty1()', 'property1', MethodValueReader::class, PropertyValueWriter::class],
            ['getProperty1()', 'setProperty1()', MethodValueReader::class, MethodValueWriter::class],
        ];
    }

    /**
     * @param string $readText
     * @param string $writeText
     * @param string $readerClass
     * @param string $writerClass
     *
     * @dataProvider dataForFieldTests
     */
    public function testCreatingField($readText, $writeText, $readerClass, $writerClass)
    {
        $field = $this->factory->factory($readText, $writeText);

        self::assertInstanceOf(Field::class, $field);
        /* @var Field $field */
        self::assertInstanceOf($readerClass, $field->getReader());
        self::assertInstanceOf($writerClass, $field->getWriter());
    }

    public function testUsingCallback()
    {
        $field = $this->factory->factory(
            function ($source, $target) {
                $target->setValue($source->getValue());
            },
            'no-matter-text'
        );

        self::assertInstanceOf(CustomField::class, $field);
    }

    public function testNested()
    {
        $field = $this->factory->factory(
            'property1.property1.getValue()',
            'property.getSomeNext().setSomeVal()'
        );

        self::assertInstanceOf(Field::class, $field);
        /* @var Field $field */
        self::assertNotNull($field->getReader());
        self::assertInstanceOf(PropertyValueReader::class, $field->getReader());
        self::assertNotNull($field->getReader()->getNext());
        self::assertInstanceOf(PropertyValueReader::class, $field->getReader()->getNext());
        self::assertNotNull($field->getReader()->getNext()->getNext());
        self::assertInstanceOf(MethodValueReader::class, $field->getReader()->getNext()->getNext());

        self::assertNotNull($field->getWriter());
        self::assertInstanceOf(MethodValueWriter::class, $field->getWriter());
        self::assertNotNull($field->getWriter()->getReferenceGetter());
        self::assertInstanceOf(PropertyReferenceGetter::class, $field->getWriter()->getReferenceGetter());
        self::assertNotNull($field->getWriter()->getReferenceGetter()->getNext());
        self::assertInstanceOf(MethodReferenceGetter::class, $field->getWriter()->getReferenceGetter()->getNext());
    }
}
