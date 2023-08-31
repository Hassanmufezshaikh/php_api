<?php 

$url="http://localhost/php_api/indexapi.php";
$crl=curl_init();
curl_setopt($crl,CURLOPT_URL,$url);
curl_setopt($crl, CURLOPT_RETURNTRANSFER,true);
$result=curl_exec($crl);
curl_close($crl);
echo $result;


?> 