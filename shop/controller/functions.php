<?php
    use Psr\Http\Message\ResponseInterface as Response;
	use Psr\Http\Message\ServerRequestInterface as Request;
	use Slim\Factory\AppFactory;
	use ReallySimpleJWT\Token;
/**
 * @OA\Post(
 *  path="/Authenticate",
 *  summary="Here you can authenticate yourself using a password",
 *  tags={""},
 *  requestBody=@OA\RequestBody(
 *      request="/Authenticate",
 *      required=true,
 *      description="Create the resquest body",
 *      @OA\MediaType(
 *          mediaType="application/json",
 *              @OA\Schema(
 *                  @OA\Property(property="username", type="string", example="Admin"),
 *                  @OA\Property(property="password", type="string", example="sec!ReT423*&")
 * )
 * )
 * ),
 * @OA\Response(response="200", description="Successfully Status 200"))
 * )
 */
    $app->post("/Authenticate", function (Request $request, Response $response, $args) {
		global $api_username;
		global $api_password;

		$request_body_string = file_get_contents("php://input");

		$request_data = json_decode($request_body_string, true);

		$username = $request_data["username"];
		$password = $request_data["password"];

		if ($username != $api_username || $password != $api_password) {
			error("Invalid credentials.", 401);
		}

		$token = Token::create($username, $password, time() + 3600, "localhost");

		setcookie("token", $token);

		echo "true";

		return $response;
	});

/**
 * @OA\Post(
 *  path="/Create Category",
 *  summary="Create neu Category",
 *  tags={""},
 *  requestBody=@OA\RequestBody(
 *      request="/RequestBody",
 *      required=true,
 *      description="A category is created in the data base",
 *      @OA\MediaType(
 *          mediaType="application/json",
 *              @OA\Schema(
 *                  @OA\Property(property="aktive", type="tinyint", example="1"),
 *                  @OA\Property(property="name", type="string", example="drawing")
 * )
 * )
 * ),
 * @OA\Response(response="200", description="Successfully createtd category Status 200"))
 * @OA\Response(response="400", description="No data requested Status 400"))
 * @OA\Response(response="500", description="Internal server error Status 500"))
 * )
 */

 $app->post("/Category", function (Request $resquest, Respondse $response, $args)) {
    require "controller/authentification_required.php";

    $request_body_string = file_get_contents("php://input");

    $request_data = json_decode($request_body_string, true);

    if(!isset($request_data["name"])) {
        error("Please giv a name.", 400);
    }

    if(!isset($request_data["active"]) || !is_numeric($request_data["active"])) {
            error("Pless enter a integer.", 400);
    }

    $active = intval($request_data["active"]);
    $name = strip_tags(addslashes($request_data["name"]));

	if(empty($name)) {
		error("Error Insert a name.", 400);
	}

	if(empty($active)) {
		error("Error Insert a active.", 400);
	}

	if(strlen($name) > 500) {
		error("The name is to long enter a name with max 500 letters.", 400);
	}

	if(float($active)) {
		error("The active can hav decimals," 400)
	}

	if(create_new_category($active, $name) === true) {
		http_response_code(201);
		echo"Category has been created.";
	}
	else {
		error("Error saving the data.", 500);
	}

	return $response;
 }

