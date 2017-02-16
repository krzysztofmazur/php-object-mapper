<?php

namespace KrzysztofMazur\ObjectMapper\Mapping\Field;

class CustomField implements FieldInterface
{
    /**
     * @var callable
     */
    private $callback;

    /**
     * @param callable $callback
     */
    public function __construct(callable $callback)
    {
        $this->callback = $callback;
    }

    /**
     * {@inheritdoc}
     */
    public function map($source, $target)
    {
        $callback = $this->callback;
        $callback($source, $target);
    }
}
