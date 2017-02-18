<?php
/*
 * This file is part of php-object-mapper.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace KrzysztofMazur\ObjectMapper\Integration;

use Doctrine\Instantiator\InstantiatorInterface as DoctrineInstantiator;
use KrzysztofMazur\ObjectMapper\Util\InstantiatorInterface;

/**
 * @author Krzysztof Mazur <krz@ychu.pl>
 */
class DoctrineInstantiatorAdapter implements InstantiatorInterface
{
    /**
     * @var DoctrineInstantiator
     */
    private $doctrineInstantiator;

    /**
     * @param DoctrineInstantiator $doctrineInstantiator
     */
    public function __construct(DoctrineInstantiator $doctrineInstantiator)
    {
        $this->doctrineInstantiator = $doctrineInstantiator;
    }

    /**
     * {@inheritdoc}
     */
    public function instantiate($className)
    {
        return $this->doctrineInstantiator->instantiate($className);
    }
}
