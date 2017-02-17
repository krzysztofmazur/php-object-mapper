<?php
/*
 * This file is part of php-object-mapper.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace KrzysztofMazur\ObjectMapper\Mapping\Field\ValueWriter;

/**
 * @author Krzysztof Mazur <krz@ychu.pl>
 */
interface ValueWriterInterface
{
    /**
     * @param mixed $object
     * @param mixed $value
     * @return void
     */
    public function write($object, $value);
}
