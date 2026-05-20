<?php
session_start();
include __DIR__ . '/../config/db.php';

if(isset($_POST['login'])){

    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE email='$email'";
    $result = mysqli_query($conn, $sql);

    $user = mysqli_fetch_assoc($result);

    if($user){

        if(password_verify($password, $user['password'])){

            // SET SESSION
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['name'] = $user['name'];

            // REDIRECT BASED ON ROLE
            if($user['role'] == 'admin'){
                header("Location: ../admin/events/events.php");
                exit();
            } else {
                header("Location: ../student/dashboard.php");
                exit();
            }

        } else {
            echo "<script>alert('Wrong password');</script>";
        }

    } else {
        echo "<script>alert('User not found');</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(120deg, #141e30, #243b55);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .card {
            width: 400px;
            border-radius: 15px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.3);
        }
    </style>
</head>

<body>

<div class="card p-4">

    <h3 class="text-center mb-3">Login</h3>

    <form method="POST">

        <input type="email" name="email" class="form-control mb-3" placeholder="Email" required>

        <input type="password" name="password" class="form-control mb-3" placeholder="Password" required>

        <button type="submit" name="login" class="btn btn-dark w-100">
            Login
        </button>

        <p class="text-center mt-3">
            No account?
            <a href="register.php">Register</a>
        </p>

    </form>

</div>

</body>
</html>