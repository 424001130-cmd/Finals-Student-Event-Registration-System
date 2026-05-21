<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
include __DIR__ . '/../../config/db.php'; 
// ⚠️ CHANGE THIS PATH if your db.php is not inside /config/

/* CHECK LOGIN */
if(!isset($_SESSION['user_id'])){
    header("Location: ../../auth/login.php");
    exit();
}

/* CHECK ADMIN ROLE */
if($_SESSION['role'] != 'admin'){
    header("Location: ../../student/dashboard.php");
    exit();
}

/* ADD EVENT */
if(isset($_POST['add_event'])){

    $title = $_POST['title'];
    $description = $_POST['description'];
    $event_date = $_POST['event_date'];
    $slots = $_POST['slots'];

    $query = "INSERT INTO events (title, description, event_date, slots)
              VALUES ('$title', '$description', '$event_date', '$slots')";

    $result = mysqli_query($conn, $query);

    /* IMPORTANT: SHOW ERROR IF INSERT FAILS */
    if(!$result){
        die("Insert Failed: " . mysqli_error($conn));
    }

    /* FIXED REDIRECT (SAFE PATH) */
    header("Location: ./events.php");
    exit();
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Add Event</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">
</head>

<body>

<div class="container mt-5">

    <h2>Add Event</h2>

    <form method="POST">

        <input type="text"
               name="title"
               placeholder="Event Title"
               class="form-control mb-3"
               required>

        <textarea name="description"
                  class="form-control mb-3"
                  placeholder="Description"
                  required></textarea>

        <input type="date"
               name="event_date"
               class="form-control mb-3"
               required>

        <input type="number"
               name="slots"
               placeholder="Available Slots"
               class="form-control mb-3"
               required>

        <button type="submit"
                name="add_event"
                class="btn btn-success">
            Add Event
        </button>

    </form>

</div>

</body>
</html>
