# Read a message

If you want to read a message. All you need is the fullHash of the message and the chain id.

```php
$messenger = new ArdorMessengerHandler();
$resultRead = $messenger->readMessage("1cc4b85db37461e84c28dcad92bfc873fd51a04f3af59af164f22f0c3fad2ebb", 2);      
```

But sometimes you need further parameters.

```php
public function readMessage(String $fullHash, int $chain = 0, String $secret = null, array $more = [])
```

As you see the implementation allows you to pass additional parameters. 
Also the $more (= array) paramter allows you to pass any parameter the endpoint.
For further information which parameter or data can be passed, please look into the [offcial documentation](https://ardordocs.jelurida.com/Messages#Read_Message).

---
Return to the [overview](../overview.md) page for all topics.