/**
 * @OA\Post(
 *  path="/Create Product",
 *  summary="Create neu Product",
 *  tags={""},
 *  requestBody=@OA\RequestBody(
 *      request="/RequestBody",
 *      required=true,
 *      description="A product is created in the data base",
 *      @OA\MediaType(
 *          mediaType="application/json",
 *              @OA\Schema(
 *                  @OA\Property(property="active", type="tinyint", example="1"),
 *                  @OA\Property(property="name", type="string", example="emotes")
 * )
 * )
 * ),
 * @OA\Response(response="200", description="Successfully createtd category Status 200"))
 * @OA\Response(response="400", description="No data requested Status 400"))
 * @OA\Response(response="500", description="Internal server error Status 500"))
 * )
 */

 $app->post("/Product", function (Request $request, Response $response, $arg) {
	require "controller/authentication.php";

	$request_body_string = file_get_contents("php://input");

	$request_data = json_decode($request_body_string, true);

	if(!isset($request_data["sku"])) {
		error("Pless provide a sku.", 400);
	}

	if(!isset($request_data["active"]) || !is_numeric($request_data["active"])) {
		error("Pless provide a integer.", 400)
	}

	if(!isset($request_data["id_category"]) || !is_numeric($request_data["id_category"])) {
		error("Pless provide a integer nunber.", 400)
	}

	if(!isset($request_data["name"])) {
		error("Pless provide a name.", 400)
	}

	if(!isset($request_data["image"])) {
		error("Pless provide a image.", 400)
	}

	if(!isset($request_data["description"])) {
		error("Pless provide a description.", 400)
	}

	if(!isset($request_data["price"]) || !is_numeric($request_data["price"])) {
		error("Pless provide a integer nunber.", 400)
	}

	if(!isset($request_data["stock"]) || !is_numeric($request_data["stock"])) {
		error("Pless provide a integer nunber.", 400)
	}

	$sku = strip_tags(addslashes($request_data["sku"]));
	$active = intval($request_data["active"]);
	$category_id = intval($request_data["category_id"]);
	$name = strip_tags(addslashes($request_data["name"]));
	$image = strip_tags(addslashes($request_data["image"]));
	$name = strip_tags(addslashes($request_data["description"]));
	$price = intval($request_data["price"]);
	$stock = intval($request_data["stock"]);

	if(empty($sku)) {
		error("The sku field must not be empty", 400);
	}

	if(empty($active)) {
		error("The active field must not be empty", 400);
	}

	if(empty($category_id)) {
		error("The category_id field must not be empty", 400);
	}

	if(empty($name)) {
		error("The name field must not be empty", 400);
	}

	if(empty($image)) {
		error("The image field must not be empty", 400);
	}

	if(empty($description)) {
		error("The sku description must not be empty", 400);
	}

	if(empty($price)) {
		error("The price field must not be empty", 400);
	}

	if(empty($stock)) {
		error("The stock field must not be empty", 400);
	}

	if(empty($sku) > 100) {
		error("The sku is to loong , no more taht 100 characters", 400);
	}

	if(is_float($sctive)) {
		error("No decimals", 400);
	}

	if(is_float($category_id)) {
		error("Id can hav decimals", 400);
	}

	if(strlen($name) > 500) {
		error("the name is too long dont giv more that 500 caracters", 400);
	}

	if(strlen($image) > 1000) {
		error("the image date is too long dont giv more that 1000 caracters", 400);
	}

	if($price < 0 || $price > 65.2) {
		error("The price must be between o and 65,2$", 400)
	}

	if(is_float($stock)) {
		error("Stock must hav decimals", 400);
	}

	if(create_new_product($sku, $active, $description, $price, $image, $stock) === true) {
		http_response_code(201);
		echo"New product has been created";
	}
	else {
		error("Error ocurred while saving the product.", 500);
	}

	return $response;
});

/**
 * @OA\Get(
 *  path="/Category/{category_id}",
 *  summary="update the category",
 *  tags={category""},
 *  requestBody=@OA\RequestBody(
 *      request="/RequestBody",
 *      required=true,
 *      description="find the id in the data base",
 *      @OA\MediaType(
 *          mediaType="application/json",
 *              @OA\Schema(
 *                  @OA\Property(property="active", type="tinyint", example="1"),
 *                  @OA\Property(property="name", type="string", example="drawing")
 * )
 * )
 * ),
 * @OA\Response(response="200", description="Successfully createtd category Status 200"))
 * @OA\Response(response="400", description="No data requested Status 400"))
 * @OA\Response(response="500", description="Internal server error Status 500"))
 * )
 */

$app->get("/Product/{product_id}", function (Request $request, Response $response, $arg) {
	require "controller/authentication.php";

	$product_id = intval($args["product_id"]);
	
	$product = get_category($product_id);

	if(!$product) {
		error($product, 500);
	}
	else{
		echo json_encode($product);
	}

	return $response;
	});

/**
 * @OA\Put(
 *  path="/Category/{category_id}",
 *  summary="update the category",
 *  tags={category""},
 *  requestBody=@OA\RequestBody(
 *      request="/RequestBody",
 *      required=true,
 *      description="find the id in the data base",
 *      @OA\MediaType(
 *          mediaType="application/json",
 *              @OA\Schema(
 *                  @OA\Property(property="active", type="tinyint", example="1"),
 *                  @OA\Property(property="name", type="string", example="drawing")
 * )
 * )
 * ),
 * @OA\Response(response="200", description="Successfully createtd category Status 200"))
 * @OA\Response(response="400", description="No data requested Status 400"))
 * @OA\Response(response="500", description="Internal server error Status 500"))
 * )
 */	

$app->put("/Category/{product_id}", function (Request $request, Response $response, $arg) {
	require "controller/authentication.php";

	$category_id = intval($args["category_id"]);

	$category_id = get_category($category_id);

	if(!$category) {
		error("No ID for the category" . $category_id".", 404);
	}

	$request_body_string = file_get_contents("php://input");

	$request_data = json_decode($request_body_string, true);

	if (!isset($request_data["name"])) {
		$name = string_tags(addslashes($request_data["name"]));
	}
		if (empty($name)) {
			error("Error giv a name.", 400)
		}

		if(strlen($name) > 500) {
			error("The name ist too long max 500.", 400)
		}

		return $response
	});

