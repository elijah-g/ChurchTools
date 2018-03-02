<?php
$pageTitle = 'Count the Sheep';
include('header.php');
require("db-connect.php");

//for loop to loop through each house hold
//$i < 4 will need to be changed to household count.
echo "<form method='post' action='rollprocess.php'>";
for ($i = 1; $i<4; $i++) {
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
            <p>$individualName <input type="checkbox" class="$householdID" name="Person[]" ></p>

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
</script>
