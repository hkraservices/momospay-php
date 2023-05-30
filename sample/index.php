<?php

use Momospay\Momospay;
use Momospay\Transaction;

require_once __DIR__ . '/../vendor/autoload.php';

$secret_key = "sk_1_Y7H1cL0OlIM7d89YTNmZNViIPgDK376s5d45dsf";

Momospay::setApiKey($secret_key);
Momospay::setEnvironment("sandbox");

$transaction = Transaction::create([
    'transaction' => [
        'amount' => "100",
        'description' => 'Paiement trajet' . "sdsdssds",
    ],
    'customer' => [
        'email' => "sdsdsd",
        'lastname' => 'dsdd',
        'firstname' =>  'ddffdf'
    ],
    'custom_metadata' => [
        'Jaque' => 'jdf,nfnd,fdnf',
        "roun" => 'ndfjnjnfnff'
    ],
    'return_url' => null,
    'message_success' => null,
    'site_domains' => 'comotoltd.com',
    'methodepayment' => 'mobile',
]);

if ($transaction) {
    var_dump($transaction);
}

$transaction_ = Transaction::retrieve(4);
var_dump($transaction_);



// var_dump($transaction);
