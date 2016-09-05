 <?php
$url = 'http://localhost/fvm/curl';
$c = curl_init ($url);
$page = curl_exec ($c);
curl_close ($c);
echo $page;