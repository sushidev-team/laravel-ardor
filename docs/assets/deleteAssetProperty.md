# Remove attributes to assets

Removing attributes from assets is as simple as it can be. But be aware: Removing an attribute from a none singleton asset will have effects for every assets on this chain.

```php
$ardor = new ArdorAssetsHandler();
$assets = $ardor->deleteAssetProperty("13673297909608604150", "valid", 2);
```


If you want to paginate pass a parameter (array) to the method:

```php
$ardor = new ArdorAssetsHandler();
$assets = $ardor->deleteAssetProperty("13673297909608604150", "valid", 2, [
    // Addtional information
]);
```

Further information about this endpoint can be found [here](https://ardordocs.jelurida.com/Asset_Exchange#Delete_Asset_Property).

---
Return to the [overview](../overview.md) page for all topics.