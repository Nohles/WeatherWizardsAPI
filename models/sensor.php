<?php
class Sensor
{
  // DB stuff
  private $conn;

  // Sensor Properties
  public $sensor_id;
  public $temp;
  public $humidity;
  public $sensor_datetime;
  public $light;
  public $rain;
  public $moisture;
  public $PH;
  public $macAddress;
  public $runID;

  // Constructor with DB
  public function __construct($db)
  {
    $this->conn = $db;
  }


  public function read()
  {
    // Create query
    $query = 'SELECT sensor_id, temp, humidity, light, rain, moisture,PH, sensor_datetime, macAddress, runID FROM Plant.SensorData';

    // Prepare statement
    $stmt = $this->conn->prepare($query);

    // Execute query
    $stmt->execute();

    return $stmt;
  }

  // Get Single sensors data
  public function read_single()
  {
    // Create query
    $query = 'SELECT sensor_id, temp, humidity, light, rain, moisture,PH, sensor_datetime, macAddress, runID FROM Plant.SensorData Where sensor_id= ?';

    // Prepare statement
    $stmt = $this->conn->prepare($query);

    // Bind ID
    $stmt->bindParam(1, $this->sensor_id);

    // Execute query
    $stmt->execute();

    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    // Set properties
    $this->sensor_id = $row['sensor_id'];
    $this->humidity = $row['humidity'];
    $this->temp = $row['temp'];
    $this->light = $row['light'];
    $this->rain = $row['rain'];
    $this->moisture = $row['moisture'];
    $this->PH = $row['PH'];
    $this->sensor_datetime = $row['sensor_datetime'];
    $this->macAddress = $row['macAddress'];
    $this->runID = $row['runID'];
  }
  public function getSensorData()
  {
    // Create query

    $query = 'Select  A.temp,A.humidity,A.light,A.rain,A.moisture, B.PH, A.macAddress, A.sensor_Datetime,A.runID From (SELECT AVG(temp) temp,AVG(humidity) humidity, AVG(light) light,AVG(rain)rain , AVG(moisture) 
      moisture, macAddress, sensor_Datetime ,runID FROM Plant.SensorData 
      WHERE runID = ?) AS A join (Select AVG(PH) PH, runID From (SELECT PH, runID FROM Plant.SensorData WHERE runID = ? limit 3) ph) as B  On A.runID = B.runID;';


    // Prepare statement
    $stmt = $this->conn->prepare($query);

    // Bind ID
    $stmt->bindParam(1, $this->runID);
    $stmt->bindParam(2, $this->runID);

    // Execute query
    $stmt->execute();

    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    // Set properties
    //$this->sensor_id = $row['sensor_id'];
    $this->humidity = $row['humidity'];
    $this->temp = $row['temp'];
    $this->light = $row['light'];
    $this->rain = $row['rain'];
    $this->moisture = $row['moisture'];
    $this->PH = $row['PH'];
    $this->sensor_datetime = $row['sensor_Datetime'];
    $this->macAddress = $row['macAddress'];
    $this->runID = $row['runID'];
  }




  // Create sensor
  public function create()
  {
    // Create query
    $query = 'INSERT INTO Plant.SensorData SET  temp = :temp, humidity = :humidity, light = :light, rain = :rain, moisture = :moisture, PH = :PH, macAddress = :macAddress, runID = :runID;';

    // Prepare statement
    $stmt = $this->conn->prepare($query);

    // Clean data
    //$this->userID = htmlspecialchars(strip_tags($this->userID));
    $this->temp = htmlspecialchars(strip_tags($this->temp));
    $this->humidity = htmlspecialchars(strip_tags($this->humidity));
    $this->light = htmlspecialchars(strip_tags($this->light));
    $this->rain = htmlspecialchars(strip_tags($this->rain));
    $this->moisture = htmlspecialchars(strip_tags($this->moisture));
    $this->PH = htmlspecialchars(strip_tags($this->PH));
    $this->macAddress = htmlspecialchars(strip_tags($this->macAddress));
    $this->runID = htmlspecialchars(strip_tags($this->runID));

    // Bind data
    //$stmt->bindParam(':userID', $this->userID);
    $stmt->bindParam(':temp', $this->temp);
    $stmt->bindParam(':humidity', $this->humidity);
    $stmt->bindParam(':light', $this->light);
    $stmt->bindParam(':rain', $this->rain);
    $stmt->bindParam(':moisture', $this->moisture);
    $stmt->bindParam(':PH', $this->PH);
    $stmt->bindParam(':macAddress', $this->macAddress);
    $stmt->bindParam(':runID', $this->runID);

    // Execute query
    if ($stmt->execute()) {
      return true;
    }

    // Print error if something goes wrong
    printf("Error: %s.\n", $stmt->error);

    return false;
  }
}
