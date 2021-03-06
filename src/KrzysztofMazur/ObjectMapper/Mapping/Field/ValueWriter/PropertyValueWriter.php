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
class PropertyValueWriter extends AbstractValueWriter
{
    /**
     * @var string
     */
    private $propertyName;

    /**
     * @param string               $propertyName
     * @param ValueReaderInterface $valueReader
     */
    public function __construct($propertyName, ValueReaderInterface $valueReader = null)
    {
        parent::__construct($valueReader);
        $this->propertyName = $propertyName;
    }

    /**
     * {@inheritdoc}
     */
    protected function writeValue($object, $value)
    {
        Reflection::getProperty(get_class($object), $this->propertyName)->setValue($object, $value);
    }
}
