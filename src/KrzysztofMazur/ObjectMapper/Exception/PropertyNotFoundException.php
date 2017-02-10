<?php

namespace KrzysztofMazur\ObjectMapper\Exception;

class PropertyNotFoundException extends MappingException
{
    /**
     * @var string
     */
    private $className;

    /**
     * @var string
     */
    private $propertyName;

    /**
     * @param string          $className
     * @param string          $propertyName
     * @param int             $code
     * @param \Exception|null $previous
     */
    public function __construct($className, $propertyName, $code = 0, \Exception $previous = null)
    {
        parent::__construct(
            sprintf("Class \"%s\" doesn't have property \"%s\"", $className, $propertyName),
            $code,
            $previous
        );
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
    public function getPropertyName()
    {
        return $this->propertyName;
    }
}
