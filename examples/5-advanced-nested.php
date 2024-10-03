<?php namespace Nabeghe\Examples\ChillConfig\NormalUsage;

/*
 * In advanced mode, whenever a property related to the nested config is called, it will be initialized.
 * In fact, this is a lazy loading approach.
 */

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
 * @property ?DbConfig $db
 *
 * Get/Set:
 * @method void|string|null name(?string $value = 0)
 * @method void|string|null type(?string $value = 0)
 * @method void|string|null license(?string $value = 0)
 * @method void|string|null version(?string $value = 0)
 * @method void|array|null autoload(?array $value = 0)
 * @method void|DbConfig|null db(?DbConfig $value = 0)
 */
class Config extends ChillConfig
{
    public const DEFAULTS = [
        'type' => 'library',
        'license' => 'MIT',
        'version' => '1.0.0',
    ];

    public const NESTS = [
        'db' => DbConfig::class, // It
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

echo '>> Database Driver: '.$config->db->driver.PHP_EOL; // NULL
echo '>> Database Host: '.$config->db->host.PHP_EOL; // NULL
echo '>> Database Name: '.$config->db->name.PHP_EOL; // NULL
echo '>> Database User: '.$config->db->user.PHP_EOL; // NULL
echo '>> Database Password: '.$config->db->password.PHP_EOL; // NULL