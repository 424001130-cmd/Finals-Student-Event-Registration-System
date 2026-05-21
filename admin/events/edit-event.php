<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

/* FIX DATABASE PATH (CHANGE IF NEEDED) */
include __DIR__ . '/../../config/db.php';

if(!isset($_SESSION['user_id'])){
    header("Location: ../../auth/login.php");
    exit();
}

if($_SESSION['role'] != 'admin'){
    header("Location: ../../student/dashboard.php");
    exit();
}

/* GET EVENT ID */
$id = $_GET['id'];

/* FETCH EVENT DATA */
$query = "SELECT * FROM events WHERE id='$id'";
$result = mysqli_query($conn, $query);

$row = mysqli_fetch_assoc($result);

/* UPDATE EVENT */
if(isset($_POST['update_event'])){

    $title = $_POST['title'];
    $description = $_POST['description'];
    $event_date = $_POST['event_date'];
    $slots = $_POST['slots'];

    $query = "UPDATE events SET
              title='$title',
              description='$description',
              event_date='$event_date',
              slots='$slots'
              WHERE id='$id'";

    mysqli_query($conn, $query);

    header("Location: events.php");
    exit();
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Edit Event</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">
</head>

<body>

<div class="container mt-5">

    <h2>Edit Event</h2>

    <form method="POST">

        <input type="text"
               name="title"
               value="<?= $row['title']; ?>"
               class="form-control mb-3"
               required>

        <textarea name="description"
                  class="form-control mb-3"
                  required><?= $row['description']; ?></textarea>

        <input type="date"
               name="event_date"
               value="<?= $row['event_date']; ?>"
               class="form-control mb-3"
               required>

        <input type="number"
               name="slots"
               value="<?= $row['slots']; ?>"
               class="form-control mb-3"
               required>

        <button type="submit"
                name="update_event"
                class="btn btn-success">
            Update Event
        </button>

    </form>

</div>

</body>
</html>
