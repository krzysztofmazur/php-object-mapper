<?php
/*
 * This file is part of php-object-mapper.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tests\KrzysztofMazur\ObjectMapper\Builder;

use KrzysztofMazur\ObjectMapper\Builder\ObjectMapperSimpleBuilder;
use KrzysztofMazur\ObjectMapper\ObjectMapper;
use KrzysztofMazur\ObjectMapper\Util\InstantiatorInterface;
use PHPUnit\Framework\TestCase;

/**
 * @author Krzysztof Mazur <krz@ychu.pl>
 */
class ObjectMapperSimpleBuilderTest extends TestCase
{
    public function testBuildSuccess()
    {
        $mapper = ObjectMapperSimpleBuilder::create()
            ->setConfig([])
            ->setInstantiator($this->createMock(InstantiatorInterface::class))
            ->build();

        self::assertInstanceOf(ObjectMapper::class, $mapper);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testBuildFail()
    {
        ObjectMapperSimpleBuilder::create()->build();
    }
}
