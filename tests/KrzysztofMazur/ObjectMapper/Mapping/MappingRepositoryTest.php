<?php

namespace Tests\KrzysztofMazur\ObjectMapper\Mapping;

use KrzysztofMazur\ObjectMapper\Mapping\Field\FieldFactory;
use KrzysztofMazur\ObjectMapper\Mapping\Field\FieldInterface;
use KrzysztofMazur\ObjectMapper\Mapping\Field\FieldsMatchmakerInterface;
use KrzysztofMazur\ObjectMapper\Mapping\MappingRepository;
use PHPUnit\Framework\TestCase;
use TestFixtures\SimpleObject;

class MappingRepositoryTest extends TestCase
{
    /**
     * @expectedException \InvalidArgumentException
     */
    public function testInvalidConfiguration()
    {
        $config = [
            [
                'fields' => [],
                'to' => SimpleObject::class,
            ],
        ];
        new MappingRepository(
            $config,
            $this->createMock(FieldFactory::class),
            $this->createMock(FieldsMatchmakerInterface::class)
        );
    }
    /**
     * @expectedException \InvalidArgumentException
     */
    public function testInvalidConfiguration2()
    {
        $config = [
            [
                'from' => SimpleObject::class,
                'to' => SimpleObject::class,
            ],
        ];
        new MappingRepository(
            $config,
            $this->createMock(FieldFactory::class),
            $this->createMock(FieldsMatchmakerInterface::class)
        );
    }

    private function getRepository()
    {
        $config = [
            [
                'from' => SimpleObject::class,
                'to' => SimpleObject::class,
                'fields' => [
                    'property1' => 'getProperty1()',
                    'property2' => 'property2',
                ],
            ],
        ];

        $fieldFactoryMock = $this->createMock(FieldFactory::class);
        $fieldFactoryMock
            ->expects(self::at(0))
            ->method('factory')
            ->with($this->equalTo('getProperty1()'), $this->equalTo('property1'))
            ->willReturn($this->createMock(FieldInterface::class));
        $fieldFactoryMock
            ->expects(self::at(1))
            ->method('factory')
            ->with($this->equalTo('property2'), $this->equalTo('property2'))
            ->willReturn($this->createMock(FieldInterface::class));

        return new MappingRepository($config, $fieldFactoryMock, $this->createMock(FieldsMatchmakerInterface::class));
    }

    public function testSuccess()
    {
        $mapping = $this->getRepository()->getMapping(SimpleObject::class, SimpleObject::class);

        self::assertTrue($mapping->supports(SimpleObject::class, SimpleObject::class));
    }

    /**
     * @expectedException \KrzysztofMazur\ObjectMapper\Exception\MappingException
     * @expectedExceptionMessage Mapping from "DateTime" to "stdClass" is not supported
     */
    public function testNotSupported()
    {
        $this->getRepository()->getMapping(\DateTime::class, \stdClass::class);
    }

    /**
     * @expectedException \KrzysztofMazur\ObjectMapper\Exception\MappingException
     * @expectedExceptionMessage Mapping from "TestFixtures\SimpleObject" to "TestFixtures\SimpleObject" is not supported
     */
    public function testNotSupportedMapId()
    {
        $mapping = $this->getRepository()->getMapping(SimpleObject::class, SimpleObject::class, 'someId');
    }
}
