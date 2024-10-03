# Chill Config for PHP

> Where carefree meets calm, and chill thrives in your PHP configuration.

Here's a simple library that helps you set up your project’s configuration.
You pass in your options as an array, and then dynamically access them through object fields, methods or indexes.
You can also define default values in a custom config class.
Plus, you can organize different parts of your config as containers in custom classes and access those config options via static methods whenever you need them.
This makes the default values load lazily.

## 🫡 Usage

### 🚀 Installation

You can install the package via composer:

```bash
composer require nabeghe/chill-config
```

### Examples

Check the examples folder in the repositiry.

- [Example 1: Simple Usage](examples/1-simple-usage.php)
- [Example 2: Defaults (deep merge)](examples/2-defaults-deep-merge.php)
- [Example 3: Defaults (no deep merge)](examples/3-defaults-no-deep-merge.php)
- [Example 4: Nested](examples/4-nested.php)
- [Example 5: Advanced Nested](examples/5-advanced-nested.php)
- [Example 6: Container](examples/6-container.php)

### Example 5: Advanced Nested

```php
require 'vendor/autoload.php';

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
```

## 📖 License

Copyright (c) 2024 Hadi Akbarzadeh

Licensed under the MIT license, see [LICENSE.md](LICENSE.md) for details.