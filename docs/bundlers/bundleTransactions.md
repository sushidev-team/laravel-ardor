# Bundle a specific transaction

Bundle transactions might be easier (and our recommended way) with the [Custom Bundler](../advanced/bundlers.md) or at least the [Basic Ardor Bundler](https://ardordocs.jelurida.com/Bundling). Well under the hood the custom bundler relies also on that endpoint call so it is worth to explain what's happening.

The interface is:

```php
public function bundleTransactions(String $fullHash, int $chain = 0, array $more = []):bool 
```

Basic implementation:

```php
$bundler = new ArdorBundler();
$bundler->bundleTransaction("68df1c0eb56059cae1dbaa57efe161762d57e996e38b844abcad7fd1c017b33d", 2)
```

Under the hood this function will automatically calculate the required fee and will bundle this transaction.

---
Return to the [overview](../overview.md) page for all topics.