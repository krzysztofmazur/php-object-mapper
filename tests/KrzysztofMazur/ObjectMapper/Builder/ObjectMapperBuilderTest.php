<?php
/*
 * This file is part of php-object-mapper.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tests\KrzysztofMazur\ObjectMapper\Builder;

use KrzysztofMazur\ObjectMapper\Mapping\MappingRepository;
use KrzysztofMazur\ObjectMapper\ObjectMapper;
use KrzysztofMazur\ObjectMapper\Builder\ObjectMapperBuilder;
use KrzysztofMazur\ObjectMapper\Util\InitializerInterface;
use PHPUnit\Framework\TestCase;

/**
 * @author Krzysztof Mazur <krz@ychu.pl>
 */
class ObjectMapperBuilderTest extends TestCase
{
    public function testSuccess()
    {
        $initializer = $this->createMock(InitializerInterface::class);
        $repository = $this->createMock(MappingRepository::class);

        $mapper = ObjectMapperBuilder::create()
            ->setInitializer($initializer)
            ->setRepository($repository)
            ->build();

        self::assertInstanceOf(ObjectMapper::class, $mapper);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testFail()
    {
        ObjectMapperBuilder::create()->build();
    }
}
