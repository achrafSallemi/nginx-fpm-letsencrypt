<?php
header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json');

$mem_var = new Memcache();
$mem_var->addServer("127.0.0.1", 11211);
$response = $mem_var->get("today");
if ($response) {
	echo $response;
} else {

	$curl = curl_init();

	curl_setopt_array($curl, array(
		CURLOPT_URL => "http://worldcup.sfg.io/matches/today",
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

	$mem_var->set("today", $response, 0, 60);
}
