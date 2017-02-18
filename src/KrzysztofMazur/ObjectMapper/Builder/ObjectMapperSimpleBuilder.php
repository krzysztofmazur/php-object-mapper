<?php
/*
 * This file is part of php-object-mapper.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace KrzysztofMazur\ObjectMapper\Builder;

use KrzysztofMazur\ObjectMapper\Mapping\Field\FieldFactory;
use KrzysztofMazur\ObjectMapper\Mapping\Field\FieldsMatchmaker;
use KrzysztofMazur\ObjectMapper\Mapping\MappingRepository;
use KrzysztofMazur\ObjectMapper\ObjectMapper;
use KrzysztofMazur\ObjectMapper\Util\InstantiatorInterface;
use KrzysztofMazur\ObjectMapper\Util\PropertyNameConverter;

/**
 * @author Krzysztof Mazur <krz@ychu.pl>
 */
class ObjectMapperSimpleBuilder extends AbstractBuilder
{
    /**
     * @var array
     */
    private $config;

    /**
     * @var InstantiatorInterface
     */
    private $instantiator;

    /**
     * @return ObjectMapperSimpleBuilder
     */
    public static function create()
    {
        return new self();
    }

    /**
     * @param array $config
     * @return $this
     */
    public function setConfig(array $config)
    {
        $this->config = $config;

        return $this;
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
     * @return ObjectMapper
     */
    public function build()
    {
        self::assertNotNull($this->instantiator, 'Instantiator should be provided');
        self::assertNotNull($this->config, 'Mapping configuration should be provided');

        $repository = new MappingRepository(
            $this->config,
            new FieldFactory($this->instantiator),
            new FieldsMatchmaker(new PropertyNameConverter())
        );

        return new ObjectMapper($this->instantiator, $repository);
    }
}
