<?php

require $_SERVER['DOCUMENT_ROOT'].'/main/plugin/paypal/vendor/autoload.php';

ini_set('error_reporting', E_ALL); // or error_reporting(E_ALL);
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');

use PayPalCheckoutSdk\Core\PayPalHttpClient;
use PayPalCheckoutSdk\Core\SandboxEnvironment;
// Creating an environment
$clientId = "AahBTOaz_zeoDPVSUTGSD-say3nn9dCvecCbmKnGQreyAYe93pXx7KukVlFUfUSrXGboAzCWrJzl8b6l";
$clientSecret = "ELFICn3-8Ri8WYVhaJjDVhrdfJ-I_z-5AHxz3YQmmWoFt9E-U-T30vupPMr_OW-kjyUfBJkeRbPOjmGz";

$environment = new SandboxEnvironment($clientId, $clientSecret);
$client = new PayPalHttpClient($environment);

?>