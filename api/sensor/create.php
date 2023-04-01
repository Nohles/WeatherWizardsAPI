<?php
// Headers
header("Access-Control-Allow-Origin: http://localhost/");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../../config/Database.php';
include_once '../../models/sensor.php';

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
$sensor = new Sensor($db);


$authHeader = $_SERVER['HTTP_AUTHORIZATION'];
$arr = explode(" ", $authHeader);

// Get raw posted data
// $data = json_decode(file_get_contents("php://input"));

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

  $sensor->temp = "" . $_GET['temp'];
  $sensor->humidity = "" . $_GET['humidity'];
  $sensor->light = "" . $_GET['light'];
  $sensor->rain = "" . $_GET['rain'];
  $sensor->moisture =  "" . $_GET['moisture'];
  $sensor->PH =  "" . $_GET['PH'];
  $sensor->macAddress = "" . $_GET['macAddress'];
  $sensor->runID =  "" . $_GET['runID'];

  //Create post
  if ($sensor->create()) {
    echo json_encode(
      array('message' => 'Sensor Created')
    );
  } else {
    echo json_encode(
      array('message' => 'sensor Not Created')
    );
  }
} else if ($m == "Fail") {


  echo json_encode(array(
    "message" => "Access denied.",
    "error" => $e->getMessage()
  ));
}
