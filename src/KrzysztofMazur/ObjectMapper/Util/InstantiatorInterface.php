<?php
/*
 * This file is part of php-object-mapper.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace KrzysztofMazur\ObjectMapper\Util;

/**
 * @author Krzysztof Mazur <krz@ychu.pl>
 */
interface InstantiatorInterface
{
    /**
     * @param string $className
     * @return mixed
     */
    public function instantiate($className);
}
