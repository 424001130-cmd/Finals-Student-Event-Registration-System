<?php
session_start();
include __DIR__ . '/../config/db.php';

// CHECK LOGIN
if(!isset($_SESSION['user_id'])){
    header("Location: ../auth/login.php");
    exit();
}

// HANDLE REGISTER EVENT
if(isset($_POST['register_event'])){

    $user_id = $_SESSION['user_id'];
    $event_id = $_POST['event_id'];

    $sql = "INSERT INTO registrations (user_id, event_id)
            VALUES ('$user_id', '$event_id')";

    if(mysqli_query($conn, $sql)){
        // IMPORTANT: correct path
        header("Location: my-event.php");
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<?php include __DIR__ . '/../includes/header.php'; ?>
<?php include __DIR__ . '/../includes/navbar.php'; ?>

<div class="container mt-5">

    <div class="card shadow p-4">

        <h1 class="mb-3">Student Dashboard</h1>

        <p>
            Welcome,
            <strong>
                <?php echo $_SESSION['name'] ?? 'User'; ?>
            </strong>
        </p>

        <hr>

        <h4>Upcoming Events</h4>

        <!-- EVENT CARD -->
        <div class="card mt-3">

            <div class="card-body">

                <h5 class="card-title">Programming Workshop</h5>

                <p class="card-text">
                    Beginner friendly coding workshop for students.
                </p>

                <p>
                    <strong>Date:</strong> June 20, 2026
                </p>

                <!-- FIXED FORM -->
                <form method="POST" action="">

                    <input type="hidden" name="event_id" value="1">

                    <button type="submit" name="register_event" class="btn btn-primary">
                        Register
                    </button>

                </form>

            </div>

        </div>

    </div>

</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>