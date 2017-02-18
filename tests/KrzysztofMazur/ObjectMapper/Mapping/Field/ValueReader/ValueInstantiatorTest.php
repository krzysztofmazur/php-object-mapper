<?php
/*
 * This file is part of php-object-mapper.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tests\KrzysztofMazur\ObjectMapper\Mapping\Field\ValueReader;

use KrzysztofMazur\ObjectMapper\Mapping\Field\ValueReader\ValueInstantiator;
use KrzysztofMazur\ObjectMapper\Util\InstantiatorInterface;
use PHPUnit\Framework\TestCase;
use Tests\KrzysztofMazur\ObjectMapper\Fixtures\SimpleObject;

/**
 * @author Krzysztof Mazur <krz@ychu.pl>
 */
class ValueInstantiatorTest extends TestCase
{
    /**
     * @var InstantiatorInterface
     */
    private $instantiator;

    /**
     * {@inheritdoc}
     */
    public function setUp()
    {
        $this->instantiator = $this->createMock(InstantiatorInterface::class);
    }

    public function testInstantiateSuccess()
    {
        $this->instantiator->method('instantiate')->willReturn(new SimpleObject());
        $valueInstantiator = new ValueInstantiator(SimpleObject::class, $this->instantiator);
        $object = $valueInstantiator->read(null);

        self::assertInstanceOf(SimpleObject::class, $object);
    }
}
