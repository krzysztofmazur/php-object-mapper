<?php

namespace KrzysztofMazur\ObjectMapper\Mapping;

use KrzysztofMazur\ObjectMapper\Mapping\CustomField;
use KrzysztofMazur\ObjectMapper\Mapping\Field;
use KrzysztofMazur\ObjectMapper\Mapping\FieldInterface;
use KrzysztofMazur\ObjectMapper\Mapping\MethodValueReader;
use KrzysztofMazur\ObjectMapper\Mapping\MethodValueWriter;
use KrzysztofMazur\ObjectMapper\Mapping\PropertyValueReader;
use KrzysztofMazur\ObjectMapper\Mapping\PropertyValueWriter;
use KrzysztofMazur\ObjectMapper\Mapping\ValueInitializer;
use KrzysztofMazur\ObjectMapper\Mapping\ValueReaderInterface;
use KrzysztofMazur\ObjectMapper\Mapping\ValueWriter\MethodReferenceGetter;
use KrzysztofMazur\ObjectMapper\Mapping\ValueWriter\PropertyReferenceGetter;
use KrzysztofMazur\ObjectMapper\Mapping\ValueWriterInterface;
use KrzysztofMazur\ObjectMapper\Util\InitializerInterface;

class FieldFactory
{
    const CONSTRUCTOR_PATTERN = '/^new\ (.*)\(\)$/';
    const METHOD_PATTERN = '/^(\w*)\(\)$/';

    /**
     * @var InitializerInterface
     */
    private $initializer;

    /**
     * @param InitializerInterface $initializer
     */
    public function __construct(InitializerInterface $initializer)
    {
        $this->initializer = $initializer;
    }

    /**
     * @param string|callable $source
     * @param string          $target
     * @return FieldInterface
     */
    public function factory($source, $target)
    {
        if (is_callable($source)) {
            return new CustomField($source);
        }

        return new Field($this->readerFactory($source), $this->writeFactory($target));
    }

    /**
     * @param string $source
     * @return ValueReaderInterface
     */
    private function readerFactory($source)
    {
        if (preg_match(self::CONSTRUCTOR_PATTERN, $source, $matches)) {
            return new ValueInitializer($matches[1], $this->initializer);
        } else {
            $parts = explode('.', $source);
            $last = null;
            foreach (array_reverse($parts) as $part) {
                if (preg_match(self::METHOD_PATTERN, $part, $matches)) {
                    $last = new MethodValueReader($matches[1], [], $last);
                } else {
                    $last = new PropertyValueReader($part, $last);
                }
            }

            return $last;
        }
    }

    /**
     * @param string $target
     * @return ValueWriterInterface
     */
    private function writeFactory($target)
    {
        $parts = explode('.', $target);
        $writePart = array_pop($parts);
        $last = null;
        foreach (array_reverse($parts) as $part) {
            if (preg_match(self::METHOD_PATTERN, $part, $matches)) {
                $last = new MethodReferenceGetter($matches[1], [], $last);
            } else {
                $last = new PropertyReferenceGetter($part, $last);
            }
        }

        return preg_match(self::METHOD_PATTERN, $writePart, $matches)
            ? new MethodValueWriter($matches[1], $last)
            : new PropertyValueWriter($writePart, $last);
    }
}
