<?php namespace Nabeghe\Examples\ChillConfig\SimpleUsage;

require '../vendor/autoload.php';

use Nabeghe\ChillConfig\ChillConfig;

class BaseConfig extends ChillConfig
{
    public const DEFAULTS = [
        'type' => 'library',
        'license' => 'MIT',
        'version' => '1.0.0',
    ];
}

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