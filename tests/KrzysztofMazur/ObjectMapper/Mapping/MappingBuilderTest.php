<?php

namespace Tests\KrzysztofMazur\ObjectMapper\Mapping;

use KrzysztofMazur\ObjectMapper\Mapping\Field\FieldFactory;
use KrzysztofMazur\ObjectMapper\Mapping\Field\FieldsMatchmakerInterface;
use KrzysztofMazur\ObjectMapper\Mapping\MappingBuilder;
use KrzysztofMazur\ObjectMapper\Mapping\Field\Field;
use KrzysztofMazur\ObjectMapper\Mapping\Mapping;
use PHPUnit\Framework\TestCase;
use TestFixtures\SimpleObject;

/**
 * @author Krzysztof Mazur <krz@ychu.pl>
 */
class MappingBuilderTest extends TestCase
{
    /**
     * @expectedException \InvalidArgumentException
     */
    public function testWithoutData()
    {
        $builder = new MappingBuilder();
        $builder->build();
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testWithoutMatchmaker()
    {
        $fieldFactoryMock = $this->createMock(FieldFactory::class);
        $builder = new MappingBuilder();
        $builder->setFieldFactory($fieldFactoryMock);
        $builder->setSourceClass(SimpleObject::class);
        $builder->setTargetClass(SimpleObject::class);
        $builder->setFields([]);
        $builder->setFieldsAutoMatch(true);
        $builder->build();
    }

    public function testSuccess()
    {
        $fieldFactoryMock = $this->createMock(FieldFactory::class);
        $fieldFactoryMock
            ->expects($this->once())
            ->method('factory')
            ->with($this->equalTo('property1'), $this->equalTo('property1'))
            ->willReturn($this->createMock(Field::class));

        $matchmakerMock = $this->createMock(FieldsMatchmakerInterface::class);
        $matchmakerMock
            ->expects(self::once())
            ->method('match')
            ->with(self::equalTo(SimpleObject::class), self::equalTo(SimpleObject::class))
            ->willReturn([]);

        $builder = new MappingBuilder();
        $builder->setFieldFactory($fieldFactoryMock);
        $builder->setSourceClass(SimpleObject::class);
        $builder->setTargetClass(SimpleObject::class);
        $builder->setFields([
            'property1' => 'property1',
        ]);
        $builder->setFieldsMatchmaker($matchmakerMock);
        $builder->setFieldsAutoMatch(true);
        $mapping = $builder->build();

        self::assertInstanceOf(Mapping::class, $mapping);
    }
}
