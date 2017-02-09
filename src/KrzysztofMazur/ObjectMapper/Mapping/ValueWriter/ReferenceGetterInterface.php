<?php

namespace KrzysztofMazur\ObjectMapper\Mapping\ValueWriter;

interface ReferenceGetterInterface
{
    /**
     * @param mixed $object
     * @return mixed
     */
    public function getReference($object);
}
