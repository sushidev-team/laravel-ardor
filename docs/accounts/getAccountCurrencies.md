# Get the currencies for a account

If you need the informatin which currency an account has. Please be aware that the [monetary system](https://ardordocs.jelurida.com/Monetary_system) within is meant with this endpoint. This endpoint will not provide detailed information for you ignis or ardor holdings.
We recommend to use the [getAccount](getAccount.md) endpoint for that purpose.

```php

use \AMBERSIVE\Ardor\Classes\ArdorAccountsHandler;
use \AMBERSIVE\Ardor\Models\ArdorAccount;

...

public function returnAcccountData():ArdorAccount {

    $ardor = new ArdorAccountsHandler();
    $currencies = $ardor->getAccountCurrencies('ARDOR-DAZJ-VVSM-552M-8K459');

}
```

The official [documentation](https://ardordocs.jelurida.com/Accounts#Get_Account_Currencies) for this endpoint providesa a detailed documentation.

---
Return to the [overview](../overview.md) page for all topics.