<?php
use grandmasterx\neteller\api\RequestPayment;

$url = 'https://test.api.neteller.com/';
$clientId = 'AAAAAAAAAAAAAAAAA';
$clientSecret = 'BBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBB';
$deposit = new RequestPayment();
$deposit->setApiCredentials($url, $clientId, $clientSecret);

$deposit->setPaymentMethodValue('netellertest_USD@neteller.com')
    ->setTransactionMerchantRefId((string)date('yyyy-mm-dd hh:ii:ss'))
    ->setTransactionAmount(1234)
    ->setTransactionCurrency('USD')
    ->setVerificationCode(270955);

$result = $deposit->doRequest();
$errors = $deposit->getExecutionErrors();
$ip = $deposit->getIP();
var_dump($result);
var_dump($errors);
var_dump($ip);
?>