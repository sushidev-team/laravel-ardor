# Add attributes to assets

The data of an asset it quit minimalistic. To increase the amount of information you can connect with an single asset - ardor offers you an endpoint called "*setAssetProperty*". The limits here are 32 chars for the property name and up to 160 chars for the value. Please be aware that you must add the chain.

```php
$ardor = new ArdorAssets();
$assets = $ardor->setAssetProperty("13673297909608604150", "valid", "true", 2);
```


If you want to paginate pass a parameter (array) to the method:

```php
$ardor = new ArdorAssets();
$assets = $ardor->setAssetProperty("13673297909608604150", "valid", "true", 2, [
    // Addtional information
]);
```

Further information about this endpoint can be found [here](https://ardordocs.jelurida.com/Asset_Exchange#Set_Asset_Property).

---
Return to the [overview](../overview.md) page for all topics.