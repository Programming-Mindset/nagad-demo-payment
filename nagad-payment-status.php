<?php

use Xenon\NagadApi\Helper;

require 'vendor/autoload.php';
if($_GET['status'])
{

    $config = [
        'NAGAD_APP_ENV' => 'development', //development|production
        'NAGAD_APP_LOG' => '1',
        'NAGAD_APP_ACCOUNT' => 'xxxxxxxxxx', //demo
        'NAGAD_APP_MERCHANTID' => '6830x25', //demo
        'NAGAD_APP_MERCHANT_PRIVATE_KEY' => '',
        'NAGAD_APP_MERCHANT_PG_PUBLIC_KEY' => '',
        'NAGAD_APP_TIMEZONE' => 'Asia/Dhaka',
    ];

    $uri = $_SERVER['REQUEST_URI'];
    $protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
    $responseUrl = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    $responseArray = Helper::successResponse($responseUrl);

    if (isset($responseArray['payment_ref_id']))
    {
        $helper = new Helper($config);
        try {

            $response = $helper->verifyPayment($responseArray['payment_ref_id']);
            $responseObject = json_decode($response, true);
            if (isset($responseObject['status']) && $responseObject['status'] =='Success')
            {
                echo 'Payment successfully done';
            }else{
                echo 'Failed to pay. Something went wrong';
            }

        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

}



