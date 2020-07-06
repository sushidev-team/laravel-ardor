# Search for an asset

If you need to find an asset and you know a term which appears in the name or description this endpoint will help you finding this specific asset. An unclear or broad term will cause problems cause this endpoint will return a collection of entries.

```php
$ardor = new ArdorAssets();
$assets = $ardor->searchAssets("asdf OR test");
```


If you want to paginate pass a parameter (array) to the method:

```php
$ardor = new ArdorAssets();
$assets = $ardor->searchAssets("test AND asdf", [
    'firstIndex' => 100
]);
```

Further information about this endpoint can be found [here](https://ardordocs.jelurida.com/Asset_Exchange#Search_Assets).

---
Return to the [overview](../overview.md) page for all topics.