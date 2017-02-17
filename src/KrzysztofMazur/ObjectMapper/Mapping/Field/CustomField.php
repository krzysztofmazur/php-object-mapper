<?php
/*
 * This file is part of php-object-mapper.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace KrzysztofMazur\ObjectMapper\Mapping\Field;

/**
 * @author Krzysztof Mazur <krz@ychu.pl>
 */
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
        call_user_func_array($this->callback, [$source, $target]);
    }
}
