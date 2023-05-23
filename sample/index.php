<?php

use Mpay\Momospay;
use Mpay\Transaction;

require_once __DIR__ . '/../vendor/autoload.php';

$secret_key = "hgdghvdfdvfdvfdbdvvdvfdvfvfvfbbbdbdbbd";

Momospay::setApiKey($secret_key);
Momospay::setEnvironment("sandbox");

// $transaction = Transaction::create([
//     'transaction' => [
//         'amount' => "100",
//         'description' => 'Paiement trajet' . "sdsdssds",
//     ],
//     'customer' => [
//         'email' => "sdsdsd",
//         'lastname' => 'dsdd',
//         'firstname' =>  'ddffdf'
//     ],
//     'custom_metadata' => [
//         'Jaque' => 'jdf,nfnd,fdnf',
//         "roun" => 'ndfjnjnfnff'
//     ],
//     'return_url' => null,
//     'site_domains' => 'comotoltd.com',
//     'methodepayment' => 'mobile',
// ]);

$transaction = Transaction::retrieve(1);

if ($transaction) {
    var_dump($transaction);
}


// var_dump($transaction);
