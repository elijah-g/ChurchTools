<?php
/**
 * Created by PhpStorm.
 * User: elijah
 * Date: 8/03/18
 * Time: 9:56 PM
 */
include_once ("db-connect.php");
include("smsGateway.php");

if (isset($_POST['Send'])){
    //echo $_POST["House"];
    $Houses = unserialize($_POST["House"]);
    $Numbers = unserialize($_POST["HTPhone"]);
    $Numbers1 = unserialize($_POST["HTPhone1"]);
    $Date = $_POST["Date"];
    //echo $Date;
    $smsGateway = new SmsGateway('elijah.glass@gmail.com','Reds2017');
    $deviceid = 82436;
    $responses = array();
    $count = 0;
    for ($i = 0; $i < count($Houses); $i ++) {
        if (in_array($Houses[$i], $_POST["HouseCheck"])) {
            $query = "SELECT * FROM Individuals, Households WHERE Individuals.HouseID = $Houses[$i] AND Individuals.HouseID = Households.HouseID AND Individuals.`$Date` = 1";
            $result = $conn->query($query);
            $indArray = array();
            $numberArray = array();
            while ($row = $result->fetch_assoc()) {
                array_push($indArray, $row["Name"]);
                $houseName = $row["HouseName"];
            }
            array_push($numberArray, $Numbers[$i]);
            if ($Numbers1[$i] != null) {
                array_push($numberArray, $Numbers1[$i]);
            }


            $number = $numberArray;
            $message = "Hi, The following family member(s) from the $houseName family were not present at Church today: ";
            foreach ($indArray as $ind) {
                if (count($indArray) == 1) {
                    $message .= $ind;
                } else {
                    $message .= ", $ind";
                }
            }
            $options = ['send_at'=>strtotime("now"),'expires_at'=>strtotime("+1hour")];
            $message .= ". Please ensure their spiritual/temporal welfare & return & report. -The Bishopric-";
            $result = $smsGateway->sendMessageToNumber($number, $message, $deviceid,$options);
            //echo "$message<br>";
            $count = count + 1;

        }
    }
    echo "<script>alert('$count message(s) sent to server.');window.location.href='index.php';</script>";
}
else{
    header("location: index.php");
}
