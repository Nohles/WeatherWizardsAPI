<?php
// Headers
header("Access-Control-Allow-Origin: http://localhost/");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../../config/Database.php';
include_once '../../models/runs.php';

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
$run = new Runs($db);

$authHeader = $_SERVER['HTTP_AUTHORIZATION'];
$arr = explode(" ", $authHeader);
// Get ID
$run->userID = isset($_GET['userID']) ? $_GET['userID'] : die();

// Get post

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


  $result = $run->read_single();

  $num = $result->rowCount();

  if ($num > 0) {

    $run_arr = array();


    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
      extract($row);
      // Create array
      $run_item = array(
        'runID' => $runID,
        'userID' => $userID,
        'timeStarted' => $timeStarted,
        'timeToEnd' => $timeToEnd,
        'runName' => $runName,
        'macAddress' => $macAddress,

      );
      // Push to "data"
      array_push($run_arr, $run_item);
    }

    // Turn to JSON & output
    echo json_encode($run_arr);
  } else {
    // No Plants
    echo json_encode(
      array('message' => 'No plants Found')
    );
  }
} else if ($m == "Fail") {


  echo json_encode(array(
    "message" => "Access denied.",
    "error" => $e->getMessage()
  ));
}
