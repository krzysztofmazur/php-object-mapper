<?php

namespace Tests\KrzysztofMazur\ObjectMapper\Mapping;

use KrzysztofMazur\ObjectMapper\Mapping\FieldFactory;
use KrzysztofMazur\ObjectMapper\Mapping\FieldInterface;
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
        new MappingRepository($config, $this->createMock(FieldFactory::class));
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

        return new MappingRepository($config, $fieldFactoryMock);
    }

    public function testSuccess()
    {
        $mapping = $this->getRepository()->getMapping(SimpleObject::class, SimpleObject::class);

        self::assertTrue($mapping->supports(SimpleObject::class, SimpleObject::class));
    }

    /**
     * @expectedException \KrzysztofMazur\ObjectMapper\Exception\NotSupportedMappingException
     */
    public function testNotSupported()
    {
        $this->getRepository()->getMapping(\DateTime::class, \stdClass::class);
    }

    /**
     * @expectedException \KrzysztofMazur\ObjectMapper\Exception\NotSupportedMappingException
     */
    public function testNotSupportedMapId()
    {
        $mapping = $this->getRepository()->getMapping(SimpleObject::class, SimpleObject::class, 'someId');
    }
}