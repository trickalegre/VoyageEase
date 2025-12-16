<?php
include 'db.php';


if (empty($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit;
}


if (!empty($_GET['delete'])) {
    sqlsrv_query(
        $conn,
        "DELETE FROM Bookings WHERE BookingID = ?",
        [$_GET['delete']]
    );
    header("Location: admin_dashboard.php");
    exit;
}


$sql = "
SELECT B.BookingID, B.Destination, B.TravelDate, B.Travelers, B.TotalPrice,
       U.FullName, U.Email
FROM Bookings B
JOIN Users U ON B.UserID = U.UserID
ORDER BY B.BookingID DESC
";

$pat = sqlsrv_query($conn, $sql);

if ($pat === false) {
    die(print_r(sqlsrv_errors(), true));
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Admin Dashboard</title>


<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>
<body>

<nav class="navbar navbar-dark bg-dark px-4">
  <span class="navbar-brand">EasyVoyage Admin</span>
  <a href="admin_logout.php" class="btn btn-danger">Logout</a>
</nav>

<div class="container mt-4">

<h3>All Bookings</h3>

<table class="table table-bordered table-striped">
<thead class="table-dark">
<tr>
  <th>ID</th>
  <th>User</th>
  <th>Email</th>
  <th>Destination</th>
  <th>Travel Date</th>
  <th>Travelers</th>
  <th>Total Price</th>
  <th>Action</th>
</tr>
</thead>

<tbody>
<?php while ($row = sqlsrv_fetch_array($pat, SQLSRV_FETCH_ASSOC)): ?>
<tr>
  <td><?= $row['BookingID'] ?></td>
  <td><?= $row['FullName'] ?></td>
  <td><?= $row['Email'] ?></td>
  <td><?= $row['Destination'] ?></td>
  <td><?= $row['TravelDate']->format('Y-m-d') ?></td>
  <td><?= $row['Travelers'] ?></td>
  <td>₱<?= number_format($row['TotalPrice'], 2) ?></td>
  <td>
    <a href="admin_dashboard.php?delete=<?= $row['BookingID'] ?>"
       class="btn btn-sm btn-danger"
       onclick="return confirm('Cancel this booking?')">
       Cancel
    </a>
  </td>
</tr>
<?php endwhile; ?>
</tbody>

</table>

</div>
</body>
</html>
