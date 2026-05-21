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

/* CHECK ADMIN ROLE */
if($_SESSION['role'] != 'admin'){
    header("Location: ../../student/dashboard.php");
    exit();
}

/* FETCH EVENTS */
$query = "SELECT * FROM events ORDER BY event_date ASC";
$result = mysqli_query($conn, $query);

if(!$result){
    die("Query Failed: " . mysqli_error($conn));
}

/* COUNT EVENTS */
$countQuery = mysqli_query($conn, "SELECT COUNT(*) as total FROM events");
$countData = mysqli_fetch_assoc($countQuery);
$totalEvents = $countData['total'];
?>

<!DOCTYPE html>
<html>

<head>

    <title>Manage Events</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">

    <style>

        body{
            background: #f4f6f9;
        }

        .card-box{
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
            padding: 20px;
            color: white;
        }

        .blue{ background: #0d6efd; }
        .green{ background: #198754; }
        .orange{ background: #fd7e14; }

        .table-container{
            background: white;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        }

        .btn{
            border-radius: 8px;
        }

        .title{
            font-weight: 700;
        }

    </style>

</head>

<body>

<div class="container mt-4">

    <!-- HEADER -->
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h2 class="title">Manage Events</h2>

            <p class="text-muted mb-0">
                Welcome, <?= $_SESSION['name']; ?>
            </p>

        </div>

        <div>

            <a href="add-event.php" class="btn btn-primary">
                + Add Event
            </a>

            <a href="../../auth/logout.php"
               class="btn btn-danger"
               onclick="return confirm('Are you sure you want to logout?')">
                Logout
            </a>

        </div>

    </div>

    <!-- STATS -->
    <div class="row mb-4">

        <div class="col-md-4 mb-3">
            <div class="card-box blue">
                <h5>Total Events</h5>
                <h2><?= $totalEvents ?></h2>
            </div>
        </div>

        <div class="col-md-4 mb-3">
            <div class="card-box green">
                <h5>Status</h5>
                <h2>Active</h2>
            </div>
        </div>

        <div class="col-md-4 mb-3">
            <div class="card-box orange">
                <h5>System</h5>
                <h2>Online</h2>
            </div>
        </div>

    </div>

    <!-- TABLE -->
    <div class="table-container">

        <h5 class="mb-3">Event List</h5>

        <table class="table table-hover align-middle">

            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Date</th>
                    <th>Slots</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>

            <?php while($row = mysqli_fetch_assoc($result)) { ?>

                <tr>

                    <td><?= $row['id']; ?></td>

                    <td><strong><?= $row['title']; ?></strong></td>

                    <td><?= $row['description']; ?></td>

                    <td><?= $row['event_date']; ?></td>

                    <td>
                        <span class="badge bg-secondary">
                            <?= $row['slots']; ?>
                        </span>
                    </td>

                    <td>

                        <a href="edit-event.php?id=<?= $row['id']; ?>"
                           class="btn btn-warning btn-sm">
                            Edit
                        </a>

                        <a href="delete-event.php?id=<?= $row['id']; ?>"
                           class="btn btn-danger btn-sm"
                           onclick="return confirm('Delete this event?')">
                            Delete
                        </a>

                        <a href="../registrants/registrants.php?event_id=<?= $row['id']; ?>"
                           class="btn btn-info btn-sm mt-1">
                            View Registrants
                        </a>

                    </td>

                </tr>

            <?php } ?>

            </tbody>

        </table>

    </div>

</div>

</body>
</html>
