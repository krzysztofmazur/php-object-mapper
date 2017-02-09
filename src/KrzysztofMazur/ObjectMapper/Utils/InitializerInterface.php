<?php

namespace KrzysztofMazur\ObjectMapper\Utils;

interface InitializerInterface
{
    /**
     * @param string $className
     * @return mixed
     */
    public function initialize($className);
}
