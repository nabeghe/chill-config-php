<?php namespace Nabeghe\ChillConfig;

/**
 * @method void|bool defaultDeepMerge(bool $value = 0)
 * @method void|string|null offsetExistsFunction(string $value = 0)
 */
#[\AllowDynamicProperties]
class ConfigBehaviors
{
    public bool $defaultDeepMerge = true;

    public ?string $offsetExistsFunction = 'isset';

    public static function new(): static
    {
        return new static();
    }

    public function __call(string $name, array $arguments)
    {
        if (array_key_exists(0, $arguments)) {
            $this->$name = $arguments[0];
            return $this;
        }
        return $this->$name ?? null;
    }
}