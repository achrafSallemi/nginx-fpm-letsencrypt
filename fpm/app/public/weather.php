<?php
header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json');

$client  = @$_SERVER['HTTP_CLIENT_IP'];
$forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
$remote  = @$_SERVER['REMOTE_ADDR'];
if (filter_var($client, FILTER_VALIDATE_IP)) {
	$ip = $client;
} elseif (filter_var($forward, FILTER_VALIDATE_IP)) {
	$ip = $forward;
} else {
	$ip = $remote;
}

$info = geoip_record_by_name($ip);
$city = 'berlin';


if (!empty($info['city'])) {
	$city = $info['city'];
}

/** get data from cache */
$mem_var = new Memcache();
$mem_var->addServer("127.0.0.1", 11211);
$response = $mem_var->get($city);
if ($response) {
	echo $response;
} else {

	$curl = curl_init();

	curl_setopt_array($curl, array(
		CURLOPT_URL => "http://api.openweathermap.org/data/2.5/forecast?q=" . $city . " &units=metric&cnt=7&appid=312e6bcd2486517069cea753dd6eac7b",
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => "",
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT_MS => 800,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => "GET",
		CURLOPT_HTTPHEADER => array(
			"cache-control: no-cache",
			"postman-token: 65d9f404-a385-f9b3-1500-51a87b58cf8b"
		),
	));

	$response = curl_exec($curl);
	$err = curl_error($curl);

	curl_close($curl);

	if ($err) {
		echo json_encode(['error' => $err]);
	}

	echo $response;

	$mem_var->set($city, $response, 0, 3600);
}
