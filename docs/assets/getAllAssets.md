# Getting all assets from the blockchain

Getting information about assets might be your goal. But be aware the api always return only a certain amount of entries. Most of the time the amount is 100. The correct amount is defined within the *ArdorServerState* Model, which can be recieved by getting the [state](../utils/getState.md).

```php
$ardor = new ArdorAssets();
$assets = $ardor->getAllAssets();
```


If you want to paginate pass a parameter (array) to the method:

```php
$ardor = new ArdorAssets();
$assets = $ardor->getAllAssets([
    'firstIndex' => 100
]);
```

Further information about this endpoint can be found [here](https://ardordocs.jelurida.com/Asset_Exchange#Get_All_Assets).

---
Return to the [overview](../overview.md) page for all topics.