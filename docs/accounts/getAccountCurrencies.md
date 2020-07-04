# Get an accocunt

Getting an account (= wallet) is easy. What you need to know is the wallet id (= starts with ARDOR-*)

```php

use \AMBERSIVE\Ardor\Classes\ArdorAccounts;
use \AMBERSIVE\Ardor\Models\ArdorAccount;

...

public function returnAcccountData():ArdorAccount {

    $ardor = new ArdorAccounts();
    $account = $ardor->getAccount('ARDOR-DAZJ-VVSM-552M-8K459');

}
```

The account method also provides some addtional parameter.

```php
public function getAccount(String $account, array $more = []):ArdorAccount
```

The $more paramter will be merged into the body. What kind of parameter make sense can be extracted form the original documentation from ardor => [https://ardordocs.jelurida.com/Accounts#Get_Account](https://ardordocs.jelurida.com/Accounts#Get_Account)

An example could look like:

```php

 
    $ardor = new ArdorAccounts();
    $account = $ardor->getAccount('ARDOR-DAZJ-VVSM-552M-8K459', [
        'includeEffectiveBalance' => 'true'
    ]);

```

This will automatically add the NQT Balance to the response. Please note that the related attribute in the object is always present.

---
Return to the [overview](../overview.md) page for all topics.