<?php
if (empty($_POST['recaptcha'])) {
	exit('Verifikasi bahwa Anda bukan robot dengan reCaptcha');
}
$post = http_build_query(
 	array (
 		'response' => $response,
 		'secret' => $secretkey,
 		'remoteip' => $_SERVER['REMOTE_ADDR']
 	)
);
$opts = array('http' => 
	array (
		'method' => 'POST',
		'header' => 'application/x-www-form-urlencoded',
		'content' => $post
	)
);
$context = stream_context_create($opts);
$serverResponse = @file_get_contents('https://www.google.com/recaptcha/api/siteverify', false, $context);
$url = 'https://www.google.com/recaptcha/api/siteverify?secret=' . urlencode($secretkey) .  '&response=' . urlencode($response);
$response = file_get_contents($url);
$responseKeys = json_decode($response,true);  
if(!$responseKeys["success"]) {
	exit('Recaptcha tidak valid.');
}
?>