/**
 * @OA\Delete(
 *  path="/Category/{category_id}",
 *  summary="Use to delete registration",
 *  tags={"category"},
 *  requestBody=@OA\RequestBody(
 *      request="/RequestBody",
 *      required=true,
 *      description="use to delet",
 *      @OA\MediaType(
 *          mediaType="application/json",
 *              @OA\Schema(
 *                  @OA\Property(property="active", type="tinyint", example="1"),
 *                  @OA\Property(property="name", type="string", example="drawing")
 * )
 * )
 * ),
 * @OA\Response(response="200", description="Successfully createtd category Status 200"))
 * @OA\Response(response="400", description="No data requested Status 400"))
 * @OA\Response(response="500", description="Internal server error Status 500"))
 * )
 */	

 $app->delete("/Category{catagory_id}", function (Request $request, Response $response, $arg) {
	require "controller/autentication.php";

	$category_id = intval($args["category_id"]);

	$result = delete_category($category_id);

	if(!$result) {
		error("No category" . $category_id . ".", 404)
	}
	else if(is_string($result)) {
		error($category, 500)
	}
	else {
		echo json_encode($result);
	}

	return $response;
 })

 /**
 * @OA\Delete(
 *  path="/Category/{product_id}",
 *  summary="Use to delete product",
 *  tags={"product"},
 *  requestBody=@OA\RequestBody(
 *      request="/RequestBody",
 *      required=true,
 *      description="use to delet",
 *      @OA\MediaType(
 *          mediaType="application/json",
 *              @OA\Schema(
 *                  @OA\Property(property="active", type="tinyint", example="1"),
 *                  @OA\Property(property="name", type="string", example="drawing")
 * )
 * )
 * ),
 * @OA\Response(response="200", description="Successfully createtd category Status 200"))
 * @OA\Response(response="400", description="No data requested Status 400"))
 * @OA\Response(response="500", description="Internal server error Status 500"))
 * )
 */	

$app->delete("/Product{prosuct_id}", function (Request $request, Response $response, $arg) {
	require "controller/autentication.php";

	$product_id = intval($args["product_id"]);

	$result = delete_product($product_id);

	if(!$result) {
		error("No product" . $category_id . ".", 404)
	}
	else if(is_string($result)) {
		error($category, 500)
	}
	else {
		echo json_encode($result);
	}

	return $response;
 })

/**
 * @OA\Get(
 *  path="/Category",
 *  summary="Used to get all categories",
 *  tags={"product"},
 *  requestBody=@OA\RequestBody(
 *      request="/RequestBody",
 *      required=true,
 *      description="Ins necessarily used.",
 *      @OA\MediaType(
 *          mediaType="application/json",
 *              @OA\Schema(
 *                  @OA\Property(property="active", type="tinyint", example="1"),
 *                  @OA\Property(property="name", type="string", example="drawing")
 * )
 * )
 * ),
 * @OA\Response(response="200", description="Successfully createtd category Status 200"))
 * @OA\Response(response="400", description="No data requested Status 400"))
 * @OA\Response(response="500", description="Internal server error Status 500"))
 * )
 */

$app->get("/Categories", function (Request $request, Response $response, $arg) {
	require "controller/autentication.php";

	$categories = get_all_categorie();

	if(is_string($categories)) {
		error($categories, 500);
	}
	else {
		echo json_encode($categories);
	}

	return $response;
 });

/**
 * @OA\Get(
 *  path="/Products",
 *  summary="Used to get all products",
 *  tags={"General"},
 *  requestBody=@OA\RequestBody(
 *      request="/parameter",
 *      required=true,
 *      description="Ins necessarily used.",
 *      @OA\MediaType(
 *          mediaType="application/json",
 *              @OA\Schema(
 *                  @OA\Property(property="active", type="tinyint", example="1"),
 *                  @OA\Property(property="name", type="string", example="drawing")
 * )
 * )
 * ),
 * @OA\Response(response="200", description="Successfully createtd category Status 200"))
 * @OA\Response(response="400", description="No data requested Status 400"))
 * @OA\Response(response="500", description="Internal server error Status 500"))
 * )
 */
$app->get("/Products", function (Request $request, Response $response, $arg) {
	require "controller/autentication.php";

	$product = get_all_products();

	if(is_string($product)) {
		error($products);
	}
	else {
		echo json_encode($products);
	}

	return $response;
}
?>