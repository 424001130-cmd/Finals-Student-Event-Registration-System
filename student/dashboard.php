<?php
session_start();
include __DIR__ . '/../config/db.php';

/* CHECK LOGIN */
if(!isset($_SESSION['user_id'])){
    header("Location: ../auth/login.php");
    exit();
}

/* CHECK IF STUDENT */
if($_SESSION['role'] != 'student'){
    header("Location: ../admin/events/events.php");
    exit();
}

/* HANDLE REGISTER EVENT */
if(isset($_POST['register_event'])){

    $user_id = $_SESSION['user_id'];
    $event_id = $_POST['event_id'];

    /* PREVENT DUPLICATE REGISTRATION */
    $check = "SELECT * FROM registrations
              WHERE user_id='$user_id'
              AND event_id='$event_id'";

    $check_result = mysqli_query($conn, $check);

    if(mysqli_num_rows($check_result) > 0){

        echo "<script>alert('You already registered for this event!');</script>";

    } else {

        $sql = "INSERT INTO registrations (user_id, event_id)
                VALUES ('$user_id', '$event_id')";

        if(mysqli_query($conn, $sql)){

            echo "<script>alert('Registration Successful!');</script>";

        } else {

            echo "Error: " . mysqli_error($conn);

        }
    }
}

/* FETCH EVENTS */
$query = "SELECT * FROM events ORDER BY event_date ASC";
$result = mysqli_query($conn, $query);

/* FETCH REGISTERED EVENTS */
$user_id = $_SESSION['user_id'];

$registered_query = "
    SELECT events.title, events.event_date
    FROM registrations
    JOIN events
    ON registrations.event_id = events.id
    WHERE registrations.user_id = '$user_id'
";

$registered_result = mysqli_query($conn, $registered_query);
?>

<?php include __DIR__ . '/../includes/header.php'; ?>
<?php include __DIR__ . '/../includes/navbar.php'; ?>

<!DOCTYPE html>
<html>

<head>

    <title>Student Dashboard</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">

    <style>

        body{
            background: #f4f6f9;
        }

        .dashboard-card{
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        }

        .welcome-box{
            background: linear-gradient(135deg, #0d6efd, #4f8cff);
            color: white;
            border-radius: 12px;
            padding: 25px;
        }

        .registered-box{
            background: white;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        }

    </style>

</head>

<body>

<div class="container mt-5">

    <!-- WELCOME -->
    <div class="welcome-box mb-4">

        <h2>
            Welcome,
            <?= $_SESSION['name']; ?> 👋
        </h2>

        <p class="mb-0">
            Register for upcoming school events below.
        </p>

    </div>

    <!-- REGISTERED EVENTS -->
    <div class="registered-box mb-5">

        <h4 class="mb-3">My Registered Events</h4>

        <?php if(mysqli_num_rows($registered_result) > 0){ ?>

            <ul class="list-group">

                <?php while($registered = mysqli_fetch_assoc($registered_result)) { ?>

                    <li class="list-group-item d-flex justify-content-between">

                        <span>
                            <?= $registered['title']; ?>
                        </span>

                        <span class="text-muted">
                            <?= $registered['event_date']; ?>
                        </span>

                    </li>

                <?php } ?>

            </ul>

        <?php } else { ?>

            <div class="alert alert-secondary">
                You have not registered for any events yet.
            </div>

        <?php } ?>

    </div>

    <!-- EVENTS -->
    <h3 class="mb-4">Upcoming Events</h3>

    <div class="row">

    <?php while($row = mysqli_fetch_assoc($result)) { ?>

        <div class="col-md-4 mb-4">

            <div class="card dashboard-card h-100">

                <div class="card-body d-flex flex-column">

                    <h5 class="card-title">
                        <?= $row['title']; ?>
                    </h5>

                    <p class="card-text">
                        <?= $row['description']; ?>
                    </p>

                    <p>
                        <strong>Date:</strong>
                        <?= $row['event_date']; ?>
                    </p>

                    <p>
                        <strong>Available Slots:</strong>

                        <span class="badge bg-secondary">
                            <?= $row['slots']; ?>
                        </span>
                    </p>

                    <form method="POST" class="mt-auto">

                        <input type="hidden"
                               name="event_id"
                               value="<?= $row['id']; ?>">

                        <button type="submit"
                                name="register_event"
                                class="btn btn-primary w-100">

                            Register

                        </button>

                    </form>

                </div>

            </div>

        </div>

    <?php } ?>

    </div>

</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>

</body>
</html>
