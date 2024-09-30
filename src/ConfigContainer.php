<?php namespace Nabeghe\ChillConfig;

/**
 * ConfigContainer class.
 */
abstract class ConfigContainer
{
    public const NAME = null;

    public const DEFAULTS = [];

    public static array $_inits = [];

    protected static ChillConfig $_config;

    private function __construct()
    {
    }

    protected static abstract function _chillConfig(): ChillConfig;

    public static function _inited(): bool
    {
        $name = static::NAME;
        if ($name === null) {
            $name = static::class;
        }
        return isset(static::$_inits[$name]) && static::$_inits[$name];
    }

    protected static function _init(): void
    {
        if (static::_inited()) {
            return;
        }

        $method = '_chillConfig'; // to prevent ide error: Cannot call abstract method 'StaticReader::_chillConfig'
        static::$_config = static::$method();

        if (static::NAME === null) {
            if (static::DEFAULTS) {
                if (static::$_config->_behaviors->defaultDeepMerge) {
                    static::$_config->_options = Utils::merge(static::$_config->_options, static::DEFAULTS);
                } else {
                    foreach (static::DEFAULTS as $key => $value) {
                        if (!array_key_exists($key, static::$_config->_options)) {
                            static::$_config->$key = $value;
                        }
                    }
                }
            }
        } else {
            $array = static::$_config[static::NAME];
            $edited = false;
            if (!is_array($array)) {
                $array = [];
                $edited = true;
            }
            if (static::DEFAULTS) {
                if (static::$_config->_behaviors->defaultDeepMerge) {
                    $array = Utils::merge($array, static::DEFAULTS);
                    $edited = true;
                } else {
                    foreach (static::DEFAULTS as $key => $value) {
                        if (![array_key_exists($key, $array)]) {
                            $array[$key] = $value;
                            $edited = true;
                        }
                    }
                }
            }
            if ($edited) {
                static::$_config[static::NAME] = $array;
            }
        }

        $name = static::NAME;
        if ($name === null) {
            $name = static::class;
        }
        static::$_inits[$name] = true;
    }

    public static function &__callStatic(string $name, array $arguments)
    {
        static::_init();

        // get
        if (!array_key_exists(0, $arguments)) {
            if (static::NAME === null) {
                return static::$_config->$name;
            }
            $array = static::$_config[static::NAME];
            if (is_array($array) && isset($array[$name])) {
                return $array[$name];
            }
            $null = null;
            return $null;
        }

        // set
        if (static::NAME === null) {
            static::$_config->$name = $arguments[0];
        } else {
            static::$_config[static::NAME][$name] = $arguments[0];
        }

        $null = null;
        return $null;
    }
}