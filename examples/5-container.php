<?php namespace Nabeghe\Examples\ChillConfig\AdvancedUsage;

require '../vendor/autoload.php';

use Nabeghe\ChillConfig\ChillConfig;
use Nabeghe\ChillConfig\ConfigContainer;

/**
 * Base config container
 *
 * IDE Helper:
 *
 * @method static void|string|null name(?string $value = 0)
 * @method static void|string|null type(?string $value = 0)
 * @method static void|string|null license(?string $value = 0)
 * @method static void|string|null version(?string $value = 0)
 */
class BaseConfig extends ConfigContainer
{
    public const DEFAULTS = [
        'type' => 'library',
        'license' => 'MIT',
        'version' => '1.0.0',
    ];

    protected static function _chillConfig(): ChillConfig
    {
        return $GLOBALS['config'];
    }
}

/**
 * Db config container.
 *
 * IDE Helper:
 *
 * @method static void|string|null driver(?string $value = 0)
 * @method static void|string|null host(?string $value = 0)
 * @method static void|string|null name(?string $value = 0)
 * @method static void|string|null user(?string $value = 0)
 * @method static void|string|null password(?string $value = 0)
 */
class DbConfig extends ConfigContainer
{
    public const NAME = 'db';

    public const DEFAULTS = [
        'driver' => 'mysql',
        'host' => 'localhost',
    ];

    protected static function _chillConfig(): ChillConfig
    {
        return $GLOBALS['config'];
    }
}

global $config;
$config = new ChillConfig([
    'name' => 'nabeghe/chill-config',
    'db' => [
        'name' => 'database',
        'user' => 'root',
        'password' => '0123456789',
    ],
]);

echo '>> Name: '.BaseConfig::name().PHP_EOL; // nabeghe/chill-config
echo '>> Type: '.BaseConfig::type().PHP_EOL; // library
echo '>> Version: '.BaseConfig::version().PHP_EOL; // 1.0.0
echo '>> Autoload: '.gettype(BaseConfig::autoload()).PHP_EOL; // NULL
BaseConfig::version('2.0.0');
echo '>> Edited Version: '.BaseConfig::version().PHP_EOL; // 2.0.0

echo "----------------------------------------------------------------------------------------------------\n";

echo '>> Database Driver: '.DbConfig::driver().PHP_EOL;
echo '>> Database Host: '.DbConfig::host().PHP_EOL;
echo '>> Database Name: '.DbConfig::name().PHP_EOL;
echo '>> Database User: '.DbConfig::user().PHP_EOL;
echo '>> Database Password: '.DbConfig::password().PHP_EOL;
DbConfig::driver('mongodb'); // Edit the driver of database
echo '>> Edited Database Driver: '.DbConfig::driver().PHP_EOL; // mongodb