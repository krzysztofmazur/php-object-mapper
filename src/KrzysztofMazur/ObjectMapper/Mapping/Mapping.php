<?php

namespace KrzysztofMazur\ObjectMapper\Mapping;

use KrzysztofMazur\ObjectMapper\Exception\MappingException;
use KrzysztofMazur\ObjectMapper\Exception\NotSupportedMappingException;

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
     * @var Field[]
     */
    private $fields;

    /**
     * @param string  $sourceClass
     * @param string  $targetClass
     * @param Field[] $fields
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
            throw new NotSupportedMappingException(get_class($source), get_class($target));
        }

        foreach ($this->fields as $field) {
            $field->map($source, $target);
        }
    }
}
