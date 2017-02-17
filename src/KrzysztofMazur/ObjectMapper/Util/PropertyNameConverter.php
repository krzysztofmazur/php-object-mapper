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
class PropertyNameConverter implements PropertyNameConverterInterface
{
    const ACCESSOR_PREFIXES = ['get', 'is', 'set'];

    /**
     * {@inheritdoc}
     */
    public function getPropertyName($methodName)
    {
        $this->checkMethodName($methodName);

        return lcfirst($this->removeAllPrefixes(self::ACCESSOR_PREFIXES, $methodName));
    }

    /**
     * {@inheritdoc}
     */
    public function getGetterName($propertyName, $boolean = false)
    {
        $this->checkPropertyName($propertyName);

        return sprintf("%s%s", $boolean ? 'is' : 'get', ucfirst($propertyName));
    }

    /**
     * {@inheritdoc}
     */
    public function getSetterName($propertyName)
    {
        $this->checkPropertyName($propertyName);

        return sprintf("set%s", ucfirst($propertyName));
    }

    /**
     * @param string $methodName
     */
    private function checkMethodName($methodName)
    {
        if ($methodName === null || $methodName === '') {
            throw new \InvalidArgumentException("Invalid accessor name");
        }
        if (in_array($methodName, self::ACCESSOR_PREFIXES)) {
            throw new \InvalidArgumentException("Invalid accessor name");
        }
        if (!$this->hasOneOfPrefixes(self::ACCESSOR_PREFIXES, $methodName)) {
            throw new \InvalidArgumentException("Invalid accessor name");
        }
    }

    private function checkPropertyName($propertyName)
    {
        if ($propertyName === null || $propertyName === '') {
            throw new \InvalidArgumentException("Invalid property name");
        }
    }

    /**
     * @param string[] $prefixes
     * @param string   $value
     * @return string
     */
    private function removeAllPrefixes(array $prefixes, $value)
    {
        foreach ($prefixes as $prefix) {
            $value = $this->removePrefix($prefix, $value);
        }

        return $value;
    }

    /**
     * @param string $prefix
     * @param string $value
     * @return string
     */
    private function removePrefix($prefix, $value)
    {
        return $this->hasPrefix($prefix, $value) ? substr($value, strlen($prefix)) : $value;
    }

    /**
     * @param string $prefix
     * @param string $value
     * @return bool
     */
    private function hasPrefix($prefix, $value)
    {
        return strpos($value, $prefix) === 0;
    }

    /**
     * @param string[] $prefixes
     * @param bool     $value
     * @return bool
     */
    private function hasOneOfPrefixes(array $prefixes, $value)
    {
        foreach ($prefixes as $prefix) {
            if ($this->hasPrefix($prefix, $value)) {
                return true;
            }
        }

        return false;
    }
}
