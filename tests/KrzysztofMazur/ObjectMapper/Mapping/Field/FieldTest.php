<?php
/*
 * This file is part of php-object-mapper.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tests\KrzysztofMazur\ObjectMapper\Mapping\Field;

use KrzysztofMazur\ObjectMapper\Mapping\Field\Field;
use KrzysztofMazur\ObjectMapper\Mapping\Field\ValueReader\ValueReaderInterface;
use KrzysztofMazur\ObjectMapper\Mapping\Field\ValueWriter\ValueWriterInterface;
use PHPUnit\Framework\TestCase;
use Tests\KrzysztofMazur\ObjectMapper\Fixtures\SimpleObject;

/**
 * @author Krzysztof Mazur <krz@ychu.pl>
 */
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
