<?php
session_start();
include __DIR__ . '/../config/db.php';

// CHECK LOGIN
if(!isset($_SESSION['user_id'])){
    header("Location: ../auth/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];


$sql = "SELECT events.title, events.description, events.event_date, registrations.registered_at
        FROM registrations
        JOIN events ON registrations.event_id = events.id
        WHERE registrations.user_id = '$user_id'";

$result = mysqli_query($conn, $sql);
?>

<?php include __DIR__ . '/../includes/header.php'; ?>
<?php include __DIR__ . '/../includes/navbar.php'; ?>

<div class="container mt-5">

    <div class="card shadow p-4">

        <h2 class="mb-4">My Registered Events</h2>

        <?php if(mysqli_num_rows($result) > 0): ?>

            <table class="table table-bordered table-striped">

                <thead class="table-dark">
                    <tr>
                        <th>Event Title</th>
                        <th>Description</th>
                        <th>Date</th>
                        <th>Registered At</th>
                    </tr>
                </thead>

                <tbody>

                    <?php while($row = mysqli_fetch_assoc($result)): ?>

                        <tr>
                            <td><?php echo $row['title']; ?></td>
                            <td><?php echo $row['description']; ?></td>
                            <td><?php echo $row['event_date']; ?></td>
                            <td><?php echo $row['registered_at']; ?></td>
                        </tr>

                    <?php endwhile; ?>

                </tbody>

            </table>

        <?php else: ?>

            <div class="alert alert-warning">
                You have not registered for any events yet.
            </div>

        <?php endif; ?>

    </div>

</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>
