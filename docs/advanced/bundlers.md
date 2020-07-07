# Bundlers

Like many other blockchain, also the ardor blockchain suffers from a major issue. Sending transactions costs. While other blockchains does not have a proper solution to resolve that issue, ardor offers you muliple ways of solve that issue.

[Bundling](https://ardordocs.jelurida.com/Bundling) transactions provides you the possibilities to fund or pay the transaction fees of others. While the "native" approach must be written in java and run as part of a ardor node, this package provides you - lets call it "easy" - approach to solve that within your laravel application.

## PHP Bundlers 

### How to create a bundler

```bash
php artisan ardor:make {name} --type=bundler
```

Define your bundler in the ardor config file.

```php
...
'bundlers' => [
    \AMBERSIVE\Ardor\Bundlers\DefaultTransactionBundler::class
],
...
```

Modify your bundler logic. Every bundler has a **run** function which needs to return a boolean value.

```php
/**
 * Main entry point for the bundler
 *
 * @param  mixed $transaction
 * @return bool
 */
public function run(ArdorTransactionJson $transaction):bool {
    if (in_array($transaction->senderRS, data_get($this->config, 'accounts', []))){
        return $this->ardorBundler->bundleTransactions($transaction->fullHash, $transaction->chain);
    }
    return false;
}
```

### How can i run the bundler?

To run the bundlers just run the following command in your command line:

```bash
php artisan ardor:run-bundler
```

Every transaction will only be processed once within a timeframe of 15 minutes, cause resolving the transation data triggers multiple calls in the api which might cause performance problems.

If a transactin was bundled the bundling process for this specific bundler will stop.

