<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = $_POST['username'];
    $password = $_POST['password'];

    $pat = sqlsrv_query(
        $conn,
        "SELECT * FROM Admins WHERE Username = ? AND Password = ?",
        [$username, $password]
    );

    if ($pat && sqlsrv_has_rows($pat)) {
        $admin = sqlsrv_fetch_array($pat, SQLSRV_FETCH_ASSOC);
        $_SESSION['admin'] = $admin['AdminID'];
        header("Location: admin_dashboard.php");
        exit;
    }

    $error = "Invalid admin credentials";
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Admin Login</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body style="
  background:
    linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)),
    url('bg_home_1.jpg') no-repeat center center fixed;
  background-size: cover;
  min-height: 100vh;
">


<div class="container col-md-4 mt-5 card p-4">
<h3>Admin Login</h3>

<?php if(isset($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>

<form method="POST">
<input class="form-control mb-2" name="username" placeholder="Admin Username" required>
<input class="form-control mb-2" type="password" name="password" placeholder="Password" required>
<button class="btn btn-dark w-100">Login</button>
</form>

<a href="login.php" class="btn btn-outline-secondary w-100 mt-2">
← Back to User Login
</a>

</div>
</body>
</html>
