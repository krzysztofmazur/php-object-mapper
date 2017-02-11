<?php

namespace KrzysztofMazur\ObjectMapper\Mapping\ValueWriter;

use KrzysztofMazur\ObjectMapper\Exception\NotSupportedMappingException;

abstract class AbstractReferenceGetter implements ReferenceGetterInterface
{
    /**
     * @var ReferenceGetterInterface
     */
    private $next;

    /**
     * @param ReferenceGetterInterface $next
     */
    public function __construct(ReferenceGetterInterface $next = null)
    {
        $this->next = $next;
    }

    /**
     * @return ReferenceGetterInterface
     */
    public function getNext()
    {
        return $this->next;
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
}
