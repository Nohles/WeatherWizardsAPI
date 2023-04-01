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

  $result = $sensor->read();
  // Get row count
  $num = $result->rowCount();


  if ($num > 0) {

    $sensor_arr = array();


    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
      extract($row);

      $sensor_item = array(
        'sensor_id' => $sensor_id,
        'temp' => $temp,
        'humidity' => $humidity,
        'light' => $light,
        'rain' => $rain,
        'moisture' => $moisture,
        'sensor_datetime' => $sensor_datetime,
        'macAddress' => $macAddress,
        'runID' => $runID,

      );

      // Push to "data"
      array_push($sensor_arr, $sensor_item);
    }

    // Turn to JSON & output
    echo json_encode($sensor_arr);
  } else {

    echo json_encode(
      array('message' => 'No Sensor Found')
    );
  }
} else if ($m == "Fail") {


  echo json_encode(array(
    "message" => "Access denied.",
    "error" => $e->getMessage()
  ));
}
