<?php
$pageTitle = 'Report';
include('header.php');
require("db-connect.php");
if (isset($_COOKIE['login'])) {
    // Nothing to do - just keep on truckin'.
} else { // Not a teacher? You're out of here.
    $conn->close();
    header("location:index.php");
}

$dateArray = array();
$dateCheckQuery = "SELECT `COLUMN_NAME` FROM `INFORMATION_SCHEMA`.`COLUMNS` WHERE `TABLE_SCHEMA`='ChurchTools' AND `TABLE_NAME`='Individuals'";
$dateCheck = $conn->query($dateCheckQuery);

while ($row2 = $dateCheck->fetch_assoc()){
    array_push($dateArray,$row2["COLUMN_NAME"]);
}


$dateOne = date_create($dateArray[3]);
$dateOne = date_format($dateOne,"j F Y");
$dateTwo = date_create($dateArray[4]);
$dateTwo = date_format($dateTwo,"j F Y");
$dateThree = date_create($dateArray[5]);
$dateThree = date_format($dateThree,"j F Y");
$dateFour = date_create($dateArray[6]);
$dateFour = date_format($dateFour,"j F Y");


$householdsquery = "SELECT COUNT(*) FROM Households";
$result3 = $conn->query($householdsquery);
while($row3 = $result3->fetch_assoc()){
    $count1 = $row3["COUNT(*)"]+1;
}
echo '<i class="fas fa-search"></i><input type="text" class="mytextwithicon" id="myInput" onkeyup="searchTable()" placeholder="Search for names.." title="Type in a name"><table id="myTable">';
//echo $count1;
for ($i = 1; $i<$count1; $i++) {
    $query = "SELECT * FROM Households WHERE HouseID = $i";
    $result = $conn->query($query);
    while ($row = $result->fetch_assoc()) {
        $householdname = $row['HouseName'];
        $householdID = $row['HouseID'];
        echo <<<OUTPUT
      
<tr id = "firstrow"><td id = "housename">$householdname</td><td id="date">$dateOne</td><td id="date">$dateTwo</td><td id="date">$dateThree</td><td id="date"></td></tr>
OUTPUT;

        $query2 = "SELECT * FROM Individuals WHERE HouseID = $i";
        $result2 = $conn->query($query2);
        while ($row2 = $result2->fetch_assoc()) {
            $individualName = $row2["Name"];
            $personID = $row2["PersonID"];
            $date1 = $row2[$dateArray[3]];
            $date2 = $row2[$dateArray[4]];
            $date3 = $row2[$dateArray[5]];
            $date4 = $row2[$dateArray[6]];
            $sumDate = $date1+$date2+$date3+$date4;
            if(($sumDate)>=2){
                echo "<tr><td><i class='fas fa-exclamation-triangle'></i>$individualName</td>";
            }
            else{
            echo "<tr><td>$individualName</td>";}


            #Check first date
            if ($date1 == 0){
                $emojiencode = html_entity_decode('&#10004;');
                echo "<td id = 'true'>$emojiencode</td>";
            }
            if ($date1 == 1){
                $emojiencode1 = html_entity_decode("&#10006;");
                echo "<td id ='false'>$emojiencode1</td>";
            }
            #Check 2nd Date
            if ($date2 == 0){
                $emojiencode = html_entity_decode('&#10004;');
                echo "<td id = 'true'>$emojiencode</td>";
            }
            if ($date2 == 1){
                $emojiencode1 = html_entity_decode("&#10006;");
                echo "<td id ='false'>$emojiencode1</td>";
            }
            #Check 3rd Date
            if ($date3 == null){
                echo "<td>-</td>";
            }
            elseif($date3 == 0){
                $emojiencode = html_entity_decode('&#10004;');
                echo "<td id = 'true'>$emojiencode</td>";
            }
            if ($date3 == 1){
                $emojiencode1 = html_entity_decode("&#10006;");
                echo "<td id ='false'>$emojiencode1</td>";
            }
            #Check 4th Date
            if($date4 == null){
                echo "<td>-</td>";
            }
            elseif($date4 == 0){
                $emojiencode = html_entity_decode('&#10004;');
                echo "<td id = 'true'>$emojiencode</td>";
            }
            if ($date4 == 1){
                $emojiencode1 = html_entity_decode("&#10006;");
                echo "<td id ='false'>$emojiencode1</td>";
            }

        }


    }
//    echo "<tr id = 'spacer'></tr>";
}
echo "</table>";
echo <<< OUTPUT
<script>
function searchTable() {
  var input, filter, table, tr, td, i;
  input = document.getElementById("myInput");
  filter = input.value.toUpperCase();
  table = document.getElementById("myTable");
  tr = table.getElementsByTagName("tr");
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[0];
    if (td) {
      if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }       
  }
}
</script>
OUTPUT;


include('footer.php');