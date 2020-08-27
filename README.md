# Ardor Blockchain

[![Maintainability](https://api.codeclimate.com/v1/badges/d70c6bfcb037abdc7163/maintainability)](https://codeclimate.com/github/AMBERSIVE/laravel-ardor/maintainability)
[![Build Status](https://travis-ci.org/AMBERSIVE/laravel-ardor.svg?branch=master)](https://travis-ci.org/AMBERSIVE/laravel-ardor)

This package for Laravel provides an integration to the [ardor blockchain](https://ardorplatform.org/). For information about the changes please have a look into the [CHANGELOG.md](CHANGELOG.md).

This project was ranked at [5th place at the Ardor Community Hackathon](https://www.nxter.org/ardor-hackathon-2020-the-winners-announced/)

[!!! ATTENTION: This project is still work in progress !!!]

## About

Ever wished to be a blockchain developer? With this package this wish can become true. This package aims to be the conntector to the *PHP* world and provides a simple interface to interact with the ardor blockchain. This specific blockchain is special because it offers a wide angle of possiblities. From token generation to messaging and selling digital goods.

## Installation

```bash
composer require ambersive/ardor
```

than publish the config via:

```bash
php artisan vendor:publish --tag=ardor
```

## Useage
This package contains multiple classes for the interaction with the blockchain endpoint. But all classes are based on the same communication layer.
Before you can start please create a wallet (= account) on the ardor blockchain and add those information in config file.

Otherwise you can set those information on the fly:

```php
Config::set('ardor.node', 'https://testardor.jelurida.com/');
Config::set('ardor.wallet', 'ARDOR-DAZJ-VVSM-552M-8K459');
Config::set('ardor.secret', 'orange welcome begun powerful lonely government cast figure add quit wife loser');
```

If you want to get the account detail for example you would recieve those information by making the following call:

```php

use \AMBERSIVE\Ardor\Classes\ArdorAccountsHandler;
use \AMBERSIVE\Ardor\Models\ArdorAccount;

public function returnAcccountData():ArdorAccount {

    $ardor = new ArdorAccountsHandler();
    $account = $ardor->getAccount('ARDOR-DAZJ-VVSM-552M-8K459');

}
```

But there are quite more possible methods and calls (including the possiblity to create bundlers and custom contracts). For further information just go to the documentation.

## What makes this package special?
Well it is the only package for the ardor blockchain out there and we provide some sugar on top like 
- [Custom transaction bundler](docs/advanced/bundlers.md)
- [Custom blockchain contracts](docs/advanced/contracts.md)

## Local signing of transactions
This integration aso provides a way to use local signing while using the endpoints.
Further information in the advanced section of the documentation ([here](docs/advanced/localsigning.md)).

## Documentation

The [Documentation](docs/overview.md) for all supported endpoints and methods also tries to offer a deeper look into the ardor blockchain technology.

Please feel free to contact us if you have issues or questions regarding this package.

## Security Vulnerabilities

If you discover a security vulnerability within this package, please send an e-mail to Manuel Pirker-Ihl via [manuel.pirker-ihl@ambersive.com](mailto:manuel.pirker-ihl@ambersive.com). All security vulnerabilities will be promptly addressed.

## License

This package is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

