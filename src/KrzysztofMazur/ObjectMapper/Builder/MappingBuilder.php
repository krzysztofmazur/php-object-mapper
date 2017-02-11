<?php

namespace KrzysztofMazur\ObjectMapper\Builder;

use KrzysztofMazur\ObjectMapper\Mapping\Mapping;
use KrzysztofMazur\ObjectMapper\Util\InitializerInterface;

class MappingBuilder
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
     * @var array
     */
    private $fields;

    /**
     * @var FieldFactory
     */
    private $fieldFactory;

    /**
     * @param InitializerInterface $initializer
     */
    public function __construct(InitializerInterface $initializer)
    {
        $this->fieldFactory = new FieldFactory($initializer);
    }

    /**
     * @param string $targetClass
     * @return $this
     */
    public function setTargetClass($targetClass)
    {
        $this->targetClass = $targetClass;

        return $this;
    }

    /**
     * @param string $sourceClass
     * @return $this
     */
    public function setSourceClass($sourceClass)
    {
        $this->sourceClass = $sourceClass;

        return $this;
    }

    /**
     * @param array $fields
     * @return $this
     */
    public function setFields($fields)
    {
        $this->fields = $fields;

        return $this;
    }

    /**
     * @return Mapping
     */
    public function build()
    {
        self::assertNotEmpty($this->sourceClass, 'Source class should be set');
        self::assertNotEmpty($this->targetClass, 'Target class should be set');
        self::assertNotEmpty($this->fields, 'Field definitions should be set');

        $fields = [];
        foreach ($this->fields as $target => $source) {
            $fields[] = $this->fieldFactory->factory($source, $target);
        }

        return new Mapping($this->sourceClass, $this->targetClass, $fields);
    }

    /**
     * @param mixed  $arg
     * @param string $message
     * @throws \InvalidArgumentException
     */
    private static function assertNotEmpty($arg, $message)
    {
        if (empty($arg)) {
            throw new \InvalidArgumentException($message);
        }
    }
}
