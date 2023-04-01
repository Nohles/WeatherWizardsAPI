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
// Get raw posted data
//$data = json_decode(file_get_contents("php://input"));



$run->runID = "" . $_GET['runID'];
//$run->timeStarted = $data->timeStarted;
$run->state = "" . $_GET['state'];
$run->season = "" . $_GET['season'];
$run->bloom = "" . $_GET['bloom'];
$run->type = "" . $_GET['type'];
$run->drought = "" . $_GET['drought'];
$run->comm = "" . $_GET['comm'];
$run->edible = "" . $_GET['edible'];


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

  // Create post
  if ($run->createFilters()) {

    echo json_encode(
      array('message' => 'runfilters Created')
      // array('runID' =>  "" . $db->lastinsertId())
    );
  } else {
    echo json_encode(
      array('message' => 'run Not Created')
    );
  }
} else if ($m == "Fail") {


  echo json_encode(array(
    "message" => "Access denied.",
    "error" => $e->getMessage()
  ));
}
