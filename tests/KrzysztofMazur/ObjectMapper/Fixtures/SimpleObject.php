<?php
/*
 * This file is part of php-object-mapper.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tests\KrzysztofMazur\ObjectMapper\Fixtures;

/**
 * @author Krzysztof Mazur <krz@ychu.pl>
 */
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
