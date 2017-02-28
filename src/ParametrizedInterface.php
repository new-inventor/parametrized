<?php
/**
 * Date: 28.02.17
 * Time: 14:23
 */

namespace NewInventor\Parametrized;


interface ParametrizedInterface
{
    /**
     * @param array $data
     */
    public function load(array $data = []);

    /**
     * @param array $data
     * @return static
     */
    public static function create(array $data = []);

    /**
     * @param string $name
     * @return bool
     */
    public function hasProperty($name);

    /**
     * @return array
     */
    public function toArray();

    /**
     * @param array $map
     * @param bool $strict
     * @return array
     */
    public function map(array $map = [], $strict = false);
}