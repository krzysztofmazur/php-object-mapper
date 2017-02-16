<?php

namespace KrzysztofMazur\ObjectMapper\Mapping\Field\ValueWriter;

interface ReferenceGetterInterface
{
    /**
     * @param mixed $object
     * @return mixed
     */
    public function getReference($object);
}
