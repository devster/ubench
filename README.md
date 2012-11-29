Ubench
======

Ubench is a PHP micro library for benchmark

Installation
------------

### Old school ###

require `src/Ubench/Ubench.php` in your project.

### Composer ###

Add this to your composer.json

```json
{
    "require": {
        "devster/ubench": "1.0.*-dev"
    }
}
```

Usage
-----

```php
use Ubench\Ubench;

$bench = new Ubench;

$bench->start();

// Execute some code

$bench->end();

// Get elapsed time and memory
echo $bench->getTime(); // 156ms or 1.123s
echo $bench->getTime(false); // elapsed microtime in float

echo $bench->getMemoryPeak(); // 90Kb or 15.23Mb
echo $bench->getMemoryPeak(false); // memory peak in bytes
```

License
-------

Ubench is licensed under the MIT License