<?php

namespace Tests\KrzysztofMazur\ObjectMapper\Mapping;

use KrzysztofMazur\ObjectMapper\Mapping\Field;
use KrzysztofMazur\ObjectMapper\Mapping\ValueReaderInterface;
use KrzysztofMazur\ObjectMapper\Mapping\ValueWriterInterface;
use PHPUnit\Framework\TestCase;
use TestFixtures\SimpleObject;

class FieldTest extends TestCase
{
    public function testMapSuccess()
    {
        $source = $this->createMock(SimpleObject::class);
        $target = $this->createMock(SimpleObject::class);
        $reader = $this->createMock(ValueReaderInterface::class);
        $reader->expects($this->once())->method('read')->with($this->equalTo($source))->willReturn('ok');
        $writer = $this->createMock(ValueWriterInterface::class);
        $writer
            ->expects($this->once())
            ->method('write')
            ->with($this->equalTo($target), $this->equalTo('ok'))
            ->willReturn(null);

        $field = new Field($reader, $writer);
        $field->map($source, $target);

    }
}
