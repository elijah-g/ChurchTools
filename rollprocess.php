<?php

include_once ('db-connect.php');
/**
 * Created by PhpStorm.
 * User: elijah
 * Date: 2/03/18
 * Time: 1:27 PM
 */

$absentArray = array();
foreach ($_POST["Household"] as $house) {
    array_push($absentArray, $house);

    $query = "SELECT * FROM Households WHERE HouseID = $house";
    $result = $conn->query($query);
    while ($row = $result->fetch_assoc()) {
        echo "{$row["HouseName"]} Family were not at church<br>";
    }
}