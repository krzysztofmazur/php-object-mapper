<?php

namespace Tests\KrzysztofMazur\ObjectMapper\Util;

use KrzysztofMazur\ObjectMapper\Util\PropertyNameConverter;
use KrzysztofMazur\ObjectMapper\Util\PropertyNameConverterInterface;
use PHPUnit\Framework\TestCase;

class PropertyNameConverterTest extends TestCase
{
    /**
     * @var PropertyNameConverterInterface
     */
    private $converter;

    public function setUp()
    {
        $this->converter = new PropertyNameConverter();
    }

    /**
     * @return array
     */
    public function dataGetPropertyNameSuccess()
    {
        return [
            ['property1', 'getProperty1'],
            ['property1', 'isProperty1'],
            ['property1', 'setProperty1'],
            ['x', 'getX'],
        ];
    }

    /**
     * @param string $propertyName
     * @param string $methodName
     *
     * @dataProvider dataGetPropertyNameSuccess
     */
    public function testGetPropertyNameSuccess($propertyName, $methodName)
    {
        self::assertEquals($propertyName, $this->converter->getPropertyName($methodName));
    }

    /**
     * @return array
     */
    public function dataGetPropertyNameFail()
    {
        return [
            ['get'],
            ['checkTest'],
            ['xyz'],
            [''],
            [null],
        ];
    }

    /**
     * @param string $methodName
     *
     * @dataProvider dataGetPropertyNameFail
     * @expectedException \InvalidArgumentException
     */
    public function testGetPropertyNameFail($methodName)
    {
        $this->converter->getPropertyName($methodName);
    }

    /**
     * @return array
     */
    public function dataGetGetterNameSuccess()
    {
        return [
            ['getProperty1', 'property1', false],
            ['isActive', 'active', true],
            ['isX', 'x', true],
        ];
    }

    /**
     * @param string $getterName
     * @param string $propertyName
     * @param bool   $boolean
     *
     * @dataProvider dataGetGetterNameSuccess
     */
    public function testGetGetterNameSuccess($getterName, $propertyName, $boolean)
    {
        self::assertEquals($getterName, $this->converter->getGetterName($propertyName, $boolean));
    }

    /**
     * @return array
     */
    public function dataGetGetterNameFail()
    {
        return [
            [''],
            [null],
        ];
    }

    /**
     * @param string $propertyName
     *
     * @dataProvider dataGetGetterNameFail
     * @expectedException \InvalidArgumentException
     */
    public function testGetGetterNameFail($propertyName)
    {
        $this->converter->getGetterName($propertyName);
    }

    /**
     * @return array
     */
    public function dataGetSetterNameSuccess()
    {
        return [
            ['setProperty1', 'property1'],
            ['setActive', 'active'],
            ['setX', 'x'],
        ];
    }

    /**
     * @param string $setterName
     * @param string $propertyName
     *
     * @dataProvider dataGetSetterNameSuccess
     */
    public function testGetSetterNameSuccess($setterName, $propertyName)
    {
        self::assertEquals($setterName, $this->converter->getSetterName($propertyName));
    }

    /**
     * @return array
     */
    public function dataGetSetterNameFail()
    {
        return [
            [''],
            [null],
        ];
    }

    /**
     * @param string $propertyName
     *
     * @dataProvider dataGetSetterNameFail
     * @expectedException \InvalidArgumentException
     */
    public function testGetSetterNameFail($propertyName)
    {
        $this->converter->getSetterName($propertyName);
    }
}
