<?php
/**
 * ProjectEight
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this module to newer
 * versions in the future. If you wish to customize this module for your
 * needs please contact ProjectEight for more information.
 *
 * @category    magento2-sample-modules.localhost.com
 * @package     soap-api.php
 * @copyright   Copyright (c) 2017 ProjectEight
 * @author      ProjectEight
 *
 */

/**
 * Error reporting
 */
error_reporting(E_ALL | E_STRICT);

ini_set('display_errors', 1);

$opts        = [];
$wsdlUrl     = 'http://magento2-sample-modules.localhost.com/soap/default?wsdl&services=projectEightAddNewApiMethodCalculatorV1';
$serviceArgs = ["numberOne" => 1, "numberTwo" => 2];

try {
    $context    = stream_context_create($opts);
    $soapClient = new SoapClient($wsdlUrl, ['version' => SOAP_1_2, 'context' => $context, 'trace' => 1]);

    $soapResponse = $soapClient->projectEightAddNewApiMethodCalculatorV1Add($serviceArgs);
    echo "<pre>";
    print_r($soapResponse);
    echo "</pre>";
} catch (SoapFault $exception) {
    echo '<pre>';
    print_r($exception);
    echo '</pre>';
    echo '<p style="color:red;">' . $exception->getMessage() . '</p>';
}

exit(0);

$data = ['id' => 1];

$client = new SoapClient(
    'http://uk-qjacker.localhost.com/index.php/api/soap/?wsdl',
        ['version' => SOAP_1_2, 'trace' => 1]
);
//$client->__setCookie('XDEBUG_SESSION', 'PHPSTORM');

$session = $client->login('simon', 'ABC123');

try {
    $result = $client->call(
        $session,
        'qjacker_cashless.cardCreateTransaction',
        $data
    );
    echo "<pre>";
    print_r($result);
    echo "</pre>";
} catch (SoapFault $e) {
    echo '<pre>';
    print_r($e);
    echo '</pre>';
    echo '<p style="color:red;">' . $e->getMessage() . '</p>';
}

$client->endSession($session);