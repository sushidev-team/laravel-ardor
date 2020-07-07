# Getting the blockchain status for a single node

This neat helper method will return some basic information about the provided node. That is a quite good way to do a healthcheck for an ardor node.

```php
 $ardor = new ArdorServerHandler();        
 $information = $ardor->getBlockchainStatus();
```

Further documentation about this endpoint can be found [here](https://ardordocs.jelurida.com/Blocks#Get_Blockchain_Status).

---
Return to the [overview](../overview.md) page for all topics.