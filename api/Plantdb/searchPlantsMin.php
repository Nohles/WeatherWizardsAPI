<?php
// Headers
header("Access-Control-Allow-Origin: http://localhost/");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../../config/Database.php';
include_once '../../models/plantdb.php';

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
$plantdb = new Plantdb($db);

$authHeader = $_SERVER['HTTP_AUTHORIZATION'];
$arr = explode(" ", $authHeader);



// // Get ID
// $plantdb->TemperatureMinimum = isset($_GET['TemperatureMinimum']) ? $_GET['TemperatureMinimum'] : die();
// $plantdb->MoistureUse = isset($_GET['moisture']) ? $_GET['moisture'] : die();
// $plantdb->ShadeTolerance = isset($_GET['Shade']) ? $_GET['Shade'] : die();
$var1 = isset($_GET['CommonName']) ? $_GET['CommonName'] : die();
$plantdb->CommonName = '%' . $var1 . '%';
//sciencfic
//misspelled
$var6 = isset($_GET['GrowthHabit']) ? $_GET['GrowthHabit'] : die();
$plantdb->GrowthHabit = '%' . $var6 . '%';
$var4 = isset($_GET['season']) ? $_GET['season'] : die();
$plantdb->ActiveGrowthPeriod = '%' . $var4 . '%';
$var5 = isset($_GET['State']) ? $_GET['State'] : die();
$plantdb->State = '%' . $var5 . '%';
$var7 = isset($_GET['BloomPeriod']) ? $_GET['BloomPeriod'] : die();
$plantdb->BloomPeriod = '%' . $var7 . '%';
$var8 = isset($_GET['CommercialAvailability']) ? $_GET['CommercialAvailability'] : die();
$plantdb->CommercialAvailability = '%' . $var8 . '%';
$var9 = isset($_GET['DroughtTolerance']) ? $_GET['DroughtTolerance'] : die();
$plantdb->DroughtTolerance = '%' . $var9 . '%';
$plantdb->PalatableHuman = isset($_GET['PalatableHuman']) ? $_GET['PalatableHuman'] : die();

// $plantdb->PalatableHuman = '%'.$var10.'%';
// if($var10 = true){
//   $plantdb->PalatableHuman = "Yes";

// }else if($var10 = false){
//   $plantdb->PalatableHuman = "No";
// }

// $var11 = isset($_GET['NativeStatus']) ? $_GET['NativeStatus'] : die();
// $plantdb->NativeStatus = '%'.$var11.'%';


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


  $result = $plantdb->searchPlants();
  // Get row count
  $num = $result->rowCount();

  if ($num > 0) {

    $plant_arr = array();


    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
      extract($row);

      $plant_item = array(
        'betydbspeciesid' => $betydbspeciesid,
        'CommonName' => $CommonName,
        'GrowthHabit' => $GrowthHabit,
        'ScientificName' => $ScientificName,
        'BloomPeriod' => $BloomPeriod,

      );

      // Push to "data"
      array_push($plant_arr, $plant_item);
    }

    // Turn to JSON & output
    echo json_encode($plant_arr);
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


//$plantdb->TemperatureMinimum = '%'.$var.'%';
