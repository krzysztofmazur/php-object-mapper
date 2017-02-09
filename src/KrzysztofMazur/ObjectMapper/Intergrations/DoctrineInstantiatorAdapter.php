<?php

namespace KrzysztofMazur\ObjectMapper\Intergrations;

use Doctrine\Instantiator\InstantiatorInterface;
use KrzysztofMazur\ObjectMapper\Utils\InitializerInterface;

class DoctrineInstantiatorAdapter implements InitializerInterface
{
    /**
     * @var InstantiatorInterface
     */
    private $dockerInstantiator;

    /**
     * @param InstantiatorInterface $dockerInstantiator
     */
    public function __construct(InstantiatorInterface $dockerInstantiator)
    {
        $this->dockerInstantiator = $dockerInstantiator;
    }

    /**
     * {@inheritdoc}
     */
    public function initialize($className)
    {
        return $this->dockerInstantiator->instantiate($className);
    }
}
