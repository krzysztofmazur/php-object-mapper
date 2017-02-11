<?php

namespace KrzysztofMazur\ObjectMapper\Builder;

use KrzysztofMazur\ObjectMapper\Mapping\CustomField;
use KrzysztofMazur\ObjectMapper\Mapping\FieldInterface;

class FieldFactory
{
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
        //TODO: implement normal field factory
    }
}
