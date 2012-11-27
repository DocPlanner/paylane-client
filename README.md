PayLane Client
==============

Installation
------------

Using composer, run:

```sh
php composer.phar require znanylekarz/paylane-client:dev-master
```

Usage
-----

```php
$client = new \PayLane\Client($user, $password);

$result = $client->multiSale(array ('…'));
$fault = $client->getLastFault();
if ($fault) {
    echo "Error: " . $fault->faultstring . "\n";
}
```