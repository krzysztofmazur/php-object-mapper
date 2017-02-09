<?php

namespace TestFixtures;

class SimpleObject
{
    /**
     * @var mixed
     */
    private $property1;

    /**
     * @return mixed
     */
    public function getProperty1()
    {
        return $this->property1;
    }

    /**
     * @param mixed $property1
     */
    public function setProperty1($property1)
    {
        $this->property1 = $property1;
    }
}
