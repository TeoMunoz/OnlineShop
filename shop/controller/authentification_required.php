<?php
	use ReallySimpleJWT\Token;

	require_once "config/config.php";

	global $api_password;

	if (!isset($_COOKIE["token"]) || !Token::validate($_COOKIE["token"], $api_password)) {
		$error = array("message" => "You are Unauthorised try again.");
		echo json_encode($error);

		http_response_code(401);

		die();
	}
?>