<?php namespace Nabeghe\ChillConfig;

class Utils
{
    /**
     * Checks if an array is zero-based or not.
     * @param  array  $array
     * @return bool
     */
    public static function isZeroBasedIndex(array $array): bool
    {
        return array_values($array) === $array;
        //return array_keys($array) === range(0, count($array) - 1);
    }

    /**
     * An alternative for {@see array_merge()}.<br>
     * Uses the {@see self::mergeTwo()} function for all inputs.
     * @param  array  ...$arrays
     * @return array
     */
    public static function merge(...$arrays)
    {
        $result = array_shift($arrays);
        foreach ($arrays as $array) {
            $result = static::mergeTwo($result, $array);
        }
        return $result;
    }

    /**
     * It merges the second array into the first array.
     * - If the second array is zero-based, all its items are added to the first array.
     * - If the second array is not zero-based, for each item, if the key doesn't exist in the first array,
     *   its value is added to the first array with the same key.
     *   However, if the key exists and both values are arrays,
     *   the current function is called again with the two new arrays, effectively merging nested arrays as well!
     * @param  array  $arr1
     * @param  array  $arr2
     * @return array merged array.
     */
    public static function mergeTwo(array $arr1, array $arr2): array
    {
        if (static::isZeroBasedIndex($arr2)) {
            foreach ($arr2 as $value) {
                $arr1[] = $value;
            }
        } else {
            foreach ($arr2 as $key => $value) {
                if (!array_key_exists($key, $arr1)) {
                    $arr1[$key] = $value;
                } elseif (is_array($value) && is_array($arr1[$key])) {
                    $arr1[$key] = static::mergeTwo($arr1[$key], $value);
                }
            }
        }
        return $arr1;
    }
}