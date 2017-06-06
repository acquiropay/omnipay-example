<?php

use Omnipay\Common\CreditCard;

require 'bootstrap.php';

$card = new CreditCard(array(
    'firstName' => 'CARD',
    'lastName' => 'HOLDER',
    'number' => '5543735484626654',
    'expiryMonth' => 1,
    'expiryYear' => '2020',
    'cvv' => 362,
));

$request = $gateway->purchase([
    'transactionId' => time(),
    'clientIp' => $_SERVER['REMOTE_ADDR'],
    'amount' => '10.00',
    'card' => $card,
    'returnUrl' => getenv('URL') . '/one-step/complete-purchase.php',
]);

$response = $request->send();

if (!$response->isSuccessful()) {
    dd('purchase failure', $request->getData(), $response->getData());
}

$_SESSION['transactionReference'] = $response->getTransactionReference();
$response->getRedirectResponse()->send();
