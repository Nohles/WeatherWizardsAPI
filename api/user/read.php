<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  include_once '../../config/Database.php';
  include_once '../../models/user.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate blog post object
  $user = new User($db);

  // Blog post query
  $result = $user->read();
  // Get row count
  $num = $result->rowCount();

  // Check if any posts
  if($num > 0) {
    // Post array
    $user_arr = array();
    // $posts_arr['data'] = array();

    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
      extract($row);

      $user_item = array(
        'userID' => $userID,
        'stateName' => $stateName,
        'zip' => $zip,
        'city' => $city,
        'country' => $country,
        'macAddress' => $macAddress,
      );

      // Push to "data"
      array_push($user_arr, $user_item);
      // array_push($posts_arr['data'], $post_item);
    }

    // Turn to JSON & output
    echo json_encode($user_arr);

  } else {
    // No Posts
    echo json_encode(
      array('message' => 'No users Found')
    );
  }
