<?php
session_start();
include __DIR__ . '/../config/db.php';

if(!isset($_SESSION['user_id'])){
    header("Location: ../auth/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$event_id = $_POST['event_id'];

$sql = "INSERT INTO registrations (user_id, event_id)
        VALUES ('$user_id', '$event_id')";

if(mysqli_query($conn, $sql)){
    header("Location: my-events.php");
    exit();
} else {
    echo "Error: " . mysqli_error($conn);
}
?>