<?php
// Headers
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
use \Firebase\JWT\Key;
// Instantiate DB & connect
$database = new Database();
$db = $database->connect();

// Instantiate blog post object
$user = new User($db);

// Get raw posted data
$authHeader = $_SERVER['HTTP_AUTHORIZATION'];
$arr = explode(" ", $authHeader);



$m = "T";

$jwt = $arr[1];
if ($jwt) {
  // if decode succeed, show user details
  // decode jwt
  try {
    $decoded = JWT::decode($jwt, $key, array('HS256'));
    $m = "Success";
  } catch (Exception $e) {

    $m = "Fail";
  }
}

if ($m == "Success") {

  echo json_encode(array(
    "message" => "Access granted.",
    "iat" => $decoded->iat,
    "userID" => $decoded->userID
  ));
} else if ($m == "Fail") {


  echo json_encode(array(
    "message" => "Access denied.",
    "error" => $e->getMessage()
  ));
}



    //   // // get jwt
  // $jwt=isset($data->jwt) ? $data->jwt : "";
//  $jwt = $arr[1];
//  if($jwt){

//    // if decode succeed, show user details
//    try {
//        // decode jwt
//        $decoded = JWT::decode($jwt, $key, array('HS256'));
        
//        // set response code
//        http_response_code(200);

//        // show user details
//        echo json_encode(array(
//            "message" => "Access granted.",
//            "iat" =>$decoded->iat,
//            "userID" => $decoded->userID
//        ));
//        }
//        catch (Exception $e){

//          // set response code
//          http_response_code(401);
      
//          // tell the user access denied  & show error message
//          echo json_encode(array(
//              "message" => "Access denied.",
//              "error" => $e->getMessage()
//          ));
//      }
//  }
