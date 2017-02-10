<?php

namespace KrzysztofMazur\ObjectMapper\Mapping;

use KrzysztofMazur\ObjectMapper\Util\InitializerInterface;

class ValueInitializer implements ValueReaderInterface
{
    /**
     * @var string
     */
    private $className;

    /**
     * @var InitializerInterface
     */
    private $initializer;

    /**
     * @param string               $className
     * @param InitializerInterface $initializer
     */
    public function __construct($className, InitializerInterface $initializer)
    {
        $this->className = $className;
        $this->initializer = $initializer;
    }

    /**
     * {@inheritdoc}
     */
    public function read($object)
    {
        return $this->initializer->initialize($this->className);
    }
}
