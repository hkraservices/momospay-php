<?php

namespace Mpay;

require '../vendor/autoload.php';

include_once('../src/Mpay.php');
include_once('../src/Constants.php');

$public_key = "pk_1_zBJT1GMArcLfiXJXCVF1f2oUOQC9m4sq5s4q6Hr";
// $private_key = "xxxxxxxxxxxxxxxxxxxxxxxxxxx";
// $secret = "xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx";

$mpay = new Mpay($public_key);
$response = $mpay->getTokens(5000, "Payment comoto", "parfait@gmail.com", 'AHT', 'Parfait', $return_url = null, "mobile", $site_domain = 'www.comooltd.com');

var_dump($response->url);
