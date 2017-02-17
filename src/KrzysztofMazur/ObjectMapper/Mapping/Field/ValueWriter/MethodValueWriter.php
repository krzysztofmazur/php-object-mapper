<?php
/*
 * This file is part of php-object-mapper.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace KrzysztofMazur\ObjectMapper\Mapping\Field\ValueWriter;

use KrzysztofMazur\ObjectMapper\Mapping\Field\ValueReader\ValueReaderInterface;
use KrzysztofMazur\ObjectMapper\Util\Reflection;

/**
 * @author Krzysztof Mazur <krz@ychu.pl>
 */
class MethodValueWriter extends AbstractValueWriter
{
    /**
     * @var string
     */
    private $methodName;

    /**
     * @param string               $methodName
     * @param ValueReaderInterface $valueReader
     */
    public function __construct($methodName, ValueReaderInterface $valueReader = null)
    {
        parent::__construct($valueReader);
        $this->methodName = $methodName;
    }

    /**
     * {@inheritdoc}
     */
    protected function writeValue($object, $value)
    {
        Reflection::getMethod(get_class($object), $this->methodName)->invokeArgs($object, [$value]);
    }
}
