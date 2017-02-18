<?php
/*
 * This file is part of php-object-mapper.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace KrzysztofMazur\ObjectMapper;

use KrzysztofMazur\ObjectMapper\Mapping\MappingRepositoryInterface;
use KrzysztofMazur\ObjectMapper\Util\InstantiatorInterface;

/**
 * @author Krzysztof Mazur <krz@ychu.pl>
 */
class ObjectMapper implements ObjectMapperInterface
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
     * @param InstantiatorInterface      $instantiator
     * @param MappingRepositoryInterface $mappingRepository
     */
    public function __construct(InstantiatorInterface $instantiator, MappingRepositoryInterface $mappingRepository)
    {
        $this->instantiator = $instantiator;
        $this->repository = $mappingRepository;
    }

    /**
     * {@inheritdoc}
     */
    public function map($source, $targetClass, $mapId = null)
    {
        $object = $this->instantiator->instantiate($targetClass);
        $this->mapToObject($source, $object, $mapId);

        return $object;
    }

    /**
     * {@inheritdoc}
     */
    public function mapToObject($source, $target, $mapId = null)
    {
        $this->repository->getMapping(get_class($source), get_class($target), $mapId)->map($source, $target);

        return $target;
    }
}
