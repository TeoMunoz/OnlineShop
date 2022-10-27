<?php
/**
 * @OA\Info(title="OnlineShop", version="1.0")
 */

use Psr\Http\Message\ResponseInterface as Response;
	use Psr\Http\Message\ServerRequestInterface as Request;
	use Slim\Factory\AppFactory;
	use ReallySimpleJWT\Token;

	require __DIR__ . "/../vendor/autoload.php";
	require "model/registration.php";
	require_once "config/config.php";

    $app = AppFactory::create();

	function error($message, $code) {
		//Make the error to a Json.
		$error = array("message" => $message);
		echo json_encode($error);

		//The error Code
		http_response_code($code);

		die();
	}

	require "controller/functions.php";
	
	$app->run();

?>