<?php namespace Nabeghe\Examples\ChillConfig\SimpleUsage;

require '../vendor/autoload.php';

use Nabeghe\ChillConfig\ChillConfig;

$config = new ChillConfig([
    'name' => 'nabeghe/chill-config',
    'type' => 'library',
    'license' => 'MIT',
    'version' => '1.0.0',
    'db' => [
        'driver' => 'mysql',
        'host' => 'localhost',
        'name' => 'database',
        'user' => 'root',
        'pass' => 'secret',
    ],
]);

echo '>> Name: '.$config->name.PHP_EOL; // nabeghe/chill-config
echo '>> Type: '.$config->type().PHP_EOL; // library
echo '>> Version: '.$config['version'].PHP_EOL; // 1.0.0
echo '>> Autoload: '.gettype($config->autoload).PHP_EOL; // NULL

$config->version = '1.1.0'; // Edit the version
echo '>> Edited Version: '.$config->version.PHP_EOL; // 1.1.0
$config->version('1.2.0'); // Edit the version
echo '>> Edited Version: '.$config->version.PHP_EOL; // 1.2.0
$config['version'] = '1.3.0'; // Edit the version
echo '>> Edited Version: '.$config->version.PHP_EOL; // 1.3.0

echo "----------------------------------------------------------------------------------------------------\n";

echo '>> Database:'.PHP_EOL;
print_r($config->db); /*
                        [driver] => mysql
                        [host] => localhost
                        [name] => database
                        [user] => root
                        [pass] => 0123456789
                      */
$config->db['driver'] = 'mongodb'; // Edit the driver of db
echo '>> Edited Database Driver: '.$config->db['driver'].PHP_EOL; // mongodb