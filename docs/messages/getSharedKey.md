# Get a shared key

This method wil generate a one time share key which can be used for encrypting/decrypting. Official documentation for that method can be found [here](https://ardordocs.jelurida.com/Messages#Get_Shared_Key).


```php
public function getSharedKey(String $account, String $secret = null, String $nonce = null, array $more = [])
```

An implementation looks like:

```php
$wallet = 'ARDOR-DAZJ-VVSM-552M-8K459';
$secret = 'ICANTTELLYOU';
$messenger = new ArdorMessengerHandler();
$resultRead = $messenger->getSharedKey($wallet, $secret);      
```

As you see you can provide a $nonce but you do not need to. The package will create this nonce for you.

---
Return to the [overview](../overview.md) page for all topics.