<?php

namespace KrzysztofMazur\ObjectMapper\Util;

interface InitializerInterface
{
    /**
     * @param string $className
     * @return mixed
     */
    public function initialize($className);
}
