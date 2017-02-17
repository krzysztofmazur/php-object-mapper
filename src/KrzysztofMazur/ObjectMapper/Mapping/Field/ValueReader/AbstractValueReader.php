<?php
/*
 * This file is part of php-object-mapper.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace KrzysztofMazur\ObjectMapper\Mapping\Field\ValueReader;

/**
 * @author Krzysztof Mazur <krz@ychu.pl>
 */
abstract class AbstractValueReader implements ValueReaderInterface
{
    /**
     * @var ValueReaderInterface
     */
    private $next;

    /**
     * @param ValueReaderInterface $next
     */
    public function __construct(ValueReaderInterface $next = null)
    {
        $this->next = $next;
    }

    /**
     * @return ValueReaderInterface
     */
    public function getNext()
    {
        return $this->next;
    }

    /**
     * {@inheritdoc}
     */
    public function read($object)
    {
        if ($object === null) {
            throw new \InvalidArgumentException("Unexpected null value");
        }
        $value = $this->readValue($object);
        if ($this->next !== null) {
            $value = $this->next->read($value);
        }

        return $value;
    }

    /**
     * @param mixed $object
     * @return mixed
     */
    abstract protected function readValue($object);
}
