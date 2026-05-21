<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
include __DIR__ . '/../../config/db.php';

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

/* GET ALL EVENTS FOR FILTER */
$eventsQuery = "SELECT * FROM events ORDER BY event_date ASC";
$eventsResult = mysqli_query($conn, $eventsQuery);

/* FILTER EVENT */
$selected_event = isset($_GET['event_id']) ? $_GET['event_id'] : '';

/* MAIN JOIN QUERY */
$query = "
SELECT 
    users.name AS student_name,
    users.email,
    events.title AS event_title,
    events.event_date
FROM registrations
JOIN users ON registrations.user_id = users.id
JOIN events ON registrations.event_id = events.id
";

if(!empty($selected_event)){
    $query .= " WHERE events.id = '$selected_event'";
}

$query .= " ORDER BY events.event_date DESC";

$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html>

<head>
    <title>Event Registrants</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body{
            background:#f4f6f9;
        }

        .container-box{
            background:white;
            padding:20px;
            border-radius:12px;
            box-shadow:0 4px 12px rgba(0,0,0,0.08);
        }
    </style>
</head>

<body>

<div class="container mt-5">

    <div class="d-flex justify-content-between align-items-center mb-3">

        <h2>Event Registrants</h2>

        <a href="../events/events.php" class="btn btn-secondary">
            Back to Events
        </a>

    </div>

    <!-- FILTER -->
    <div class="container-box mb-4">

        <form method="GET">

            <label class="form-label">Filter by Event:</label>

            <div class="d-flex gap-2">

                <select name="event_id" class="form-select">

                    <option value="">All Events</option>

                    <?php while($e = mysqli_fetch_assoc($eventsResult)) { ?>

                        <option value="<?= $e['id']; ?>"
                            <?= ($selected_event == $e['id']) ? 'selected' : '' ?>>

                            <?= $e['title']; ?>

                        </option>

                    <?php } ?>

                </select>

                <button class="btn btn-primary">
                    Filter
                </button>

            </div>

        </form>

    </div>

    <!-- TABLE -->
    <div class="container-box">

        <table class="table table-hover">

            <thead class="table-dark">

                <tr>

                    <th>Student Name</th>
                    <th>Email</th>
                    <th>Event</th>
                    <th>Date</th>

                </tr>

            </thead>

            <tbody>

            <?php if(mysqli_num_rows($result) > 0){ ?>

                <?php while($row = mysqli_fetch_assoc($result)) { ?>

                    <tr>

                        <td><?= $row['student_name']; ?></td>
                        <td><?= $row['email']; ?></td>
                        <td><?= $row['event_title']; ?></td>
                        <td><?= $row['event_date']; ?></td>

                    </tr>

                <?php } ?>

            <?php } else { ?>

                <tr>
                    <td colspan="4" class="text-center text-muted">
                        No registrations found.
                    </td>
                </tr>

            <?php } ?>

            </tbody>

        </table>

    </div>

</div>

</body>
</html>
