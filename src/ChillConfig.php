<?php namespace Nabeghe\ChillConfig;

#[\AllowDynamicProperties]
class ChillConfig extends \stdClass implements \ArrayAccess, \JsonSerializable
{
    /**
     * Default values for keys that can be overridden in child classes.
     */
    public const DEFAULTS = [];

    /**
     * Nested configs: keys are config names, and values are the config class.
     */
    public const NESTS = [];

    /**
     * @param  array  $_options  Optional. All desired keys & values.
     * @param  ConfigBehaviors|null  $_behaviors  Optional. Config behavior.
     */
    public function __construct(public array $_options = [], public ?ConfigBehaviors $_behaviors = null)
    {
        if ($this->_behaviors === null) {
            $this->_behaviors = new ConfigBehaviors();
        }

        // Injection of default values.
        if (static::DEFAULTS) {
            if ($this->_behaviors->defaultDeepMerge) {
                $this->_options = Utils::merge($this->_options, static::DEFAULTS);
            } else {
                foreach (static::DEFAULTS as $key => $value) {
                    if (!array_key_exists($key, $this->_options)) {
                        $this->_options[$key] = $value;
                    }
                }
            }
        }
    }

    /**
     * The magical `get` method for reading option array values through the dynamic fields of the config object.
     * @param  string  $name  The option name.
     * @return mixed Returns the value of an option by reference.
     */
    public function &__get($name)
    {
        if (!isset($this->_options[$name])) {
            if (isset(static::NESTS[$name])) {
                $nested_config_class = static::NESTS[$name];
                $this->_options[$name] = new $nested_config_class();
            } else {
                $this->_options[$name] = null;
            }
        } elseif (isset(static::NESTS[$name])) {
            $nested_config_class = static::NESTS[$name];
            if (!($this->_options[$name] instanceof $nested_config_class)) {
                if (!is_array($this->_options[$name])) {
                    $this->_options[$name] = [];
                }
                $this->_options[$name] = new $nested_config_class($this->_options[$name]);
            }
        }
        return $this->_options[$name];
    }

    /**
     * The magical `set` method for changing the value of an option in the array through the object's fields.
     * @param  string  $name  The option name.
     * @param  string  $value  The value.
     */
    public function __set($name, $value)
    {
        $this->_options[$name] = $value;
    }

    /**
     * The magical `call` method for accessing options through dynamic methods,
     * with the ability to change option values if the first parameter is provided.
     * @param  string  $name  The option or method name.
     * @param  array  $arguments  The method arguments.
     * @return $this|mixed|null The config object, when modified; and returns the option value upon reading if the first parameter is not present in the method.
     */
    public function &__call($name, $arguments)
    {
        if (array_key_exists(0, $arguments)) {
            $this->__set($name, $arguments[0]);
            return $this;
        }
        return $this->__get($name);
    }

    #[\ReturnTypeWillChange]
    public function offsetExists($offset)
    {
        $function = $this->_behaviors->offsetExistsFunction;
        if ($function === null || $function == 'isset') {
            return isset($this->_options);
        }
        return $function($offset, $this->_options);
    }

    #[\ReturnTypeWillChange]
    public function &offsetGet($offset)
    {
        return $this->__get($offset);
    }

    #[\ReturnTypeWillChange]
    public function offsetSet($offset, $value)
    {
        $this->__set($offset, $value);
    }

    #[\ReturnTypeWillChange]
    public function offsetUnset($offset)
    {
        unset($this->$offset);
        unset($this->_options[$offset]);
    }

    public function jsonSerialize(): array
    {
        foreach ($this->_options as $key => $value) {
            if (isset($this->_options[$key]) === null) {
                unset($this->_options[$key]);
            }
        }
        return $this->_options;
    }
}