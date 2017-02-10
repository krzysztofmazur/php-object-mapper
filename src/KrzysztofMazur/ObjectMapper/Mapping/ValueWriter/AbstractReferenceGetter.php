<?php

namespace KrzysztofMazur\ObjectMapper\Mapping\ValueWriter;

use KrzysztofMazur\ObjectMapper\Exception\NotSupportedMappingException;

abstract class AbstractReferenceGetter implements ReferenceGetterInterface
{
    /**
     * @var string
     */
    private $className;

    /**
     * @var ReferenceGetterInterface
     */
    private $next;

    /**
     * @param string                   $className
     * @param ReferenceGetterInterface $next
     */
    public function __construct($className, ReferenceGetterInterface $next = null)
    {
        $this->className = $className;
        $this->next = $next;
    }

    /**
     * {@inheritdoc}
     */
    public function getReference($object)
    {
        if ($this->className !== get_class($object)) {
            throw new NotSupportedMappingException(get_class($object));
        }
        $reference = $this->getReferenceInternal($object);
        if (!is_null($this->next)) {
            $reference = $this->next->getReference($reference);
        }

        return $reference;
    }

    /**
     * @return string
     */
    protected function getClassName()
    {
        return $this->className;
    }

    /**
     * @param mixed $object
     * @return mixed
     */
    abstract protected function getReferenceInternal($object);
}
