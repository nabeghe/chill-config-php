<?php namespace Nabeghe\Examples\ChillConfig\SimpleUsage;

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
 * @property ?\Nabeghe\Examples\ChillConfig\NormalUsage\DbConfig $db
 *
 * Get/Set:
 * @method void|string|null name(?string $value = 0)
 * @method void|string|null type(?string $value = 0)
 * @method void|string|null license(?string $value = 0)
 * @method void|string|null version(?string $value = 0)
 * @method void|array|null autoload(?array $value = 0)
 * @method void|DbConfig|null db(?DbConfig $value = 0)
 */
class BaseConfig extends ChillConfig
{
    public const DEFAULTS = [
        'type' => 'library',
        'license' => 'MIT',
        'version' => '1.0.0',
    ];
}

/**
 * Db config.
 *
 * IDE Helper:
 *
 * @property string|null $driver
 * @property string|null $host
 * @property string|null $name
 * @property string|null $user
 * @property string|null $password
 *
 * @method void|string|null driver(?string $value = 0)
 * @method void|string|null host(?string $value = 0)
 * @method void|string|null name(?string $value = 0)
 * @method void|string|null user(?string $value = 0)
 * @method void|string|null password(?string $value = 0)
 */
class DbConfig extends ChillConfig
{
    public const DEFAULTS = [
        'driver' => 'mysql',
        'host' => 'localhost',
    ];
}

$config = new BaseConfig([
    'name' => 'nabeghe/chill-config',
    'type' => 'library',
    'license' => 'MIT',
    'version' => '1.0.0',
    'db' => new DbConfig([
        'name' => 'database',
        'user' => 'root',
        'password' => '0123456789',
    ]),
]);

echo '>> Name: '.$config->name.PHP_EOL; // nabeghe/chill-config
echo '>> Type: '.$config->type().PHP_EOL; // library
echo '>> Version: '.$config['version'].PHP_EOL; // 1.0.0
echo '>> Autoload: '.gettype($config->autoload).PHP_EOL; // NULL
$config->version = '2.0.0'; // Edit the version
echo '>> Edited Version: '.$config->version.PHP_EOL; // 2.0.0

echo "----------------------------------------------------------------------------------------------------\n";

echo '>> Database:'.PHP_EOL;
print_r($config->db->_options); /*
                                    [driver] => mysql
                                    [host] => localhost
                                    [name] => database
                                    [user] => test
                                    [password] => test
                                */
$config->db['driver'] = 'mongodb'; // Edit the driver of db
echo '>> Edited Database Driver: '.$config->db['driver'].PHP_EOL; // mongodb