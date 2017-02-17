<?php
/*
 * This file is part of php-object-mapper.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace KrzysztofMazur\ObjectMapper\Util;

/**
 * @author Krzysztof Mazur <krz@ychu.pl>
 */
interface PropertyNameConverterInterface
{
    /**
     * @param string $methodName
     * @return string
     */
    public function getPropertyName($methodName);

    /**
     * @param string $propertyName
     * @param bool   $boolean
     * @return string
     */
    public function getGetterName($propertyName, $boolean = false);

    /**
     * @param string $propertyName
     * @return string
     */
    public function getSetterName($propertyName);
}
