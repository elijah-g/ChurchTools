<link rel="stylesheet" href="cssOne.css" type="text/css">
<?php
/**
 * Created by PhpStorm.
 * User: elijah
 * Date: 1/05/18
 * Time: 7:43 PM
 */

$headings = ["Members Without Callings","Callings requested from Auxiliaries","Callings in Discussion","Interviews for Callings","Callings on Hold","WWC required","To be Sustained","To be Set Apart","Clerk to Record"];

foreach ($headings as $heading) {
    echo <<<OUTPUT
<h3>$heading</h3>
<list>
OUTPUT;
    //foreach (){
    echo "<li>Joel as EQP | ";
    echo '<div class="dropdown">';
echo '<button onclick="myFunction()" class="dropbtn">Move to</button>';
 echo '<div id="myDropdown" class="dropdown-content">';
 foreach ($headings as $heading1){
    echo '<button onclick="">heading</button>';
 }
  echo '</div></div>';
echo "</li></list>";

}
//}

?>

<script>
    /* When the user clicks on the button,
    toggle between hiding and showing the dropdown content */
    function myFunction() {
        document.getElementById("myDropdown").classList.toggle("show");
    }

    // Close the dropdown if the user clicks outside of it
    window.onclick = function(event) {
        if (!event.target.matches('.dropbtn')) {

            var dropdowns = document.getElementsByClassName("dropdown-content");
            var i;
            for (i = 0; i < dropdowns.length; i++) {
                var openDropdown = dropdowns[i];
                if (openDropdown.classList.contains('show')) {
                    openDropdown.classList.remove('show');
                }
            }
        }
    }
</script>
