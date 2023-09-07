<?php

use Xenon\NagadApi\Base;
use Xenon\NagadApi\Exception\NagadPaymentException;
use Xenon\NagadApi\Helper;

require 'vendor/autoload.php';

if (isset($_POST['nagad-payment'])) {
    /**
     * ==============================================================================
     * all configuration are used here for demo purpose.
     * for use in dev mode use 'development'
     * for use in production mode use 'production'
     * ===============================================================================
     **/
    $config = [
        'NAGAD_APP_ENV' => 'development', //development|production
        'NAGAD_APP_LOG' => '1',
        'NAGAD_APP_ACCOUNT' => 'xxxxxxxxxxxx', //demo
        'NAGAD_APP_MERCHANTID' => 'xxxxxxxx', //demo
        'NAGAD_APP_MERCHANT_PRIVATE_KEY' => '',
        'NAGAD_APP_MERCHANT_PG_PUBLIC_KEY' => '',
        'NAGAD_APP_TIMEZONE' => 'Asia/Dhaka',
    ];

    try {
        $nagad = new Base($config, [
            'amount' => $_POST['price'],
            'invoice' => Helper::generateFakeInvoice(15, true),
            'merchantCallback' => 'http://localhost/nagad/nagad-payment-status.php',
        ]);

        $status = $nagad->payNow($nagad);
    } catch (NagadPaymentException $e) {
        echo 'Payment error ' . $e->getMessage();
    }

}