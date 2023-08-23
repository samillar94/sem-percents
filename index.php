<?php
require 'src/Functions.php';
use App\Functions;
$proxy = json_decode(file_get_contents('proxyregistry.json'), true);

/// Register on startup
$postData = json_encode(["name" => "percents", "healthy" => true]);
$ch = curl_init($proxy['uris'][0]); /// TODO cycle through
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);

/// Respond to HTTP GET requests
if ($_SERVER['REQUEST_METHOD'] === 'GET') {

	header("Access-Control-Allow-Origin: *");
    header('Content-Type: application/json');

	$resToFront = array(
		"error"=> true
	);

	$functions = new Functions();

	try {
		$extractedData = $functions->extractData($_REQUEST);
		$resToFront = $functions->buildResponse($extractedData);
	} catch (Exception $e) {
		$resToFront['message'] = "A function threw an exception: {$e}";
	}

	echo json_encode($resToFront);

};
?>
