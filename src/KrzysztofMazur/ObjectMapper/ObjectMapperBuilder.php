<?php

namespace KrzysztofMazur\ObjectMapper;

use KrzysztofMazur\ObjectMapper\Util\Assert;
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
        Assert::notNull($this->initializer, 'Initializer is mandatory');

        return new ObjectMapper($this->initializer);
    }
}
