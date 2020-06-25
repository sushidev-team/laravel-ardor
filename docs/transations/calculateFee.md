# Calculate the fee

One of the biggest problems (but also benefits) when it comes to blockchain technology is always the fee. The fees are the costs of handling the transactions. Sometimes also the contracts. The Ardor blockchain does also collect fees (in blockchain currency). If a transaction does not provide enough fee it will not be handled on the blockchain.

For applications that might be a problem if you must bring all transactions to the blockchain. For that reason the ardor blockchains has an endpoint for calculating the amount of fee that is required.

While there is only one way to find this via the original endpoint of the ardor blockchain - this package provides various ways to find and calcualte the correct fee that is required.

All of them are situated within the *ArdorHelper* class.

```php
 $helper = new ArdorHelper();
```

### With transaction bytes
If you already know the transaction bytes you can use the following method:
```php
$helper->calculateFeeByBlockchainRequest($bytes);
```

### With fullhash
If you have just the transation fullHash (64 chars long string) you can make use of the following method

```php
$helper->caluclateFeeForTransaction($fullHash); 
```

### While calling endpoints

Well those prevous functins might help you if you try to calculate the fee for an existing transaction. But if you want to calculate the fee before you broadcast to the blockchain you can make use of the method *calculateFee*. It is a chained methods in every other class and must be called before you call the actual method.

```php
 $messenger = new ArdorMessenger();        
 $result = $messenger
                ->calculateFee()
                ->sendMessage("ARDOR-DAZJ-VVSM-552M-8K459", "test");

```

Under the hood it calls the same methods provided above but it's kinde of a helper to reduce the your codesize.

---
Return to the [overview](../overview.md) page for all topics.