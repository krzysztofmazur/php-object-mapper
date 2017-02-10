<?php

namespace KrzysztofMazur\ObjectMapper\Exception;

class MethodNotFoundException extends MappingException
{
    /**
     * @var string
     */
    private $className;

    /**
     * @var string
     */
    private $methodName;

    /**
     * @param string          $className
     * @param string          $methodName
     * @param int             $code
     * @param \Exception|null $previous
     */
    public function __construct($className, $methodName, $code = 0, \Exception $previous = null)
    {
        parent::__construct(
            sprintf("Class \"%s\" doesn't have method \"%s\"", $className, $methodName),
            $code,
            $previous
        );
        $this->className = $className;
        $this->methodName = $methodName;
    }

    /**
     * @return string
     */
    public function getClassName()
    {
        return $this->className;
    }

    /**
     * @return string
     */
    public function getMethodName()
    {
        return $this->methodName;
    }
}
