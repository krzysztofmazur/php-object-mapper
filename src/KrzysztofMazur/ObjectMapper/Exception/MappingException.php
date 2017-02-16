<?php

namespace KrzysztofMazur\ObjectMapper\Exception;

/**
 * @author Krzysztof Mazur <krz@ychu.pl>
 */
class MappingException extends \Exception
{
    public static function createNotSupportedMapping($sourceClass, $targetClass)
    {
        return new MappingException(
            sprintf("Mapping from \"%s\" to \"%s\" is not supported", $sourceClass, $targetClass)
        );
    }
}
