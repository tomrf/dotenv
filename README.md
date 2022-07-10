# dotenv - simple dotenv file loader using the built-in parse_ini_file()

[![PHP Version Require](http://poser.pugx.org/tomrf/dotenv/require/php?style=flat-square)](https://packagist.org/packages/tomrf/dotenv) [![Latest Stable Version](http://poser.pugx.org/tomrf/dotenv/v?style=flat-square)](https://packagist.org/packages/tomrf/dotenv) [![License](http://poser.pugx.org/tomrf/dotenv/license?style=flat-square)](https://packagist.org/packages/tomrf/dotenv)

Load environment variables from dotenv file using the PHP built-in parse_ini_file() function
with scanner mode `INI_SCANNER_TYPED` (See [PHP manual](https://www.php.net/manual/en/function.parse-ini-file.php))

It is a simple, reliable and super fast way to load dotenv files without any bells and whistles.

📔 [Go to documentation](#documentation)

## Installation
Installation via composer:

```bash
composer require tomrf/dotenv
```

## Usage
```php
$dotEnvLoader = new \Tomrf\DotEnv\DotEnvLoader();

// loadImmutable() will not overwrite existing environment variables
$dotEnvLoader->loadImmutable(__DIR__ . '/.env');

// load() will overwrite existing environment variables
$dotEnvLoader->load('/path/to/dotenv/file');
```

## Testing
```bash
composer test
```

## License
This project is released under the MIT License (MIT).
See [LICENSE](LICENSE) for more information.

## Documentation
 - [Tomrf\DotEnv\DotEnvLoader](#-tomrfdotenvdotenvloaderclass)
   - [load](#load)
   - [loadImmutable](#loadimmutable)


***

### 📂 Tomrf\DotEnv\DotEnvLoader::class

Simple dotenv loader using parse_ini_file().

#### load()

Loads dotenv file into local environment, overwriting any environment
variable already set.

```php
public function load(
    string $filename
): void

@throws   \Tomrf\DotEnv\DotEnvLoaderException if parsing fails or if the file is not found
```

#### loadImmutable()

Loads dotenv file into local environment while preserving any existing
environment variable.

```php
public function loadImmutable(
    string $filename
): void

@throws   \Tomrf\DotEnv\DotEnvLoaderException if parsing fails or if the file is not found
```



***

_Generated 2022-07-10T02:09:11+02:00 using 📚[tomrf/readme-gen](https://packagist.org/packages/tomrf/readme-gen)_
