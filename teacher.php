<?php
if(!isset($_COOKIE['login'])) {
    header("location: login.php");
}
$pageTitle = 'Count the Sheep';
include('header.php');
require("db-connect.php");
$dateArray = array();
$dateCheckQuery = "SELECT `COLUMN_NAME` FROM `INFORMATION_SCHEMA`.`COLUMNS` WHERE `TABLE_SCHEMA`='ChurchTools' AND `TABLE_NAME`='Individuals'";
$dateCheck = $conn->query($dateCheckQuery);
while ($row2 = $dateCheck->fetch_assoc()){
    array_push($dateArray,$row2["COLUMN_NAME"]);
    }

//for loop to loop through each house hold
//$i < 4 will need to be changed to household count.
echo "<form method='post' id='myForm' action='rollprocess.php'>";
?>
<div class="dateSelect">
<h2>Select todays date:</h2>
<input type="date" name="date" id="date" name="date" onchange="verifydate()" required>

<br>
    <br>
    <h2>Check those that are absent:</h2>
</div>
<p id="output"></p>
<p id = "output1"></p>

<?php
$householdsquery = "SELECT COUNT(*) FROM Households";
$result3 = $conn->query($householdsquery);
while($row3 = $result3->fetch_assoc()){
    $count1 = $row3["COUNT(*)"];
}
//echo $count1;
for ($i = 1; $i<$count1; $i++) {
    $query = "SELECT * FROM Households WHERE HouseID = $i";
    $result = $conn->query($query);
    while($row = $result->fetch_assoc()) {
        $householdname = $row['HouseName'];
        $householdID = $row['HouseID'];
        echo <<<OUTPUT

<fieldset>
<legend>$householdname <input type="checkbox" name="Household[]" id="$householdID" onchange="householdcheck($householdID)" value="$householdID" ></legend>
OUTPUT;

            $query2 = "SELECT * FROM Individuals WHERE HouseID = $i";
            $result2 = $conn->query($query2);
            while($row2 = $result2->fetch_assoc()) {
                $individualName = $row2["Name"];
                $personID = $row2["PersonID"];
                echo <<<OUTPUT
            <p>$individualName <input type="checkbox" class="$householdID" name="Person[]" value="$personID"></p>

OUTPUT;
            }
            echo "</fielset>";
}
}



echo "<br><br><input type='submit' value='Submit'>";
echo "</form>";
$conn->close();
include('footer.php');

?>

<script>
    function householdcheck(i) {
        members = document.getElementsByClassName(i);
        if (!document.getElementById(i).checked) {
            for (j = 0; j < members.length; j++) {
                members[j].checked = false;
            }
        }
        if (document.getElementById(i).checked) {
            for (j = 0; j < members.length; j++) {
                members[j].checked = true;
            }
        }
    }

    function verifydate() {
        var formdate = document.getElementById("date").value;
        formdateFormat = new Date(formdate);
        now = new Date();
        nowMonth = now.getMonth() +1;
        nowYear = now.getFullYear();
        nowDay = now.getDate();
        now.setHours(0,0,0,0);
        formYear = formdateFormat.getFullYear();
        formDate = formdateFormat.getDate();
        formDay = formdateFormat.getDay();
        formdateFormat.setHours(0,0,0,0);

        if (now > formdateFormat){
            document.getElementById("myForm").reset();
            alert("Date in the past!");
        }
        else if (formDay != 0){
            document.getElementById("myForm").reset();
            alert("Church is only on Sundays");
        }
        var dates = [];
        var data = <?php echo json_encode($dateArray)?>;
        for (var x in data){
            dates.push(data[x])
        }


        if (dates.includes(formdate)){
            document.getElementById("myForm").reset();
            alert("Date has already been recorded")
        }
    }

</script>
