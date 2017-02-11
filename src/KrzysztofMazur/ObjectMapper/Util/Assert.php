<?php

namespace KrzysztofMazur\ObjectMapper\Util;

class Assert
{
    /**
     * @codeCoverageIgnore
     */
    private function __construct()
    {
    }

    /**
     * @param mixed  $arg
     * @param string $message
     */
    public static function notNull($arg, $message = 'Should be not null')
    {
        if (is_null($arg)) {
            throw new \InvalidArgumentException($message);
        }
    }
}
