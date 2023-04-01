<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: POST');
  header("Access-Control-Max-Age: 3600");
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

  include_once '../../config/Database.php';
  include_once '../../models/user.php';

// generate json web token

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate blog post object
  $user = new User($db);

  // Get raw posted data
  //$data = json_decode(file_get_contents("php://input"));
  
  // $user->email = $data->email;
  // $user->password = $data->password;
  // $user->stateName = $data->stateName;
  // $user->zip = $data->zip;
  // $user->city = $data->city;
  // $user->country = $data->country;
  // $user->macAddress = $data->macAddress;

  
  $user->email = "" .$_GET['email'];
  $user->password = isset($_GET['password']) ? $_GET['password'] : die();
  
  // $user->stateName = "" .$_GET['stateName'];
  // $user->zip = "" .$_GET['zip'];
  // $user->city = "" .$_GET['city'];
  // $user->country = "" .$_GET['country'];
  // $user->macAddress = "" .$_GET['macAddress'];
  // Create post
  
  if($user->create()) {
    echo json_encode(
      array('message' => 'User Created')
    );
  } else {
    echo json_encode(
      array('message' => 'User Not Created')
    );
  }

