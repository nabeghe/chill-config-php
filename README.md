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
- [Example 5: Container](examples/5-container.php)

## 📖 License

Copyright (c) 2024 Hadi Akbarzadeh

Licensed under the MIT license, see [LICENSE.md](LICENSE.md) for details.