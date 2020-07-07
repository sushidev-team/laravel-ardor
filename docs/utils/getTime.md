# Get time

Currently there are multiple methods to recieve the current time. Well depends which time you need.

```php
 $ardor = new ArdorBlockchainHandler();        
 $time = $ardor->getTime();
```

Will return a Carbon class from the current unixtimestamp from the server.

```php
 $ardor = new ArdorBlockchainHandler();        
 $time = $ardor->getTimeItem();
```

This method will returns a ArdorTime Class. Within this class you will be able to find the epoche time also.

Further documentation about this endpoint can be found [here](https://ardordocs.jelurida.com/Server_Info#Get_Time).

---
Return to the [overview](../overview.md) page for all topics.