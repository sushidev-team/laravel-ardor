# Get unconfirmed transactions 

Getting unconfirmed transactions is a every useful endpoint. Cause our custom bundler implementation is based on this information. This implementation is part of the ArdorBlockchain Class.

```php
$chain = 2; // = IGNIS
$blockchain = new ArdorBlockchain();
$result = $blockchain->getUnconfirmedTransactions($chain);
```

This request will return a instance of [ArdorTransactionCollection](../../src/Models/ArdorTransactionCollection.php).

---
Return to the [overview](../overview.md) page for all topics.