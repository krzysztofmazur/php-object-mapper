<?php

namespace KrzysztofMazur\ObjectMapper\Mapping;

use KrzysztofMazur\ObjectMapper\Mapping\FieldFactory;
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
     * @var bool
     */
    private $fieldsAutoDetect = false;

    /**
     * @var FieldFactory
     */
    private $fieldFactory;

    /**
     * @var FieldsMatchmakerInterface
     */
    private $fieldsAutoDetector;

    /**
     * @return MappingBuilder
     *
     * @codeCoverageIgnore
     */
    public static function getInstance()
    {
        return new self();
    }

    /**
     * @param FieldFactory $fieldFactory
     * @return $this
     */
    public function setFieldFactory(FieldFactory $fieldFactory)
    {
        $this->fieldFactory = $fieldFactory;

        return $this;
    }

    /**
     * @param FieldsMatchmakerInterface $fieldsAutoDetector
     * @return $this
     */
    public function setFieldsAutoDetector(FieldsMatchmakerInterface $fieldsAutoDetector)
    {
        $this->fieldsAutoDetector = $fieldsAutoDetector;

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
    public function setFields(array $fields)
    {
        $this->fields = $fields;

        return $this;
    }

    /**
     * @param bool $fieldsAutoDetect
     * @return $this
     */
    public function setFieldsAutoDetect($fieldsAutoDetect)
    {
        $this->fieldsAutoDetect = $fieldsAutoDetect;

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
        if ($this->fieldsAutoDetect) {
            self::assertNotEmpty($this->fieldsAutoDetector, 'Fields auto detector should be provided');
            $fields = $this->fieldsAutoDetector->detect($this->sourceClass, $this->targetClass);
        }
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
