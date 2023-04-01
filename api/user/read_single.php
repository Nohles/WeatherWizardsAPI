<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  include_once '../../config/Database.php';
  include_once '../../models/user.php';

  include_once 'libs/php-jwt-master/src/BeforeValidException.php';
  include_once 'libs/php-jwt-master/src/ExpiredException.php';
  include_once 'libs/php-jwt-master/src/SignatureInvalidException.php';
  include_once 'libs/php-jwt-master/src/JWT.php';
  use \Firebase\JWT\JWT;

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate blog post object
  $user = new User($db);

  // Get ID
  $user->userID = isset($_GET['userID']) ? $_GET['userID'] : die();

  // Get post
  $user->read_single();

  // Create array
  $user_arr = array(
    'userID' => $user->userID,
    'stateName' => $user->stateName,
    'zip' => $user->zip,
    'city' => $user->city,
    'country' => $user->country,
    'macAddress' => $user->macAddress,
  );

  // Make JSON
  print_r(json_encode($user_arr));