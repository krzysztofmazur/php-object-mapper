<?php
/*
 * This file is part of php-object-mapper.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace KrzysztofMazur\ObjectMapper\Mapping;

use KrzysztofMazur\ObjectMapper\Exception\MappingException;

/**
 * @author Krzysztof Mazur <krz@ychu.pl>
 */
interface MappingRepositoryInterface
{
    /**
     * @param string $sourceClass
     * @param string $targetClass
     * @param string $mapId
     * @return Mapping
     * @throws MappingException
     */
    public function getMapping($sourceClass, $targetClass, $mapId = null);
}
