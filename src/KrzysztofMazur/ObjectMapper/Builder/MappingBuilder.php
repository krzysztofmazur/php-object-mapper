<?php

namespace KrzysztofMazur\ObjectMapper\Builder;

use KrzysztofMazur\ObjectMapper\Mapping\Mapping;

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
     * @return MappingBuilder
     */
    public static function getInstance()
    {
        return new self();
    }

    /**
     * @param FieldFactory $fieldFactory
     * @return $this
     */
    public function setFieldFactory($fieldFactory)
    {
        $this->fieldFactory = $fieldFactory;

        return $this;
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
        self::assertNotEmpty($this->sourceClass, 'Source class should be provided');
        self::assertNotEmpty($this->targetClass, 'Target class should be provided');
        self::assertNotEmpty($this->fields, 'Field definitions should be provided');
        self::assertNotEmpty($this->fieldFactory, 'Field factory should be provided');

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
