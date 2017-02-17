<?php

namespace Tests\KrzysztofMazur\ObjectMapper\Mapping\Field\ValueReader;

use KrzysztofMazur\ObjectMapper\Mapping\Field\ValueReader\ValueInitializer;
use KrzysztofMazur\ObjectMapper\Util\InitializerInterface;
use PHPUnit\Framework\TestCase;
use TestFixtures\SimpleObject;

/**
 * @author Krzysztof Mazur <krz@ychu.pl>
 */
class ValueInitializerTest extends TestCase
{
    /**
     * @var InitializerInterface
     */
    private $initializerMock;

    /**
     * {@inheritdoc}
     */
    public function setUp()
    {
        $this->initializerMock = $this->createMock(InitializerInterface::class);
    }

    public function testInitializeSuccess()
    {
        $this->initializerMock->method('initialize')->willReturn(new SimpleObject());
        $valueInitializer = new ValueInitializer(SimpleObject::class, $this->initializerMock);
        $object = $valueInitializer->read(null);

        self::assertInstanceOf(SimpleObject::class, $object);
    }
}
