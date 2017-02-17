<?php
/*
 * This file is part of php-object-mapper.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

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
