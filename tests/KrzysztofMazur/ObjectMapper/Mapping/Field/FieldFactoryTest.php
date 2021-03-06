<?php
/*
 * This file is part of php-object-mapper.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tests\KrzysztofMazur\ObjectMapper\Mapping\Field;

use KrzysztofMazur\ObjectMapper\Mapping\Field\FieldFactory;
use KrzysztofMazur\ObjectMapper\Mapping\Field\CustomField;
use KrzysztofMazur\ObjectMapper\Mapping\Field\Field;
use KrzysztofMazur\ObjectMapper\Mapping\Field\ValueReader\MethodValueReader;
use KrzysztofMazur\ObjectMapper\Mapping\Field\ValueWriter\MethodValueWriter;
use KrzysztofMazur\ObjectMapper\Mapping\Field\ValueReader\PropertyValueReader;
use KrzysztofMazur\ObjectMapper\Mapping\Field\ValueWriter\PropertyValueWriter;
use KrzysztofMazur\ObjectMapper\Mapping\Field\ValueReader\ValueInstantiator;
use KrzysztofMazur\ObjectMapper\Util\InstantiatorInterface;
use PHPUnit\Framework\TestCase;
use Tests\KrzysztofMazur\ObjectMapper\Fixtures\SimpleObject;

/**
 * @author Krzysztof Mazur <krz@ychu.pl>
 */
class FieldFactoryTest extends TestCase
{
    /**
     * @var FieldFactory
     */
    private $factory;

    /**
     * {@inheritdoc}
     */
    public function setUp()
    {
        /** @var InstantiatorInterface $instantiator */
        $instantiator = $this->createMock(InstantiatorInterface::class);
        $this->factory = new FieldFactory($instantiator);
    }

    /**
     * @return array
     */
    public function dataForFieldTests()
    {
        return [
            ['new '.SimpleObject::class.'()', 'property1', ValueInstantiator::class, PropertyValueWriter::class],
            ['new '.SimpleObject::class.'()', 'setProperty1()', ValueInstantiator::class, MethodValueWriter::class],
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
        self::assertNotNull($field->getWriter()->getValueReader());
        self::assertInstanceOf(PropertyValueReader::class, $field->getWriter()->getValueReader());
        self::assertNotNull($field->getWriter()->getValueReader()->getNext());
        self::assertInstanceOf(MethodValueReader::class, $field->getWriter()->getValueReader()->getNext());
    }

    public function testWithArgs()
    {
        $field = $this->factory->factory('format("Y-m-d")', 'date');

        self::assertInstanceOf(Field::class, $field);
        /* @var Field $field */
        self::assertNotNull($field->getReader());
        self::assertInstanceOf(MethodValueReader::class, $field->getReader());
        self::assertNull($field->getReader()->getNext());
        $date = \DateTime::createFromFormat("Y-m-d H:i:s", "2011-02-02 12:30:00");
        self::assertEquals("2011-02-02", $field->getReader()->read($date));

        self::assertNotNull($field->getWriter());
        self::assertInstanceOf(PropertyValueWriter::class, $field->getWriter());
        self::assertNull($field->getWriter()->getValueReader());
    }
}
