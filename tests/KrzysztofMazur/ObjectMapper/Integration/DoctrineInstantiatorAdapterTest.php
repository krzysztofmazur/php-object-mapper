<?php
/*
 * This file is part of php-object-mapper.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tests\KrzysztofMazur\ObjectMapper\Integration;

use Doctrine\Instantiator\Instantiator;
use KrzysztofMazur\ObjectMapper\Integration\DoctrineInstantiatorAdapter;
use KrzysztofMazur\ObjectMapper\Util\InitializerInterface;
use PHPUnit\Framework\TestCase;
use Tests\KrzysztofMazur\ObjectMapper\Fixtures\SimpleObject;

/**
 * @author Krzysztof Mazur <krz@ychu.pl>
 */
class DoctrineInstantiatorAdapterTest extends TestCase
{
    /**
     * @var InitializerInterface
     */
    private $initializer;

    /**
     * {@inheritdoc}
     */
    public function setUp()
    {
        $this->initializer = new DoctrineInstantiatorAdapter(new Instantiator());
    }

    public function testCreateSuccess()
    {
        $sample = $this->initializer->initialize(SimpleObject::class);

        self::assertInstanceOf(SimpleObject::class, $sample);
    }
}