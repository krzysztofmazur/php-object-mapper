<?php
/*
 * This file is part of php-object-mapper.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace KrzysztofMazur\ObjectMapper\Mapping\Field;

use KrzysztofMazur\ObjectMapper\Mapping\Field\ValueReader\MethodValueReader;
use KrzysztofMazur\ObjectMapper\Mapping\Field\ValueWriter\MethodValueWriter;
use KrzysztofMazur\ObjectMapper\Mapping\Field\ValueReader\PropertyValueReader;
use KrzysztofMazur\ObjectMapper\Mapping\Field\ValueWriter\PropertyValueWriter;
use KrzysztofMazur\ObjectMapper\Mapping\Field\ValueReader\ValueInstantiator;
use KrzysztofMazur\ObjectMapper\Mapping\Field\ValueReader\ValueReaderInterface;
use KrzysztofMazur\ObjectMapper\Mapping\Field\ValueWriter\ValueWriterInterface;
use KrzysztofMazur\ObjectMapper\Util\InstantiatorInterface;

/**
 * @author Krzysztof Mazur <krz@ychu.pl>
 */
class FieldFactory
{
    const CONSTRUCTOR_PATTERN = '/^new\ (.*)\(\)$/';
    const METHOD_PATTERN = '/^(\w*)\((.*)\)$/';
    const METHOD_ARGS_PATTERN = '/(["\'])(?:(?=(\\\\?))\2.)*?\1/';

    /**
     * @var InstantiatorInterface
     */
    private $instantiator;

    /**
     * @param InstantiatorInterface $instantiator
     */
    public function __construct(InstantiatorInterface $instantiator)
    {
        $this->instantiator = $instantiator;
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
            return new ValueInstantiator($matches[1], $this->instantiator);
        } else {
            return $this->getValueReaders(explode('.', $source));
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
        $last = $this->getValueReaders($parts);

        return preg_match(self::METHOD_PATTERN, $writePart, $matches)
            ? new MethodValueWriter($matches[1], $last)
            : new PropertyValueWriter($writePart, $last);
    }

    /**
     * @param array $parts
     * @return ValueReaderInterface|null
     */
    private function getValueReaders(array $parts)
    {
        $last = null;
        foreach (array_reverse($parts) as $part) {
            if (preg_match(self::METHOD_PATTERN, $part, $matches)) {
                $last = new MethodValueReader($matches[1], $this->extractArguments($matches[2]), $last);
            } else {
                $last = new PropertyValueReader($part, $last);
            }
        }

        return $last;
    }

    /**
     * @param array $matches
     * @return array
     */
    private function extractArguments($matches)
    {
        $args = [];
        if (!empty($matches)) {
            preg_match_all(self::METHOD_ARGS_PATTERN, $matches, $argMatches);
            foreach ($argMatches[0] as $match) {
                $args[] = substr($match, 1, -1);
            }
        }

        return $args;
    }
}
