# PHP-FTP-droid (library for PHP-ftp)

[![Latest Version on Packagist](https://img.shields.io/packagist/v/kartulin/php-ftp-droid.svg?style=flat-square)](https://packagist.org/packages/kartulin/php-ftp-droid)
[![Total Downloads](https://img.shields.io/packagist/dt/kartulin/php-ftp-droid.svg?style=flat-square)](https://packagist.org/packages/kartulin/php-ftp-droid)
![GitHub Actions](https://github.com/kartulin/php-ftp-droid/actions/workflows/main.yml/badge.svg)

Simple and comfortable library for work with FTP protocol. Supports:

* fluent interface
* callbacks
* ftp-ssl connect
* errors bag
* all available [functions PHP-FTP](https://www.php.net/manual/en/ref.ftp.php)
* easy in integration  with any php-framework
* /* **in next release***/
* PSR\LoggerInterface
* async operations
* retry operations

## Installation

You can install the package via composer:

```bash
composer require kartulin/php-ftp-droid
```

## Basic usage

```php
use Kartulin\FtpDroid\FtpDroid;
// fast example
$ftp = FtpDroid::connect('127.0.0.1', $ssl = false, $port = 21, $timeout = 90)
->login('username', 'password')
->get($local_filename, $remote_filename, $mode = FTP_BINARY, $offset = 0)
->callback(function (FtpDroid $ftp){
if ($ftp->result){
// you logic here...
//see $ftp->errors... 
 }
})->chdir($directory)
->close();
```

All methods are good [are documented](CHANGELOG.md). You can also read [the documentaion on php.net](https://www.php.net/manual/en/book.ftp.php)  
Call every method return the object of FtpDroid client:
```php
var_dump($ftp);
 Kartulin\FtpDroid\FtpDroid {#3 ▼
  +hostname: "127.0.0.1"
  +ssl: false
  +port: 21
  +timeout: 90
  -handler: FTP\Connection {#2}
  #logger: null
  +result: true // the result of last method
  +errors: array:1 [▼
    1655710692 => "login"
 // [timestamp_error => "the name of the method that received the error from the ftp server"] 
  ]
```

You can use unlimited callbacks:
```php
$ftp = FtpDroid::connect('127.0.0.1', $ssl = false, $port = 21, $timeout = 90)
->login('username', 'password')
->get()
->callback(function (FtpDroid $ftp){
// you logic 1 here...
})->chdir()
->callback(function (FtpDroid $ftp){
// you logic 2 here...
})
->method()
->callback();
```

### Testing

```bash
cooming soon (PHPUnit and PhpStan)
```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

### Security

If you discover any security related issues, please email stalkerxxl@gmail.com instead of using the issue tracker.

## Credits

- [Kartulin](https://github.com/kartulin)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
