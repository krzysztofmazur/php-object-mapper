<?php
/*
 * This file is part of php-object-mapper.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace KrzysztofMazur\ObjectMapper\Mapping\Field\ValueReader;

use KrzysztofMazur\ObjectMapper\Util\InstantiatorInterface;

/**
 * @author Krzysztof Mazur <krz@ychu.pl>
 */
class ValueInstantiator implements ValueReaderInterface
{
    /**
     * @var string
     */
    private $className;

    /**
     * @var InstantiatorInterface
     */
    private $instantiator;

    /**
     * @param string                $className
     * @param InstantiatorInterface $instantiator
     */
    public function __construct($className, InstantiatorInterface $instantiator)
    {
        $this->className = $className;
        $this->instantiator = $instantiator;
    }

    /**
     * {@inheritdoc}
     */
    public function read($object)
    {
        return $this->instantiator->instantiate($this->className);
    }
}
