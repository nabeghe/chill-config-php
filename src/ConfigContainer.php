<?php namespace Nabeghe\ChillConfig;

/**
 * ConfigContainer class.
 */
abstract class ConfigContainer
{
    public const NAME = null;

    public const DEFAULTS = [];

    public static array $_inits = [];

    private function __construct()
    {
    }

    protected static function _chillConfig(): ?ChillConfig
    {
        return $GLOBALS['config'] ?? null;
    }

    public static function _inited(): bool
    {
        $name = static::NAME ?? static::class;
        return isset(static::$_inits[$name]) && static::$_inits[$name];
    }

    protected static function _init(): void
    {
        if (static::_inited()) {
            return;
        }

        /**
         * @var ChillConfig $config
         */
        $method = '_chillConfig'; // to prevent ide error: Cannot call abstract method 'StaticReader::_chillConfig'
        $config = static::$method();

        if (static::NAME === null) {
            if (static::DEFAULTS) {
                if ($config->_behaviors->defaultDeepMerge) {
                    $config->_options = Utils::merge($config->_options, static::DEFAULTS);
                } else {
                    foreach (static::DEFAULTS as $key => $value) {
                        if (!array_key_exists($key, $config->_options)) {
                            $config->$key = $value;
                        }
                    }
                }
            }
        } else {
            $array = $config[static::NAME];
            $edited = false;
            if (!is_array($array)) {
                $array = [];
                $edited = true;
            }
            if (static::DEFAULTS) {
                if ($config->_behaviors->defaultDeepMerge) {
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
                $config[static::NAME] = $array;
            }
        }

        $name = static::NAME ?? static::class;
        static::$_inits[$name] = $config;
    }

    public static function &__callStatic(string $name, array $arguments)
    {
        static::_init();

        $config_name = static::NAME ?? static::class;
        $config = static::$_inits[$config_name];

        // get
        if (!array_key_exists(0, $arguments)) {
            if (static::NAME === null) {
                return $config->$name;
            }
            $array = $config[static::NAME];
            if (is_array($array) && isset($array[$name])) {
                return $array[$name];
            }
            $null = null;
            return $null;
        }

        // set
        if (static::NAME === null) {
            $config->$name = $arguments[0];
        } else {
            $config[static::NAME][$name] = $arguments[0];
        }

        $null = null;
        return $null;
    }
}