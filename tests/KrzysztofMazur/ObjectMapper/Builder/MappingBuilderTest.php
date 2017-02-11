<?php

namespace Tests\KrzysztofMazur\ObjectMapper\Builder;

use KrzysztofMazur\ObjectMapper\Builder\FieldFactory;
use KrzysztofMazur\ObjectMapper\Builder\MappingBuilder;
use KrzysztofMazur\ObjectMapper\Mapping\Field;
use KrzysztofMazur\ObjectMapper\Mapping\Mapping;
use PHPUnit\Framework\TestCase;
use TestFixtures\SimpleObject;

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

    public function testSuccess()
    {
        $fieldFactoryMock = $this->createMock(FieldFactory::class);
        $fieldFactoryMock
            ->expects($this->once())
            ->method('factory')
            ->with($this->equalTo('property1'), $this->equalTo('property1'))
            ->willReturn($this->createMock(Field::class));

        $builder = new MappingBuilder();
        $builder->setFieldFactory($fieldFactoryMock);
        $builder->setSourceClass(SimpleObject::class);
        $builder->setTargetClass(SimpleObject::class);
        $builder->setFields([
            'property1' => 'property1',
        ]);
        $mapping = $builder->build();

        self::assertInstanceOf(Mapping::class, $mapping);
    }
}
