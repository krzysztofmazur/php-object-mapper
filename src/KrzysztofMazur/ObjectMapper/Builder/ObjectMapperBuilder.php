<?php
/*
 * This file is part of php-object-mapper.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace KrzysztofMazur\ObjectMapper\Builder;

use KrzysztofMazur\ObjectMapper\Mapping\MappingRepositoryInterface;
use KrzysztofMazur\ObjectMapper\ObjectMapper;
use KrzysztofMazur\ObjectMapper\Util\InstantiatorInterface;

/**
 * @author Krzysztof Mazur <krz@ychu.pl>
 */
class ObjectMapperBuilder extends AbstractBuilder
{
    /**
     * @var InstantiatorInterface
     */
    private $instantiator;

    /**
     * @var MappingRepositoryInterface
     */
    private $repository;

    /**
     * @return ObjectMapperBuilder
     */
    public static function create()
    {
        return new self();
    }

    /**
     * @param InstantiatorInterface $instantiator
     * @return $this
     */
    public function setInstantiator(InstantiatorInterface $instantiator)
    {
        $this->instantiator = $instantiator;

        return $this;
    }

    /**
     * @param MappingRepositoryInterface $repository
     * @return $this
     */
    public function setRepository(MappingRepositoryInterface $repository)
    {
        $this->repository = $repository;

        return $this;
    }

    /**
     * @return ObjectMapper
     */
    public function build()
    {
        self::assertNotNull($this->instantiator, 'Instantiator should be provided');
        self::assertNotNull($this->repository, 'Mapping repository should be provided');

        return new ObjectMapper($this->instantiator, $this->repository);
    }
}
