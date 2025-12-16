<?php
include 'db.php';


if (empty($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

$pat = sqlsrv_query(
    $conn,
    "SELECT * FROM Bookings WHERE UserID = ? ORDER BY CreatedAt DESC",
    [$_SESSION['user']['UserID']]
);

if ($pat === false) {
    die(print_r(sqlsrv_errors(), true));
}
?>
<!DOCTYPE html>
<html>
<head>
<title>My Bookings | EasyVoyage</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="style.css">
</head>

<body class="bg-destinations">

<nav class="navbar navbar-dark bg-dark px-4">
  <div class="d-flex align-items-center">
    <img src="logo.png" class="logo-circle me-2">
    <span class="navbar-brand">EasyVoyage</span>
  </div>
  <a href="destinations.php" class="btn btn-outline-light">Back</a>
</nav>

<div class="container mt-4">
<h3 class="text-white mb-3">📄 My Bookings</h3>

<div class="card">
<table class="table table-striped mb-0">
<thead class="table-dark">
<tr>
  <th>Destination</th>
  <th>Date</th>
  <th>Travelers</th>
  <th>Total</th>
  <th>Payment</th>
  <th>Status</th>
</tr>
</thead>
<tbody>

<?php while ($b = sqlsrv_fetch_array($pat, SQLSRV_FETCH_ASSOC)): ?>
<tr>
  <td><?= $b['Destination'] ?></td>
  <td><?= $b['TravelDate']->format('Y-m-d') ?></td>
  <td><?= $b['Travelers'] ?></td>
  <td>₱<?= number_format($b['TotalPrice'], 2) ?></td>
  <td><?= $b['PaymentMethod'] ?></td>
  <td>
    <span class="badge bg-success">
      <?= $b['PaymentStatus'] ?>
    </span>
  </td>
</tr>
<?php endwhile; ?>

</tbody>
</table>
</div>

</div>
</body>
</html>
