<?php
$pageTitle = 'Attendance Report';
include('header.php');
require("db-connect.php");
if (isset($_COOKIE['login'])) {
    // Nothing to do - just keep on truckin'.
} else { // Not a teacher? You're out of here.
    $conn->close();
    header("location:index.php");
}

echo "Coming soon";
include('footer.php');