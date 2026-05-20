<?php
include __DIR__ . '/../config/db.php';

if(isset($_POST['register'])){

    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    // hash password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // insert to database
    $sql = "INSERT INTO users (name, email, password, role)
            VALUES ('$name', '$email', '$hashedPassword', '$role')";

    if(mysqli_query($conn, $sql)){
        echo "<script>alert('Register Successful!'); window.location.href='login.php';</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register</title>

    <!-- Bootstrap -->
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
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
        }
    </style>
</head>

<body>

<div class="card p-4">

    <h3 class="text-center mb-3">Student Register</h3>

    <form method="POST">

        <input type="text" name="name" class="form-control mb-3" placeholder="Full Name" required>

        <input type="email" name="email" class="form-control mb-3" placeholder="Email" required>

        <input type="password" name="password" class="form-control mb-3" placeholder="Password" required>

        <select name="role" class="form-control mb-3">
            <option value="student">Student</option>
            <option value="admin">Admin</option>
        </select>

        <button type="submit" name="register" class="btn btn-primary w-100">
            Register
        </button>

        <p class="text-center mt-3">
            Already have an account?
            <a href="login.php">Login</a>
        </p>

    </form>

</div>

</body>
</html>