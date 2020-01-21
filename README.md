[![GitHub](https://travis-ci.org/EliFuzz/postcode-nl.svg?branch=master)](https://travis-ci.org/EliFuzz/postcode-nl)

Postcode.nl PHP API REST Client
===

A PHP wrapper, which offers methods to directly talk with the [Postcode.nl API](https://api.postcode.nl/documentation).

Installation
===

1. Create an account: [Postcode.nl API](https://services.postcode.nl/adresdata/api)
2. Add library to your project
3. Instantiate the PHP class with your authentication details
4. Call the `lookupAddress` method

Usage
===

```PHP
try {
    $client = new RestApi\RestClient('{your key}', '{your secret}');
    $address = $client->lookupAddress('{postcode}', '{houseNumber}', '{houseNumberAddition}');
    var_dump($address);
} catch (RestApi\Exception\AddressNotFoundException $e) {
    die($e->getMessage());
} catch (RestApi\Exception\InputInvalidException $e) {
    die($e->getMessage());
} catch (RestApi\Exception\AuthenticationException $e) {
    die($e->getMessage());
} catch (RestApi\Exception\ServiceException $e) {
    die($e->getMessage());
}
```

Documentation
===

* [Address API description](https://services.postcode.nl/adresdata/api)
* [Address API method documentation](https://api.postcode.nl/documentation/address-api)
