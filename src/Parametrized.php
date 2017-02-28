<?php
/**
 * Date: 27.01.17
 * Time: 14:35
 */

namespace NewInventor\Parametrized;


use NewInventor\Parametrized\Exceptions\UndefinedPropertyException;

/**
 * Trait Parametrized
 * @package App\Common
 */
trait Parametrized
{
    protected $parameters = [];

    /**
     * @param array $data
     */
    public function load(array $data = [])
    {
        $merged = array_merge(
            static::$defaults,
            $data
        );
        $this->parameters = array_intersect_key($merged, static::$defaults);
    }

    /**
     * @param array $data
     * @return static
     */
    public static function create(array $data = [])
    {
        $newEl = new static();
        $newEl->load($data);
        return $newEl;
    }

    /**
     * @param string $name
     * @return bool
     * @throws UndefinedPropertyException
     */
    public function __isset($name)
    {
        $this->failIfNotSelfProperty($name);
        return isset($this->parameters[$name]);
    }

    /**
     * @param string $name
     * @return bool
     * @throws UndefinedPropertyException
     */
    public function __unset($name)
    {
        $this->failIfNotSelfProperty($name);
        return $this->parameters[$name] = static::$defaults[$name];
    }

    /**
     * @param string $name
     * @param $value
     * @throws UndefinedPropertyException
     */
    public function __set($name, $value)
    {
        $this->failIfNotSelfProperty($name);
        $this->parameters[$name] = $value;
    }

    /**
     * @param string $name
     * @return mixed
     * @throws UndefinedPropertyException
     */
    public function __get($name)
    {
        $this->failIfNotSelfProperty($name);
        return $this->parameters[$name];
    }

    /**
     * @param string $name
     * @throws UndefinedPropertyException
     */
    protected function failIfNotSelfProperty($name)
    {
        if ($this->hasProperty($name)) {
            return;
        }
        $class = get_class($this);
        throw new UndefinedPropertyException($name, $class);
    }

    /**
     * @param string $name
     * @return bool
     */
    public function hasProperty($name)
    {
        return array_key_exists($name, static::$defaults);
    }

    /**
     * @param string $name
     * @param array $arguments
     * @return $this
     * @throws \BadMethodCallException
     * @throws \InvalidArgumentException
     */
    public function __call($name, $arguments)
    {
        if (!$this->hasProperty($name)) {
            throw new \BadMethodCallException("Setter function '$name' does not exists.");
        }
        if (count($arguments) !== 1) {
            throw new \InvalidArgumentException("Setter function '$name' must have 1 argument.");
        }
        $this->parameters[$name] = $arguments[0];
        return $this;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return $this->parameters;
    }

    /**
     * @param array $map
     * @param bool $strict
     * @return array
     */
    public function map(array $map = [], $strict = false)
    {
        $res = [];
        foreach($this->parameters as $name => $value) {
            if($strict && !array_key_exists($name, $map)) {
                continue;
            }
            $res[$map[$name]] = $value;
        }

        return $res;
    }
}