<?php
/*
 * This file is part of php-object-mapper.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace KrzysztofMazur\ObjectMapper\Mapping\Field;

/**
 * @author Krzysztof Mazur <krz@ychu.pl>
 */
interface FieldInterface
{
    /**
     * @param mixed $source
     * @param mixed $target
     */
    public function map($source, $target);
}
