<?php

$servername = "192.168.20.15";
$username = "root";
$password = "Reds2017";
$database = 'ChurchTools';

// Create connection
$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

mysqli_select_db($conn, $database) or die( "Unable to select database");

//$query = 'SELECT * FROM Logins';

//$result = $conn->query($query);
//
//while($row = $result->fetch_assoc()) {
//    echo $row["password"];
//}
?>