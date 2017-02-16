<?php

namespace KrzysztofMazur\ObjectMapper\Exception;

/**
 * @author Krzysztof Mazur <krz@ychu.pl>
 */
class MappingException extends \Exception
{
    /**
     * @param string $sourceClass
     * @param string $targetClass
     * @return MappingException
     */
    public static function createNotSupportedMapping($sourceClass, $targetClass)
    {
        return new MappingException(
            sprintf("Mapping from \"%s\" to \"%s\" is not supported", $sourceClass, $targetClass)
        );
    }

    /**
     * @return MappingException
     */
    public static function createNotSupportedObjectTypes()
    {
        return new MappingException("Not supported object types");
    }
}
