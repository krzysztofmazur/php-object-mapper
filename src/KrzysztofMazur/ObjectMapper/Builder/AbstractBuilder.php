<?php
/*
 * This file is part of php-object-mapper.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace KrzysztofMazur\ObjectMapper\Builder;

/**
 * @author Krzysztof Mazur <krz@ychu.pl>
 */
abstract class AbstractBuilder
{
    /**
     * @param mixed  $arg
     * @param string $message
     */
    protected static function assertNotNull($arg, $message)
    {
        if (is_null($arg)) {
            throw new \InvalidArgumentException($message);
        }
    }
}
