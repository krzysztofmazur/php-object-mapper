<?php
/*
 * This file is part of php-object-mapper.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tests\KrzysztofMazur\ObjectMapper;

use KrzysztofMazur\ObjectMapper\Mapping\Mapping;
use KrzysztofMazur\ObjectMapper\Mapping\MappingRepository;
use KrzysztofMazur\ObjectMapper\ObjectMapper;
use KrzysztofMazur\ObjectMapper\Util\InstantiatorInterface;
use PHPUnit\Framework\TestCase;
use Tests\KrzysztofMazur\ObjectMapper\Fixtures\SimpleObject;

/**
 * @author Krzysztof Mazur <krz@ychu.pl>
 */
class ObjectMapperTest extends TestCase
{
    public function testMapSuccess()
    {
        $source = $this->createMock(SimpleObject::class);
        $target = $this->createMock(SimpleObject::class);

        $instantiator = $this->createMock(InstantiatorInterface::class);
        $instantiator
            ->expects(self::once())
            ->method('instantiate')
            ->with(self::equalTo(SimpleObject::class))
            ->willReturn($target);

        $mapping = $this->createMock(Mapping::class);
        $mapping
            ->expects(self::once())
            ->method('map')
            ->with(self::equalTo($source), self::equalTo($target))
            ->willReturn(null);

        $repository = $this->createMock(MappingRepository::class);
        $repository
            ->expects(self::once())
            ->method('getMapping')
            ->with(get_class($source), get_class($target))
            ->willReturn($mapping);

        $mapper = new ObjectMapper($instantiator, $repository);
        $mapper->map($source, SimpleObject::class);
    }
}
