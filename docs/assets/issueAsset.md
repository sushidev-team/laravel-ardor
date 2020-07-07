# Issue an asset

One of the most important parts of a blockchain solution is providing a rocksolid interface for token and token creation. In terms of the ardor blockchain they are called  "assets".

Currently there are to major types of assets. Singleton and "normal" assets. Normal assets are just the same like singleton assets with one major difference. Singleton assets only exsits once. 

From an endpoint perspective the are the same:

```php
public function issueAsset(String $name, $description = null, int $amount = 1, int $decimals = 0, int $chain = 0, array $more = [])
```

```php

use \AMBERSIVE\Ardor\Classes\ArdorAssetsHandler;
use \AMBERSIVE\Ardor\Models\ArdorAssets;

...

public function createAsset() {

    $ardor = new ArdorAssetsHandler();
    $account = $ardor->issueAsset("My Asset", "Test description", 1, 0, 2);

}
```

Sometime it is required to transport more information within an asset. Therefor you can make use of the second param.
If you pass an array it will automatically transform it to json :

```php

...

public function createAsset() {

    $ardor = new ArdorAssetsHandler();
    $account = $ardor->issueAsset(
        "My Asset", [
            "msg" => "Test description"
        ], 
        1, 0, 2);

}
```

---
Return to the [overview](../overview.md) page for all topics.