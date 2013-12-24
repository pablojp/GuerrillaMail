# GuerrillaMail

A Simple Library for [GuerrillaMail](http://www.guerrillamail.com).

## Build Status
Dev: [![Build Status](https://travis-ci.org/taion809/GuerrillaMail.png?branch=dev)](https://travis-ci.org/taion809/GuerrillaMail)

## Requirements

* PHP 5.3+, however, [PHP 5.5](http://php.net) is recommended.
* PHP's curl extension is required if using the CurlConnection class.

## Installation
This library uses composer, you can install it like so

```json

{
    "require": {
        "johnsn/guerrillamail": "version"
    }
}

```

Replace `version` with the desired version or branch.  
You can find additional installation details on this project's [packagist page](https://packagist.org/packages/johnsn/guerrillamail)

## Example Usage

```php

<?php
require_once __DIR__.'/vendor/autoload.php';

use Johnsn\GuerrillaMail\GuerrillaConnect\CurlConnection;
use Johnsn\GuerrillaMail\GuerrillaMail;

//The first parameter is the client's IP.
//The second parameter is the client's Browser Agent.
//There is an optional third parameter to set the api endpoint
$connection = new CurlConnection("127.0.0.1", "GuerrillaMail_Library");
$client = new GuerrillaMail($connection);

//Obtain an email address
$response = $client->getEmailAddress();

//Fetch user's latest emails.
$emails = $client->checkEmail($response['sid_token']);
```

## Example Application
Checkout [ApeMailer](https://github.com/taion809/ApeMailer), it's a silex application with an angularjs front end.

## License

This project is licensed under the MIT License.
