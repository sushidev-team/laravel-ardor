# Use the bundled class

There are many classes in this package.
While this is good during development and performance this might be "boring" if you do not wand to declare everything.

Therefore we provide a bundle class for all classes

```php

//use AMBERSIVE\Ardor\Classes\Ardor;
$ardor = new Ardor();
```

Name conventions

- ArdorAccountsHandler: *$accounts*
- ArdorAssetsHandler: *$assets*
- ArdorBlockchainHandler: *$chain*
- ArdorBundlerHandler: *$bundler*
- ArdorConnectorHandler: *$connector*
- ArdorHelperHandler: *$helper*
- ArdorMessengerHandler: *$messenger*
- ArdorServerHandler: *$server*


So if you want to call the ArdorServerHandler you can do that like:

```php
$ardor = new Ardor();
$ardor->server->getTime();
```