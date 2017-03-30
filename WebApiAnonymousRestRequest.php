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
 * @package     WebApiSessionRestRequest.php
 * @copyright   Copyright (c) 2017 ProjectEight
 * @author      ProjectEight
 *
 */

$serviceUrl     = 'http://magento2-sample-modules.localhost.com/V1/customers';
$curl           = curl_init($serviceUrl);
//$curlPostData = [
//    "user_id"      => 42,
//    "emailaddress" => 'lorna@example.com',
//];
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
//curl_setopt( $curl, CURLOPT_POST, true );
//curl_setopt( $curl, CURLOPT_POSTFIELDS, $curlPostData );
$curlResponse = curl_exec($curl);
curl_close($curl);

echo $curlResponse;

//$xml = new SimpleXMLElement( $curlResponse );
