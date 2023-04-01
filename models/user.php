<?php
class User
{
  // DB stuff
  private $conn;

  // Post Properties
  public $userID;
  public $email;
  public $password;
  public $stateName;
  public $zip;
  public $city;
  public $country;
  public $macAddress;

  // Constructor with DB
  public function __construct($db)
  {
    $this->conn = $db;
  }

  // Get users
  public function read()
  {
    // Create query
    $query = 'SELECT userID, stateName, zip, city, country, macAddress FROM Plant.userData';

    // Prepare statement
    $stmt = $this->conn->prepare($query);

    // Execute query
    $stmt->execute();

    return $stmt;
  }

  // Get Single user data
  public function read_single()
  {
    // Create query
    $query = 'SELECT userID, stateName, zip, city, country, macAddress FROM Plant.userData Where userID= ?';

    // Prepare statement
    $stmt = $this->conn->prepare($query);

    // Bind ID
    $stmt->bindParam(1, $this->userID);

    // Execute query
    $stmt->execute();

    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    // Set properties
    $this->userID = $row['userID'];
    $this->stateName = $row['stateName'];
    $this->zip = $row['zip'];
    $this->city = $row['city'];
    $this->country = $row['country'];
    $this->macAddress = $row['macAddress'];
  }

  // Create user
  public function create()
  {
    // Create query
    // $query = 'INSERT INTO Plant.userData SET email = :email, password = :password, zip = :zip, stateName = :stateName, city = :city, country = :country';
    $query = 'INSERT INTO Plant.userData SET email = :email, password = :password;';
    // Prepare statement
    $stmt = $this->conn->prepare($query);

    // Clean data
    //$this->userID = htmlspecialchars(strip_tags($this->userID));
    $this->email = htmlspecialchars(strip_tags($this->email));
    $this->password = htmlspecialchars(strip_tags($this->password));
    // $this->stateName = htmlspecialchars(strip_tags($this->stateName));
    // $this->zip = htmlspecialchars(strip_tags($this->zip));
    // $this->city = htmlspecialchars(strip_tags($this->city));
    // $this->country = htmlspecialchars(strip_tags($this->country));
    //$this->macAddress = htmlspecialchars(strip_tags($this->macAddress));
    $password_hash = password_hash($this->password, PASSWORD_BCRYPT);
    // Bind data
    //$stmt->bindParam(':userID', $this->userID);
    $stmt->bindParam(':email', $this->email);
    $stmt->bindParam(':password', $password_hash);
    // $stmt->bindParam(':stateName', $this->stateName);
    // $stmt->bindParam(':zip', $this->zip);
    // $stmt->bindParam(':city', $this->city);
    // $stmt->bindParam(':country', $this->country);
    //$stmt->bindParam(':macAddress', $this->macAddress);

    // Execute query
    if ($stmt->execute()) {
      return true;
    }

    // Print error if something goes wrong
    printf("Error: %s.\n", $stmt->error);

    return false;
  }

  public function login()
  {
    $query = 'SELECT userID, email, password FROM Plant.userData Where email= ' . ':email' . ' limit 0,1;';

    $stmt = $this->conn->prepare($query);

    $this->email = htmlspecialchars(strip_tags($this->email));
    $stmt->bindParam(':email', $this->email);
    // echo $this->email;

    $stmt->execute();

    // get number of rows
    $num = $stmt->rowCount();

    // echo $num;
    // if email exists, assign values to object properties for easy access and use for php sessions
    if ($num > 0) {

      // get record details / values
      $row = $stmt->fetch(PDO::FETCH_ASSOC);

      // assign values to object properties
      $this->userID = $row['userID'];
      $this->email = $row['email'];
      $this->password = $row['password'];
      //echo $this->password;


      // return true because email exists in the database
      return true;
    }
    // printf("Error: %s.\n", $stmt->error);
    // return false;
  }


  // Update Post
  public function update()
  {
    // Create query
    $query = 'UPDATE Plant.userData SET stateName = :stateName, zip = :zip, city = :city, country = :country, macAddress = :macAddress WHERE userID = :userID;';

    // Prepare statement
    $stmt = $this->conn->prepare($query);

    // Clean data

    $this->stateName = htmlspecialchars(strip_tags($this->stateName));
    $this->zip = htmlspecialchars(strip_tags($this->zip));
    $this->city = htmlspecialchars(strip_tags($this->city));
    $this->country = htmlspecialchars(strip_tags($this->country));
    $this->userID = htmlspecialchars(strip_tags($this->userID));
    $this->macAddress = htmlspecialchars(strip_tags($this->macAddress));


    $stmt->bindParam(':stateName', $this->stateName);
    $stmt->bindParam(':zip', $this->zip);
    $stmt->bindParam(':city', $this->city);
    $stmt->bindParam(':country', $this->country);
    $stmt->bindParam(':userID', $this->userID);
    $stmt->bindParam(':macAddress', $this->macAddress);

    // Execute query
    if ($stmt->execute()) {
      return true;
    }

    // Print error if something goes wrong
    printf("Error: %s.\n", $stmt->error);

    return false;
  }

  // Delete Post
  public function delete()
  {
    // Create query
    $query = 'DELETE FROM Plant.userData WHERE userID = :userID';

    // Prepare statement
    $stmt = $this->conn->prepare($query);

    // Clean data
    $this->userID = htmlspecialchars(strip_tags($this->userID));

    // Bind data
    $stmt->bindParam(':userID', $this->userID);

    // Execute query
    if ($stmt->execute()) {
      return true;
    }

    // Print error if something goes wrong
    printf("Error: %s.\n", $stmt->error);

    return false;
  }

  public function emailCheck()
  { 
    $query = 'SELECT email FROM Plant.userData WHERE email = :email;';
    // Prepare statement
    $stmt = $this->conn->prepare($query);

    // Clean data
    //$this->userID = htmlspecialchars(strip_tags($this->userID));
    $this->email = htmlspecialchars(strip_tags($this->email));

    //bind param
    $stmt->bindParam(':email', $this->email);
    // Execute query
    
    $stmt->execute();
    return $stmt;
  }


}
