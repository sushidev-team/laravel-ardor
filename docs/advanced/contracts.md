# Contracts

Normally you would run your [Ardor Lightweight Contracts](https://medium.com/@lyaffe/lightweight-contracts-articles-49c3032a50da) on your private node (well you need a node cause the node will be the node contract runner).

But this has some downside for us:

- you need java to run
- to interact with your laravel application you need to trigger code on your api. That means the applicaiton needs to be available from outside.

To resolve those two issues we created the "Contract runner" on php side. 

## Create a contract

#### Run the command to create a contract

```bash
php artisan ardor:make Test --type=contract
```

This command will create a Contract file in your app/Contracts folder.

#### Add the contract to the contract running list

Open your ardor.php (config file) and add the file to the list:

```php
// Contracts
'contracts' => [
    \AMBERSIVE\Ardor\Contracts\DefaultFundingContract::class
    // INSERT YOUR Contract here:
    \App\Contracts\TestContract::class
]
```

#### Create the contract logic

```php
class TestContract extends ContractDefault {

    public $name = "";

    public function run(ArdorPrunableMessage $message):bool {

        // If you return true the message will not be 
        return true;
    }

}
```

As long your contract does not return true within the *run* function the contract will execute the message and a related contract.