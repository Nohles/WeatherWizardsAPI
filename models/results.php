<?php 
  class Results {
    // DB stuff
    private $conn;

    // Post Properties
    public $resultsID;
    public $runID;
    public $betydbspeciesid;
 


    // Constructor with DB
    public function __construct($db) {
      $this->conn = $db;
    }

    // Get users
    public function read() {
      // Create query
      $query = 'SELECT resultsID, runID, betydbspeciesid FROM Plant.Results';
      
      // Prepare statement
      $stmt = $this->conn->prepare($query);

      // Execute query
      $stmt->execute();

      return $stmt;
    }

    // Get Single user data
    public function read_single() {
          // Create query
          $query = 'SELECT resultsID, runID, betydbspeciesid FROM Plant.Results Where resultsID= ?';

          // Prepare statement
          $stmt = $this->conn->prepare($query);

          // Bind ID
          $stmt->bindParam(1, $this->resultsID);

          // Execute query
          $stmt->execute();

          $row = $stmt->fetch(PDO::FETCH_ASSOC);

          // Set properties
          $this->resultsID = $row['resultsID'];
          $this->runID = $row['runID'];
          $this->betydbspeciesid = $row['betydbspeciesid'];
    }
  
    // Create user
    public function create() {
      // Create query
      
      $query = 'INSERT INTO Plant.Results SET betydbspeciesid = ?, runID = ?;';

      // Prepare statement
      $stmt = $this->conn->prepare($query);
     
      // Clean data
      //$this->resultsID = htmlspecialchars(strip_tags($this->resultsID));
      $this->runID = htmlspecialchars(strip_tags($this->runID));
      $this->betydbspeciesid = htmlspecialchars(strip_tags($this->betydbspeciesid));
   
      // Bind data
      //$stmt->bindParam(':resultsID', $this->resultsID);
      
      $stmt->bindValue(1, "".$this->betydbspeciesid);
      $stmt->bindValue(2, "".$this->runID);
     //echo $this->betydbspeciesid;
      // Execute query
      if($stmt->execute()) {
        
        return true;
      } 
      

  // Print error if something goes wrong
  printf("Error: %s.\n", $stmt->error);

  return false;
}

// Update Post
public function update() {
      // Create query
      $query = 'UPDATE Plant.results SET runID = :runID, betydbspeciesid = :betydbspeciesid WHERE resultsID = :resultsID;';

      // Prepare statement
      $stmt = $this->conn->prepare($query);

      // Clean data
      
      $this->runID = htmlspecialchars(strip_tags($this->runID));
      $this->betydbspeciesid = htmlspecialchars(strip_tags($this->betydbspeciesid));
      $this->resultsID = htmlspecialchars(strip_tags($this->resultsID));
      
     
      $stmt->bindParam(':runID', $this->runID);
      $stmt->bindParam(':betydbspeciesid', $this->betydbspeciesid);
      $stmt->bindParam(':resultsID', $this->resultsID);

      // Execute query
      if($stmt->execute()) {
        return true;
      }

      // Print error if something goes wrong
      printf("Error: %s.\n", $stmt->error);

      return false;
}

// Delete Post
  public function delete() {
      // Create query
      $query = 'DELETE FROM Plant.results WHERE resultsID = :resultsID';

      // Prepare statement
      $stmt = $this->conn->prepare($query);

      // Clean data
      $this->resultsID = htmlspecialchars(strip_tags($this->resultsID));

      // Bind data
      $stmt->bindParam(':resultsID', $this->resultsID);

      // Execute query
      if($stmt->execute()) {
        return true;
      }

      // Print error if something goes wrong
      printf("Error: %s.\n", $stmt->error);

      return false;
  }
public function searchRun() {
  // Create query
  $query = 'SELECT resultsID, runID, Results.betydbspeciesid, CommonName, ScientificName FROM Plant.Results left join plantdb on plantdb.betydbspeciesid = Results.betydbspeciesid where runID =  ?';
  
  // Prepare statement
  $stmt = $this->conn->prepare($query);
  
  $stmt->bindParam(1, $this->runID);

  // Execute query
  $stmt->execute();

  return $stmt;
}

public function resultsExists() {
  // Create query
  $query = 'SELECT * From Plant.Results Where runID = ?';
  
  // Prepare statement
  $stmt = $this->conn->prepare($query);
  
  $stmt->bindParam(1, $this->runID);

  // Execute query
  $stmt->execute();

  return $stmt;
}

}