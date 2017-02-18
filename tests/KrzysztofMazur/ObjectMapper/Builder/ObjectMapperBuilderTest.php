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
use KrzysztofMazur\ObjectMapper\Util\InstantiatorInterface;
use PHPUnit\Framework\TestCase;

/**
 * @author Krzysztof Mazur <krz@ychu.pl>
 */
class ObjectMapperBuilderTest extends TestCase
{
    public function testSuccess()
    {
        $instantiator = $this->createMock(InstantiatorInterface::class);
        $repository = $this->createMock(MappingRepository::class);

        $mapper = ObjectMapperBuilder::create()
            ->setInstantiator($instantiator)
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
