<?php

namespace KrzysztofMazur\ObjectMapper\Util;

/**
 * @author Krzysztof Mazur <krz@ychu.pl>
 */
interface InitializerInterface
{
    /**
     * @param string $className
     * @return mixed
     */
    public function initialize($className);
}
