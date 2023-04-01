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


$sensor = new Sensor($db);

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

  // Get ID
  $sensor->sensor_id = isset($_GET['sensor_id']) ? $_GET['sensor_id'] : die();

  $sensor->read_single();

  // Create array
  $sensor_arr = array(
    'sensor_id' => $sensor->sensor_id,
    'temp' => $sensor->temp,
    'humidity' => $sensor->humidity,
    'light' => $sensor->light,
    'rain' => $sensor->rain,
    'mositure' => $sensor->mositure,
    'sensor_datetime' => $sensor->sensor_datetime,
    'macAddress' => $sensor->macAddress,
    'runID' => $sensor->runID,
  );

  // Make JSON
  print_r(json_encode($sensor_arr));
} else if ($m == "Fail") {


  echo json_encode(array(
    "message" => "Access denied.",
    "error" => $e->getMessage()
  ));
}
