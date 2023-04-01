<?php
// Headers
// required headers
header("Access-Control-Allow-Origin: http://localhost/");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


include_once '../../config/Database.php';
include_once '../../models/user.php';
include_once '../../config/core.php';
include_once '../../libs/php-jwt-master/src/BeforeValidException.php';
include_once '../../libs/php-jwt-master/src/ExpiredException.php';
include_once '../../libs/php-jwt-master/src/SignatureInvalidException.php';
include_once '../../libs/php-jwt-master/src/JWT.php';

use \Firebase\JWT\JWT;
use Firebase\JWT\Key;
// Instantiate DB & connect
$database = new Database();
$db = $database->connect();

// Instantiate blog post object
$user = new User($db);

// Get ID
$user->email = isset($_GET['email']) ? $_GET['email'] : die();
$inputpassword = isset($_GET['password']) ? $_GET['password'] : die();

// Get post
$email_exists = $user->login();

if ($email_exists && password_verify($inputpassword, $user->password)) {

  $token = array(
    "iat" => $issued_at,
    "exp" => $expiration_time,
    "iss" => $issuer,
    "userID" => $user->userID,


  );

  // set response code
  http_response_code(200);

  // generate jwt

  $jwt = JWT::encode($token, $key, 'HS256');

  echo json_encode(
    array(
      "message" => "Successful login.",
      "jwt" => $jwt,
      "userID" =>  $user->userID
    )
  );
} else {

  // set response code
  http_response_code(401);

  // tell the user login failed
  echo json_encode(array("message" => "Login failed."));
}



  // Create array
  // $user_arr = array(
  //   'userID' => $user->userID,
  //   'email' => $user->email,
  //   'password' => $user->password,
    
  // );

  // // Make JSON
  // print_r(json_encode($user_arr));