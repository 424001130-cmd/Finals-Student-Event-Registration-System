<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

/* FIX DATABASE PATH */
include __DIR__ . '/../../config/db.php'; // CHANGE IF NEEDED

/* CHECK LOGIN */
if(!isset($_SESSION['user_id'])){
    header("Location: ../../auth/login.php");
    exit();
}

/* CHECK ADMIN */
if($_SESSION['role'] != 'admin'){
    header("Location: ../../student/dashboard.php");
    exit();
}

/* GET ID */
$id = $_GET['id'];

/* DELETE QUERY */
$query = "DELETE FROM events WHERE id='$id'";
$result = mysqli_query($conn, $query);

/* ERROR CHECK */
if(!$result){
    die("Delete Failed: " . mysqli_error($conn));
}

/* REDIRECT */
header("Location: events.php");
exit();
?>
