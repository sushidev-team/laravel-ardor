# Send a message via ardor
Ardor comes with a message system. Well it's quite important to be honest. Normally that would be the way to trigger "native" contracts.

This packages comes with an easy to use approach for the message sending part:

```php
$messenger = new ArdorMessengerHandler();        
$result = $messenger
    ->calculateFee()
    ->sendMessage("ARDOR-DAZJ-VVSM-552M-8K459", "test");
```

This would send to the ardor wallet the message "test".
But if you would like to adjust the message you can do that.

```php
public function sendMessage(String $wallet, String $message, bool $prunable = true, array $more = [])
```
By passing data to the $more (= array) attribute you address any setting from the [documentation](https://ardordocs.jelurida.com/Messages#Send_Message).

---
Return to the [overview](../overview.md) page for all topics.