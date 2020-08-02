# Get account balance

If you need to check the balance for a specific currency by chain.

```php
public function getBalance(String $account, int $chain = 1, array $more = []): ArdorBalance
```

A basic implementation for this method would be:

```php
$ardor = new ArdorAccountsHandler();
$balance = $ardor->getBalance(config('ardor.wallet'),1, []);
```

There is also a neat method if you need to check it for multiple chains:

```php
$ardor = new ArdorAccountsHandler();
$balance = $ardor->getBalances(config('ardor.wallet'),[1,2], []);
```

---
Return to the [overview](../overview.md) page for all topics.