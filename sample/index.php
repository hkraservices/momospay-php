<?php

namespace Mpay;

require '../vendor/autoload.php';

include_once('../src/Mpay.php');
include_once('../src/Transaction.php');
include_once('../src/Constants.php');
include_once('../src/STATUS.php');

$secret_key = "***************************";

Mpay::setApiKey($secret_key);
Mpay::setEnvironment("sandbox");

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
