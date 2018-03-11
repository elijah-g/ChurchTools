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
            $message = "Hi, The following individual(s) from the $houseName family were not at Church today: ";
            $first = true;
            foreach ($indArray as $ind) {
                $indEdit = explode(" ", $ind);
                if ($first){
                    $message .= $indEdit[0];
                    $first = false;
                }
                else {
                    $message .= ", $indEdit[0]";
                }
            }
            $options = ['send_at'=>strtotime("now"),'expires_at'=>strtotime("+1hour")];
            $message .= ". Please make sure they are okay and let us know. -The Bishopric";
            $result = $smsGateway->sendMessageToNumber($number, $message, $deviceid,$options);

            //echo "$message<br>";
            $count = count + 1;

        }
    }
    echo "<script>alert('$count message(s) sent to server.$message');window.location.href='index.php';</script>";
}
else{
    header("location: index.php");
}
