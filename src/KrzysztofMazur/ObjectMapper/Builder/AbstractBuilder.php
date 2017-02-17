<?php

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
