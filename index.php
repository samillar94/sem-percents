<?php
require_once 'src/Functions.php'
$proxy = json_decode(file_get_contents('./proxyregistry.json'), true);

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

	try {
		$extractedData = extractData($_REQUEST['query'])
		$resToFront = buildResponse($extractedData)
	} catch (Exception $e) {
		$resToFront['message'] = $e;
	}

	echo json_encode($resToFront);

};
?>
