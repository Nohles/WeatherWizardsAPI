<?php
// Headers
header("Access-Control-Allow-Origin: http://localhost/");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../../config/Database.php';
include_once '../../models/results.php';

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

//
$results = new Results($db);

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

  $result = $results->read();
  // Get row count
  $num = $result->rowCount();

  // Check if any result
  if ($num > 0) {
    // Post array
    $results_arr = array();
    // $result_arr['data'] = array();

    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
      extract($row);

      $results_item = array(
        'resultsID' => $resultsID,
        'runID' => $runID,
        'betydbspeciesid' => $betydbspeciesid,


      );

      // Push to "data"
      array_push($results_arr, $results_item);
      // array_push($result_arr['data'], $post_item);
    }

    // Turn to JSON & output
    echo json_encode($results_arr);
  } else {
    // No result
    echo json_encode(
      array('message' => 'No results Found')
    );
  }
} else if ($m == "Fail") {


  echo json_encode(array(
    "message" => "Access denied.",
    "error" => $e->getMessage()
  ));
}
