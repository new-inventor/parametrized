<?php
/**
 * Date: 03.02.17
 * Time: 11:03
 */

namespace NewInventor\Parametrized\Exceptions;


use Exception;

class UndefinedPropertyException extends \LogicException
{
    public function __construct($propertyName = '', $class = '', $code = 0, Exception $previous = null)
    {
        parent::__construct('Undefined property: "' . $class . '::$' . $propertyName . '"', $code, $previous);
    }
}