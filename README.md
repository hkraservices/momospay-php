# MPAY PHP-SDK

## Raw Files

```bash
    git clone https://github.com/mpay/php-sdk.git
```

## Installing

Using composer:

```bash

    composer require momospay/momospay-php

```

## Initialization

#### Production

```php
    $mpay = new \mpay\mpay($public_key, $private_key, $secret);
```

#### Sandbox

```php
    $mpay = new \mpay\mpay($public_key, $private_key, $secret, $sandbox = true);
```

## Request to retrieve transactions
