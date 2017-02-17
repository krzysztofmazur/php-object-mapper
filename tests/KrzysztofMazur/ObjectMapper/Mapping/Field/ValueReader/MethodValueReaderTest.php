<?php
/*
 * This file is part of php-object-mapper.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tests\KrzysztofMazur\ObjectMapper\Mapping\Field\ValueReader;

use KrzysztofMazur\ObjectMapper\Mapping\Field\ValueReader\MethodValueReader;
use PHPUnit\Framework\TestCase;
use Tests\KrzysztofMazur\ObjectMapper\Fixtures\SimpleObject;

/**
 * @author Krzysztof Mazur <krz@ychu.pl>
 */
class MethodValueReaderTest extends TestCase
{
    public function testReadSuccess()
    {
        $obj = new SimpleObject();
        $obj->setProperty1('ok');
        $reader = new MethodValueReader('getProperty1');

        self::assertEquals('ok', $reader->read($obj));
    }

    /**
     * @expectedException \ReflectionException
     */
    public function testMethodNotFound()
    {
        $obj = new SimpleObject();
        $reader = new MethodValueReader('getSomething');
        $reader->read($obj);
    }

    public function testReadWithArgsSuccess()
    {
        $obj = new SimpleObject();
        $obj->setProperty1(new \DateTime('2017-01-01 12:00:00', new \DateTimeZone('UTC')));
        $reader = new MethodValueReader('getProperty1', [], new MethodValueReader('format', ['Y-m-d']));

        self::assertEquals('2017-01-01', $reader->read($obj));
    }
}
