<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $pass  = $_POST['password'];

    $pat = sqlsrv_query(
        $conn,
        "SELECT * FROM Users WHERE Email = ?",
        [$email]
    );

    if ($pat && sqlsrv_has_rows($pat)) {
        $u = sqlsrv_fetch_array($pat, SQLSRV_FETCH_ASSOC);

        if (password_verify($pass, $u['PasswordHash'])) {
            $_SESSION['user'] = $u;
            header("Location: destinations.php");
            exit;
        }
    }

    $error = "Invalid email or password";
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Login</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="style.css">
</head>

<body class="bg-home">

<div class="container col-md-4 mt-5 card p-4">
<h3>User Login</h3>

<?php
if (!empty($error)) {
    echo "<div class='alert alert-danger'>$error</div>";
}
?>

<form method="POST">
<input class="form-control mb-2" name="email" placeholder="Email" required>
<input class="form-control mb-2" name="password" type="password" placeholder="Password" required>
<button class="btn btn-primary w-100">Login</button>
</form>

<hr>

<a href="register.php" class="btn btn-outline-primary w-100 mt-2">
Create Account
</a>

<a href="admin_login.php" class="btn btn-dark w-100 mt-2">
Admin Login
</a>

<a href="index.html" class="btn btn-outline-secondary w-100 mt-2">
← Back to Home
</a>

</div>
</body>
</html>
