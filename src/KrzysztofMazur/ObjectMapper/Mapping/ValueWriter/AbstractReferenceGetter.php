<?php

namespace KrzysztofMazur\ObjectMapper\Mapping\ValueWriter;

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
        $reference = $this->getReferenceInternal($object);
        if (!is_null($this->next)) {
            $reference = $this->next->getReference($reference);
        }

        return $reference;
    }

    /**
     * @param mixed $object
     * @return mixed
     */
    abstract protected function getReferenceInternal($object);

    /**
     * @return \ReflectionClass
     */
    protected function getReflectionClass()
    {
        return new \ReflectionClass($this->className);
    }
}
