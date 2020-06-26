# Get a single transaction

The blockchain is all about transactions. The fastest way to found a transaction is to use the fullHash of it.

```php
 $ardor = new ArdorBlockchain();        
 $transaction = $ardor->getTransaction("68df1c0eb56059cae1dbaa57efe161762d57e996e38b844abcad7fd1c017b33d", 2);
```

Please be aware that this method won't return a class cause the output might not be the same output every time.

---
Return to the [overview](../overview.md) page for all topics.