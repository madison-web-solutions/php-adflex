<?php

namespace MadisonSolutions\Adflex;

use JsonSerializable;
use Serializable;

/**
 * Base class for various objects used by the library which share the following properties:
 * Immutable - none of the data can be changed after the object is created - it's all read-only
 * Serializable - can be serialized to and from a string using the PHP built in serialize and unserialize functions
 * JsonSerializable - can be converted to a JSON representation
 */
abstract class ImmutableBaseObj implements JsonSerializable, Serializable
{
    /**
     * Internal data array for read-only properties
     *
     * @var array
     */
    protected $data;

    /**
     * Get the value of one of the read only properties
     *
     * @param string $key The property name
     */
    public function __get($key)
    {
        return $this->data[$key] ?? null;
    }

    /**
     * Check if one of the read only properties is set
     *
     * @param string $key The property name
     */
    public function __isset($key)
    {
        return isset($this->data[$key]);
    }

    /**
     * Populate the values of the read only properties
     *
     * This function should only be called when the object is initialised,
     * either via the __construct() function or the unserialize() function
     *
     * @param array $data Array of the read-only data properties
     */
    abstract protected function populate(array $data);

    /**
     * Get the data to be used in the JSON serialization of this object
     */
    public function jsonSerialize()
    {
        return $this->data;
    }

    /**
     * Serialize this object to a string
     */
    public function serialize()
    {
        return serialize($this->data);
    }

    /**
     * Unserialize this object from a string
     */
    public function unserialize($data)
    {
        $data = unserialize($data);
        $this->populate($data);
    }
}
