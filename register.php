<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name  = $_POST['name'];
    $email = $_POST['email'];
    $pass  = password_hash($_POST['password'], PASSWORD_DEFAULT);

    /* CHECK IF EMAIL EXISTS */
    $check = sqlsrv_query(
        $conn,
        "SELECT UserID FROM Users WHERE Email = ?",
        [$email]
    );

    if ($check && sqlsrv_has_rows($check)) {
        $error = "This email is already registered. Please log in instead.";
    } else {
        /* INSERT NEW USER */
        $insert = sqlsrv_query(
            $conn,
            "INSERT INTO Users (FullName, Email, PasswordHash)
             VALUES (?, ?, ?)",
            [$name, $email, $pass]
        );

        if ($insert) {
            header("Location: login.php");
            exit;
        } else {
            $error = "Registration failed. Please try again.";
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Register | EasyVoyage</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="style.css">
</head>

<body class="bg-home">

<div class="container col-md-4 mt-5 card p-4">
<h3>Create Account</h3>

<?php
if (isset($error)) {
    echo "<div class='alert alert-danger'>$error</div>";
}
?>

<form method="POST">
<input class="form-control mb-2" name="name" placeholder="Full Name" required>
<input class="form-control mb-2" name="email" type="email" placeholder="Email" required>
<input class="form-control mb-2" name="password" type="password" placeholder="Password" required>
<button class="btn btn-primary w-100">Register</button>
</form>

<p class="text-center mt-3">
Already have an account?
<a href="login.php">Login</a>
</p>

<hr>

<a href="index.html" class="btn btn-outline-secondary w-100 mt-2">
← Back to Home
</a>

</div>
</body>
</html>
