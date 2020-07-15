# Using the local signing

If you do not want to send your secrets to a node you can make use of our *ardorsign* npm package. 

```bash
npm i ardorsign -g
```

This will install [the command line tool](https://github.com/AMBERSIVE/ardorsign) which will be required by this package.

If you want to use this feature set the config:

```yaml
ARDOR_LOCAL_SIGN_AVAILABLE=true
```

or within your application code:

```php
Config::set('ardor.localSignAvailable', true);
```

After that every method provided by this application will be available with an extra command (signLocal). eg:

```php
$message = time();
$messenger = new ArdorMessengerHandler();   
$result = $messenger
            ->signLocal()
            ->calculateFee()
            ->sendMessage("ARDOR-DAZJ-VVSM-552M-8K459", $message, false);
```

---
Return to the [overview](../overview.md) page for all topics.