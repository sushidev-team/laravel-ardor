# Transfering assets

Transfering an asset is as easy as issuing an asset:

```php
public function transferAsset(String $asset, String $wallet, int $amount = 1, int $chain = 0, array $more = [])
```
An implementation looks like:

```php
$ardor = new ArdorAssetsHandler();
$amount = 1;
$chain = 2; //Ignis
$transfer = $ardor->calculateFee()->transferAsset("5080855141560730776","ARDOR-AYYX-5W8H-9MYN-AYWB2", $amount , $chain, []);
```

Further information regarding additional params can be found [here](https://ardordocs.jelurida.com/Asset_Exchange#Transfer_Asset).

---
Return to the [overview](../overview.md) page for all topics.