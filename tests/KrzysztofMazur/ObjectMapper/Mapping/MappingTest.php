<?php

namespace Tests\KrzysztofMazur\ObjectMapper\Mapping;

use KrzysztofMazur\ObjectMapper\Mapping\Field;
use KrzysztofMazur\ObjectMapper\Mapping\Mapping;
use PHPUnit\Framework\TestCase;
use TestFixtures\SimpleObject;

class MappingTest extends TestCase
{
    public function testMapSuccess()
    {
        $source = $this->createMock(SimpleObject::class);
        $target = $this->createMock(SimpleObject::class);

        $fields = [$this->createFieldMock($source, $target), $this->createFieldMock($source, $target)];

        $mapping = new Mapping(get_class($source), get_class($target), $fields);
        $mapping->map($source, $target);
    }

    /**
     * @expectedException \KrzysztofMazur\ObjectMapper\Exception\NotSupportedMappingException
     */
    public function testNotSupported()
    {
        $source = $this->createMock(SimpleObject::class);
        $target = $this->createMock(SimpleObject::class);
        $mapping = new Mapping(get_class($source), get_class($target), []);

        $mapping->map($source, new \DateTime());
    }

    private function createFieldMock($source, $target)
    {
        $field = $this->createMock(Field::class);
        $field
            ->expects($this->once())
            ->method('map')
            ->with($this->equalTo($source), $this->equalTo($target))
            ->willReturn(null);

        return $field;
    }

    public function testSupports()
    {
        $source = $this->createMock(SimpleObject::class);
        $target = $this->createMock(SimpleObject::class);
        $mapping = new Mapping(get_class($source), get_class($target), []);

        self::assertTrue($mapping->supports(get_class($source), get_class($target)));
        self::assertFalse($mapping->supports('DateTime', 'PDO'));
    }
}
