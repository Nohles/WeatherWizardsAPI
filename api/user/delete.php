<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: DELETE');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

  include_once '../../config/Database.php';
  include_once '../../models/user.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate blog user object
  $user = new User($db);

  // Get raw user data
  $data = json_decode(file_get_contents("php://input"));

  // Set ID to update
  $user->userID = $data->userID;

  // Delete user
  if($user->delete()) {
    echo json_encode(
      array('message' => 'user Deleted')
    );
  } else {
    echo json_encode(
      array('message' => 'user Not Deleted')
    );
  }

