# Crafty Clicks PHP Client

A really simple client for the [Crafty Clicks](https://craftyclicks.co.uk/) service.

Currently only implements the postal code lookup.

## Quick Start

Install:

```bash
composer require lukaswhite/crafty-clicks
```

Instantiate:

```php
use Lukaswhite\CraftyClicks\Service;

$service = new Service( 'your-access-token' );
```
 
Perform a lookup:
 
```php 
$results = $service->postcodeLookup( 'SL6 1QZ' );
```

This will return an array of instances of the `Address` model class; it's got a `toArray()` method, can be serialized to JSON and has a bunch of GETters.