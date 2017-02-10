<?php

namespace KrzysztofMazur\ObjectMapper;

use KrzysztofMazur\ObjectMapper\Util\InitializerInterface;

class ObjectMapperBuilder
{
    /**
     * @var InitializerInterface
     */
    private $initializer;

    /**
     * @param InitializerInterface $initializer
     * @return $this
     */
    public function setInitializer(InitializerInterface $initializer)
    {
        $this->initializer = $initializer;

        return $this;
    }

    /**
     * @return ObjectMapper
     */
    public function build()
    {
        return new ObjectMapper($this->initializer);
    }
}
