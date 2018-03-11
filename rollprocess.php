<?php
include_once ('header.php');
include_once ('db-connect.php');
/**
 * Created by PhpStorm.
 * User: elijah
 * Date: 2/03/18
 * Time: 1:27 PM
 */


$absentArrayHTName = array();
$absentArrayHTPhone = array();
$absentArrayHTName1 = array();
$absentArrayHTPhone1 = array();
$absentArrayHouse = array();
$absentArrayHouseName = array();
$absentArrayInd = array();
//$absentArrayName = array();
$Date = $_POST["date"];
$addDateQuery = "ALTER TABLE `Individuals` ADD `$Date` INT NOT NULL AFTER `Name`";
$conn->query($addDateQuery);
$newDate = date('d-m-Y', strtotime($Date));
$showDate = date('l, jS F Y', strtotime($Date));

foreach ($_POST["Person"] as $person) {
    //array_push($absentArray, $house);

    $query = "SELECT * FROM Individuals, Households WHERE Individuals.PersonID = $person AND Individuals.HouseID = Households.HouseID";
    $result = $conn->query($query);
    while ($row = $result->fetch_assoc()) {
        array_push($absentArrayInd,$row["PersonID"]);
        $query2 = "UPDATE `Individuals` SET `$Date`= 1 WHERE PersonID = $person";
        $conn->query($query2);
        if (!in_array($row["HouseName"],$absentArrayHouseName)){
            array_push($absentArrayHouseName,$row["HouseName"]);
        }
        if (!in_array($row["HouseID"],$absentArrayHouse)){
            array_push($absentArrayHouse,$row["HouseID"]);
            array_push($absentArrayHTName, $row["HomeTeacher"]);
            array_push($absentArrayHTPhone, $row["HTphone"]);
            if ($row["HTphone1"] != 0){
                array_push($absentArrayHTPhone1,$row["HTphone1"]);
                array_push($absentArrayHTName1,$row["HomeTeacher1"]);
            }else{
                array_push($absentArrayHTPhone1, null);
                array_push($absentArrayHTName1, null);
            }
        }

    }
}
$totalAbsent = count($absentArrayInd);
echo "<h3>$showDate</h3><p><b>$totalAbsent</b> people are missing</p>";

if ((!empty($absentArrayInd))){
    echo "<table class='receiptcont'>";
    echo "<tr class='Tableheader'><th>Name</th><th>Home Teachers</th><th>HT Mobile</th><th>Send HT Text</th></tr>";
    echo '<form method="post" action="Sent.php">';
for($i = 0; $i < count($absentArrayHouse); $i++) {
    echo <<< OUTPUT
<tr>
<th>
{$absentArrayHouseName[$i]}
</th>
<th>
{$absentArrayHTName[$i]}, {$absentArrayHTName1[$i]}
</th>
<th>
{$absentArrayHTPhone[$i]}, {$absentArrayHTPhone1[$i]}
</th>
<th>
<input type="checkbox" class="HouseCheck" onchange="countchecker()" name="HouseCheck[]" value="$absentArrayHouse[$i]" checked>
</th>
</tr>

OUTPUT;


    $query1 = "SELECT Individuals.Name,PersonID, Households.HouseName,HomeTeacher,HTphone,HomeTeacher1,HTphone1 FROM Individuals, Households WHERE Individuals.HouseID = {$absentArrayHouse[$i]} AND Individuals.HouseID = Households.HouseID";
    $result1 = $conn->query($query1);
    while ($row1 = $result1->fetch_assoc()){
        //echo print_r($row1);
        if (in_array($row1["PersonID"],$absentArrayInd)){

            $table = <<< OUTPUT

<tr>
<td>
{$row1["Name"]}
</td>
</tr>


OUTPUT;
            echo $table;
        }


    }

}
echo "</table>";

$serialHouse = serialize(array_values($absentArrayHouse));
$serialHTPhone = serialize(array_values($absentArrayHTPhone));
$serialHTPhone1 = serialize(array_values($absentArrayHTPhone1));

echo <<< OUTPUT
   <input type="hidden" name="House" value = '$serialHouse'>
   <input type="hidden" name="HTPhone" value = '$serialHTPhone'>
   <input type="hidden" name="HTPhone1" value = '$serialHTPhone1'>
    <div class="form-submit">
    <input type="hidden" value="$Date" name="Date">
    <input type="submit" onclick="spin_wheel()" id="Submit" value="Send Texts" name="Send">
    <p>Texts will be sent at 3:05pm today.</p>
    </div>
</form>
<div id="spinner"></div>

OUTPUT;

}

include_once ('footer.php');
?>

<script>
    function countchecker() {
        checkboxes = document.getElementsByClassName("HouseCheck");
        count = 0;
        for (i = 0; i < checkboxes.length; i++) {
            if (checkboxes[i].checked) {
                count = count + 1;
            }
        }

        if (count==1){
            document.getElementById("Submit").value = "Send " + count + " Text";
        }
        else {
            document.getElementById("Submit").value = "Send " + count + " Texts";
        }
    }
    
    function spin_wheel() {
        document.getElementById("spinner").innerHTML = '<div id="loader"></div>';
    }
</script>
