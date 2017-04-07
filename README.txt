# Synthesizer

## Overview

Synthesizer provides an elegant interface to synthesize text to speech (audio url) using a variety of third-party providers.

**Supported Providers:**

 * Google

## Installation
Run the following [composer](https://getcomposer.org/doc/00-intro.md#installation-linux-unix-osx) command to add the package to your project:

```
composer require dayrev/synthesizer
```

Alternatively, add `"dayrev/synthesizer": "^1.0"` to your composer.json file.

##Usage
```php
$synthesizer = DayRev\Synthesizer\Provider::instance('google');
$content = $synthesizer->synthesize($text);
```

## Tests
To run the test suite, run the following commands from the root directory:

```
composer install
vendor/bin/phpunit
```
