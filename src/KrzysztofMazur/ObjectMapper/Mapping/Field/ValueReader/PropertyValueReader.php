<?php
/*
 * This file is part of php-object-mapper.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace KrzysztofMazur\ObjectMapper\Mapping\Field\ValueReader;

use KrzysztofMazur\ObjectMapper\Util\Reflection;

/**
 * @author Krzysztof Mazur <krz@ychu.pl>
 */
class PropertyValueReader extends AbstractValueReader
{
    /**
     * @var string
     */
    private $propertyName;

    /**
     * @param string               $propertyName
     * @param ValueReaderInterface $next
     */
    public function __construct($propertyName, ValueReaderInterface $next = null)
    {
        parent::__construct($next);
        $this->propertyName = $propertyName;
    }

    /**
     * {@inheritdoc}
     */
    protected function readValue($object)
    {
        return Reflection::getProperty(get_class($object), $this->propertyName)->getValue($object);
    }
}
