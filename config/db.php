<?php
$conn = mysqli_connect("localhost", "root", "", "student_event_system");

// check connection
if (!$conn) {
    die("Database Connection Failed: " . mysqli_connect_error());
}

?>