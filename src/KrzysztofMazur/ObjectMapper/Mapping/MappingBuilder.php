<?php

namespace KrzysztofMazur\ObjectMapper\Mapping;

use KrzysztofMazur\ObjectMapper\Mapping\Field\FieldFactory;
use KrzysztofMazur\ObjectMapper\Mapping\Field\FieldsMatchmakerInterface;

/**
 * @author Krzysztof Mazur <krz@ychu.pl>
 */
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
    private $fieldsAutoMatch = false;

    /**
     * @var FieldFactory
     */
    private $fieldFactory;

    /**
     * @var FieldsMatchmakerInterface
     */
    private $fieldsMatchmaker;

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
     * @param FieldsMatchmakerInterface $fieldsMatchmaker
     * @return $this
     */
    public function setFieldsMatchmaker(FieldsMatchmakerInterface $fieldsMatchmaker)
    {
        $this->fieldsMatchmaker = $fieldsMatchmaker;

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
     * @param bool $fieldsAutoMatch
     * @return $this
     */
    public function setFieldsAutoMatch($fieldsAutoMatch)
    {
        $this->fieldsAutoMatch = $fieldsAutoMatch;

        return $this;
    }

    /**
     * @return Mapping
     */
    public function build()
    {
        self::assertNotEmpty($this->sourceClass, 'Source class should be provided');
        self::assertNotEmpty($this->targetClass, 'Target class should be provided');
        self::assertNotEmpty($this->fieldFactory, 'Field factory should be provided');

        $fields = [];
        if ($this->fieldsAutoMatch) {
            self::assertNotEmpty($this->fieldsMatchmaker, 'Fields auto detector should be provided');
            $this->fields = array_merge(
                $this->fieldsMatchmaker->match($this->sourceClass, $this->targetClass),
                $this->fields
            );
        }
        foreach ($this->fields as $target => $source) {
            $fields[] = $this->fieldFactory->factory($source, $target);
        }
        if (empty($fields)) {
            self::assertNotEmpty($this->fields, 'Field definitions should be provided');
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
