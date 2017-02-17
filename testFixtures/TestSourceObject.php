<?php

namespace TestFixtures;

/**
 * @author Krzysztof Mazur <krz@ychu.pl>
 */
class TestSourceObject
{
    /**
     * @var int
     */
    private $width;

    /**
     * @var int
     */
    private $height;

    /**
     * @return int
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * @return int
     */
    public function getHeight()
    {
        return $this->height;
    }

    /**
     * @return int
     */
    public function getArea()
    {
        return $this->height * $this->width;
    }
}
