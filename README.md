# Synthesizer
[![Build Status](https://travis-ci.org/dayrev/synthesizer.svg?branch=master)](https://travis-ci.org/dayrev/synthesizer)
[![Coverage Status](https://coveralls.io/repos/github/dayrev/synthesizer/badge.svg?branch=master)](https://coveralls.io/github/dayrev/synthesizer?branch=master)
[![Latest Stable Version](https://poser.pugx.org/dayrev/synthesizer/v/stable.png)](https://packagist.org/packages/dayrev/synthesizer)

## Overview
Synthesizer provides an elegant interface to synthesize text to speech (audio url) using a variety of third-party providers.

**Supported Providers:**

 * Amazon Polly
 * Google
 * IBM Watson
 * iSpeech

## Installation
Run the following [composer](https://getcomposer.org/doc/00-intro.md#installation-linux-unix-osx) command to add the package to your project:

```
composer require dayrev/synthesizer
```

Alternatively, add `"dayrev/synthesizer": "^1.0"` to your composer.json file.

## Usage
```php
$provider = Provider::instance('amazon', [
    'key' => 'YOUR_AMAZON_API_KEY',
    'secret' => 'YOUR_AMAZON_API_SECRET',
]);
$content = $synthesizer->synthesize($text);

$synthesizer = DayRev\Synthesizer\Provider::instance('google');
$content = $synthesizer->synthesize($text);

$synthesizer = DayRev\Synthesizer\Provider::instance('ibm', [
    'username' => 'YOUR_IBM_USERNAME',
    'password' => 'YOUR_IBM_PASSWORD',
]);
$content = $synthesizer->synthesize($text);

$synthesizer = DayRev\Synthesizer\Provider::instance('ispeech', [
    'apikey' => 'YOUR_ISPEECH_API_KEY'
]);
$content = $synthesizer->synthesize($text);
```

## Tests
To run the test suite, run the following commands from the root directory:

```
composer install
vendor/bin/phpunit -d ibm_username=YOUR_IBM_USERNAME -d ibm_password=YOUR_IBM_PASSWORD -d ispeech_api_key=YOUR_ISPEECH_API_KEY -d amazon_api_key=YOUR_AMAZON_API_KEY -d amazon_api_secret=YOUR_AMAZON_API_SECRET
```

> **Note:** API credentials are required when running the integration tests but the values don't have to be valid.
