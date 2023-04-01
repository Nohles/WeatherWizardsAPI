<?php
class Runs
{
  // DB stuff
  private $conn;

  // Post Properties
  public $runID;
  public $userID;
  public $timeStarted;
  public $timeToEnd;
  public $runName;
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
    //$query = 'SELECT runID, userID, timeStarted, timeToEnd, runName, macAddress FROM Plant.Runs';
    $query = 'SELECT * FROM Plant.Runs Where userID= ? and runName != "" ORDER BY runID DESC  Limit 20';

    // Prepare statement
    $stmt = $this->conn->prepare($query);

    $stmt->bindParam(1, $this->userID);
    // Execute query
    $stmt->execute();

    return $stmt;
  }

  // Get Single user data
  public function read_single()
  {
    // Create query
    $query = 'SELECT runID, userID, timeStarted, timeToEnd, runName, macAddress FROM Plant.Runs Where userID= ?';

    // Prepare statement
    $stmt = $this->conn->prepare($query);

    // Bind ID
    $stmt->bindParam(1, $this->userID);

    // Execute query
    $stmt->execute();

    return $stmt;
  }


  public function getnewRuns()
  {
    // Create query
    $query = 'SELECT * FROM Plant.Runs where runName = "";';

    // Prepare statement
    $stmt = $this->conn->prepare($query);

    // Bind ID
    $stmt->bindParam(1, $this->userID);

    // Execute query
    $stmt->execute();

    return $stmt;
  }



  public function getRunID()
  {
    // Create query
    $query = 'SELECT * FROM Plant.Runs Where userID = ? and runName ="" limit 1;';

    // Prepare statement
    $stmt = $this->conn->prepare($query);

    // Bind ID
    $stmt->bindParam(1, $this->userID);

    // Execute query
    $stmt->execute();

    return $stmt;
  }

  public function getlastRunID()
  {
    // Create query
    $query = 'SELECT * FROM Plant.Runs Where userID= ? order by runID desc limit 1;';

    // Prepare statement
    $stmt = $this->conn->prepare($query);

    // Bind ID
    $stmt->bindParam(1, $this->userID);

    // Execute query
    $stmt->execute();

    return $stmt;
  }

  // Create user
  public function create()
  {
    // Create query
    $query = 'INSERT INTO Plant.Runs SET userID = :userID, timeToEnd = :timeToEnd, runName = :runName, macAddress = :macAddress';

    // Prepare statement
    $stmt = $this->conn->prepare($query);

    // Clean data
    //$this->runID = htmlspecialchars(strip_tags($this->runID));
    $this->userID = htmlspecialchars(strip_tags($this->userID));
    //$this->timeStarted = htmlspecialchars(strip_tags($this->timeStarted));
    $this->timeToEnd = htmlspecialchars(strip_tags($this->timeToEnd));
    $this->runName = htmlspecialchars(strip_tags($this->runName));
    $this->macAddress = htmlspecialchars(strip_tags($this->macAddress));
    // Bind data

    $stmt->bindParam(':userID', $this->userID);
    $stmt->bindParam(':timeToEnd', $this->timeToEnd);
    $stmt->bindParam(':runName', $this->runName);
    $stmt->bindParam(':macAddress', $this->macAddress);

    // Execute query
    if ($stmt->execute()) {

      return true;
    }

    // Print error if something goes wrong
    printf("Error: %s.\n", $stmt->error);

    return false;
  }

  // Update Post
  public function update()
  {
    // Create query
    $query = 'UPDATE Plant.Runs SET runName = :runName WHERE runID = :runID;';

    // Prepare statement
    $stmt = $this->conn->prepare($query);

    // Clean data

    $this->runName = htmlspecialchars(strip_tags($this->runName));
    $this->runID = htmlspecialchars(strip_tags($this->runID));



    $stmt->bindParam(':runName', $this->runName);
    $stmt->bindParam(':runID', $this->runID);

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
    $query = 'DELETE FROM Plant.Runs WHERE runID = :runID';

    // Prepare statement
    $stmt = $this->conn->prepare($query);

    // Clean data
    $this->runID = htmlspecialchars(strip_tags($this->runID));

    // Bind data
    $stmt->bindParam(':runID', $this->runID);

    // Execute query
    if ($stmt->execute()) {
      return true;
    }

    // Print error if something goes wrong
    printf("Error: %s.\n", $stmt->error);

    return false;
  }

  // Create user
  public function createFilters()
  {
    // Create query
    $query = 'INSERT INTO Plant.runFilters SET runID = ?, state = ?, season = ?, bloom = ?, type = ?, drought = ?, comm = ?, edible = ?;';

    // Prepare statement
    $stmt = $this->conn->prepare($query);

    // Clean data
    //$this->runID = htmlspecialchars(strip_tags($this->runID));
    $this->runID = htmlspecialchars(strip_tags($this->runID));
    //$this->timeStarted = htmlspecialchars(strip_tags($this->timeStarted));
    $this->state = htmlspecialchars(strip_tags($this->state));
    $this->season = htmlspecialchars(strip_tags($this->season));
    $this->bloom = htmlspecialchars(strip_tags($this->bloom));
    $this->type = htmlspecialchars(strip_tags($this->type));
    $this->drought = htmlspecialchars(strip_tags($this->drought));
    $this->comm = htmlspecialchars(strip_tags($this->comm));
    $this->edible = htmlspecialchars(strip_tags($this->edible));
    // Bind data

    $stmt->bindParam(1, $this->runID);
    $stmt->bindParam(2, $this->state);
    $stmt->bindParam(3, $this->season);
    $stmt->bindParam(4, $this->bloom);
    $stmt->bindParam(5, $this->type);
    $stmt->bindParam(6, $this->drought);
    $stmt->bindParam(7, $this->comm);
    $stmt->bindParam(8, $this->edible);

    // Execute query
    if ($stmt->execute()) {

      return true;
    }

    // Print error if something goes wrong
    printf("Error: %s.\n", $stmt->error);

    return false;
  }

  public function getrunFilters()
  {
    // Create query
    $query = 'SELECT * FROM Plant.runFilters WHERE runID = ?;';

    // Prepare statement
    $stmt = $this->conn->prepare($query);

    // Bind ID
    $stmt->bindParam(1, $this->runID);

    // Execute query
    $stmt->execute();

    return $stmt;
  }
}
