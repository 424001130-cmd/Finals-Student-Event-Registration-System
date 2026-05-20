<?php
if(session_status() == PHP_SESSION_NONE){
    session_start();
}
?>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">

        <a class="navbar-brand" href="#">
            Student Event System
        </a>

        <div class="collapse navbar-collapse" id="navbarNav">

            <ul class="navbar-nav ms-auto">

                <?php if(isset($_SESSION['user_id'])): ?>

                    <?php if($_SESSION['role'] == 'student'): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="/student-event-registration-system/student/dashboard.php">
                                Dashboard
                            </a>
                        </li>
                    <?php endif; ?>

                    <?php if($_SESSION['role'] == 'admin'): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="/student-event-registration-system/admin/events/events.php">
                                Manage Events
                            </a>
                        </li>
                    <?php endif; ?>

                    <!-- LOGOUT -->
                    <li class="nav-item">
                        <a class="nav-link text-danger" href="/student-event-registration-system/auth/logout.php">
                            Logout
                        </a>
                    </li>

                <?php else: ?>

                    <li class="nav-item">
                        <a class="nav-link" href="/student-event-registration-system/auth/login.php">
                            Login
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="/student-event-registration-system/auth/register.php">
                            Register
                        </a>
                    </li>

                <?php endif; ?>

            </ul>

        </div>
    </div>
</nav>