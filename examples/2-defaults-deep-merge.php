<?php namespace Nabeghe\Examples\ChillConfig\NormalUsage;

require '../vendor/autoload.php';

use Nabeghe\ChillConfig\ChillConfig;

/**
 * Custom config class with defaults.
 *
 * IDE Helpers:
 *
 * @property ?string $name
 * @property ?string $type
 * @property ?string $license
 * @property ?string $version
 * @property ?string $autoload
 * @property ?array $db
 *
 * Get/Set:
 * @method void|string|null name(?string $value = 0)
 * @method void|string|null type(?string $value = 0)
 * @method void|string|null license(?string $value = 0)
 * @method void|string|null version(?string $value = 0)
 * @method void|array|null autoload(?array $value = 0)
 * @method void|array|null db(?array $value = 0)
 */
class Config extends ChillConfig
{
    public const DEFAULTS = [
        'type' => 'library',
        'license' => 'MIT',
        'version' => '1.0.0',
        'db' => [
            'driver' => 'mysql',
            'host' => 'localhost',
        ],
    ];
}

$config = new Config([
    'name' => 'nabeghe/chill-config',
    'db' => [
        'name' => 'database',
        'user' => 'root',
        'password' => '0123456789',
    ],
]);

echo '>> Name: '.$config->name.PHP_EOL; // nabeghe/chill-config
echo '>> Type: '.$config->type.PHP_EOL; // library
echo '>> Version: '.$config->version.PHP_EOL; // 1.0.0
echo '>> Autoload: '.gettype($config->autoload).PHP_EOL; // NULL

echo "----------------------------------------------------------------------------------------------------\n";

echo '>> Database:'.PHP_EOL;
print_r($config->db); /*
                        [driver] => mysql
                        [host] => localhost
                        [name] => database
                        [user] => test
                        [password] => test
                      */