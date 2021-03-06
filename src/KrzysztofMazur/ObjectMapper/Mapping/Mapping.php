<?php
/*
 * This file is part of php-object-mapper.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace KrzysztofMazur\ObjectMapper\Mapping;

use KrzysztofMazur\ObjectMapper\Exception\MappingException;
use KrzysztofMazur\ObjectMapper\Mapping\Field\FieldInterface;

/**
 * @author Krzysztof Mazur <krz@ychu.pl>
 */
class Mapping
{
    /**
     * @var string
     */
    private $sourceClass;

    /**
     * @var string
     */
    private $targetClass;

    /**
     * @var FieldInterface[]
     */
    private $fields;

    /**
     * @param string           $sourceClass
     * @param string           $targetClass
     * @param FieldInterface[] $fields
     */
    public function __construct($sourceClass, $targetClass, array $fields)
    {
        $this->sourceClass = $sourceClass;
        $this->targetClass = $targetClass;
        $this->fields = $fields;
    }

    /**
     * @param string $sourceClass
     * @param string $targetClass
     * @return bool
     */
    public function supports($sourceClass, $targetClass)
    {
        return $this->sourceClass === $sourceClass && $this->targetClass === $targetClass;
    }

    /**
     * @param mixed $source
     * @param mixed $target
     * @throws MappingException
     */
    public function map($source, $target)
    {
        if (!$this->supports(get_class($source), get_class($target))) {
            throw MappingException::createNotSupportedObjectTypes();
        }

        foreach ($this->fields as $field) {
            $field->map($source, $target);
        }
    }
}
