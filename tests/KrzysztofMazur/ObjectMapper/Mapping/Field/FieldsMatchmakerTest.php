<?php
/*
 * This file is part of php-object-mapper.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tests\KrzysztofMazur\ObjectMapper\Mapping\Field;

use KrzysztofMazur\ObjectMapper\Mapping\Field\FieldsMatchmaker;
use KrzysztofMazur\ObjectMapper\Util\PropertyNameConverter;
use PHPUnit\Framework\TestCase;
use Tests\KrzysztofMazur\ObjectMapper\Fixtures\TestSourceObject;
use Tests\KrzysztofMazur\ObjectMapper\Fixtures\TestTargetObject;

/**
 * @author Krzysztof Mazur <krz@ychu.pl>
 */
class FieldsMatchmakerTest extends TestCase
{
    public function testMatchSuccess()
    {
        $matchmaker = new FieldsMatchmaker(new PropertyNameConverter());
        $fields = $matchmaker->match(TestSourceObject::class, TestTargetObject::class);

        self::assertArrayHasKey('width', $fields);
        self::assertEquals($fields['width'], 'width');
        self::assertArrayHasKey('area', $fields);
        self::assertEquals($fields['area'], 'getArea()');
    }
}
