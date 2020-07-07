# Get the epoch time

This neat helper method will transform a unix timestamp to an epoche time. Thats need for many endpoints provided by the ardor blockchain.

```php
 $ardor = new ArdorHelperHandler();        
 $time = $ardor->getEpochTime(time());
```

Further documentation about this endpoint can be found [here](https://ardordocs.jelurida.com/Utils#Get_Epoch_Time).

---
Return to the [overview](../overview.md) page for all topics.