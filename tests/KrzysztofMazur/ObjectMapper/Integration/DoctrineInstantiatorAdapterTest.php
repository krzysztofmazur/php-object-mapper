<?php

namespace Tests\KrzysztofMazur\ObjectMapper\Integration;

use Doctrine\Instantiator\Instantiator;
use KrzysztofMazur\ObjectMapper\Intergration\DoctrineInstantiatorAdapter;
use KrzysztofMazur\ObjectMapper\Util\InitializerInterface;
use PHPUnit\Framework\TestCase;
use TestFixtures\SimpleObject;

class DoctrineInstantiatorAdapterTest extends TestCase
{
    /**
     * @var InitializerInterface
     */
    private $initializer;

    public function setUp()
    {
        $this->initializer = new DoctrineInstantiatorAdapter(new Instantiator());
    }

    public function testCreateSuccess()
    {
        $sample = $this->initializer->initialize(SimpleObject::class);

        $this->assertInstanceOf(SimpleObject::class, $sample);
    }
}