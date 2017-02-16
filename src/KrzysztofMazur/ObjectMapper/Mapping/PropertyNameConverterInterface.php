<?php

namespace KrzysztofMazur\ObjectMapper\Mapping;

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
