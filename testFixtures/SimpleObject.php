<?php

namespace TestFixtures;

class SimpleObject
{
    /**
     * @var string
     */
    private $property1;

    /**
     * @return string
     */
    public function getProperty1()
    {
        return $this->property1;
    }

    /**
     * @param string $property1
     */
    public function setProperty1($property1)
    {
        $this->property1 = $property1;
    }
}
