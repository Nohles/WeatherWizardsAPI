<?php 
  // Headers
  echo "test";
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

  // Get ID
  $user->userID = isset($_GET['userID']) ? $_GET['userID'] : die();
//   $jwt = isset($_GET['jwt']) ? $_GET['jwt'] : die();
// echo $jwt;
// get posted data
$data = json_decode(file_get_contents("php://input"));
 
// get jwt
$jwt=isset($data->jwt) ? $data->jwt : "";
echo $jwt;
  if($jwt){
 
    // if decode succeed, show user details
    try {
        // decode jwt
        $decoded = JWT::decode($jwt, $key, array('HS256'));
 
        // set response code
        http_response_code(200);
 
        // show user details
        echo json_encode(array(
            "message" => "Access granted."
            //"data" => $decoded->data
        ));
 
    }
  }
    // catch will be here
// }
//   // Get post
//   $user->read_single();

//   // Create array
//   $user_arr = array(
//     'userID' => $user->userID,
//     'stateName' => $user->stateName,
//     'zip' => $user->zip,
//     'city' => $user->city,
//     'country' => $user->country,
//     'macAddress' => $user->macAddress,
//   );

//   // Make JSON
//   print_r(json_encode($user_arr));