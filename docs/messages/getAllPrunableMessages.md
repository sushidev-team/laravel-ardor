# Get all prunable messages

Prunable messages will be removed from the blockchain after an amount of n blocks are added.
To the all prunable messages this package offers you the following implementation:

```php
$messenger = new ArdorMessenger();
$result = $messenger->getAllPrunableMessages(2);
```

The response will return you a [ArdorPrunableMessages](../../src/models/ArdorPrunableMessages.php) instance with all possible messages available.

---
Return to the [overview](../overview.md) page for all topics.