<?php

namespace KrzysztofMazur\ObjectMapper\Exception;

use Exception;

/**
 * @author Krzysztof Mazur <krz@ychu.pl>
 */
class NotSupportedMappingException extends MappingException
{
    /**
     * @param string         $className1
     * @param string         $className2
     * @param int            $code
     * @param Exception|null $previous
     */
    public function __construct($className1, $className2 = null, $code = 0, Exception $previous = null)
    {
        $message = is_null($className2)
            ? sprintf("Class \"%s\" is not supported", $className1)
            : sprintf("Mapping from \"%s\" to \"%s\" is not supported", $className1, $className2);
        parent::__construct($message, $code, $previous);
    }
}
