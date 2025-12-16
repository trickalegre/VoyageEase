<?php
include 'db.php';
if(!isset($_SESSION['user'])) header("Location: login.php");

$dest = $_POST['dest'];
$date = $_POST['date'];
$trav = $_POST['trav'];
$price = $_POST['price'];
$total = $trav * $price;

/* WHEN PAY BUTTON IS CLICKED */
if(isset($_POST['pay'])){
    $method = $_POST['payment_method'];
    $status = "Paid"; // CONFIRMED OPTION A

    sqlsrv_query($conn,
    "INSERT INTO Bookings
     (UserID, Destination, TravelDate, Travelers, TotalPrice, PaymentMethod, PaymentStatus)
     VALUES (?,?,?,?,?,?,?)",
    [
      $_SESSION['user']['UserID'],
      $dest,
      $date,
      $trav,
      $total,
      $method,
      $status
    ]);

    header("Location: mybookings.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Payment | EasyVoyage</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="style.css">
</head>

<body class="bg-payment">

<div class="container mt-5 col-md-5">
<div class="card p-4">

<h3 class="mb-3">Fake Payment</h3>

<p><strong>Destination:</strong> <?= $dest ?></p>
<p><strong>Total Amount:</strong> ₱<?= number_format($total) ?></p>

<form method="POST">

<input type="hidden" name="dest" value="<?= $dest ?>">
<input type="hidden" name="date" value="<?= $date ?>">
<input type="hidden" name="trav" value="<?= $trav ?>">
<input type="hidden" name="price" value="<?= $price ?>">

<label class="fw-bold mb-2">Select Payment Method</label>

<div class="form-check mb-2">
  <input class="form-check-input" type="radio" name="payment_method" value="GCash" required>
  <label class="form-check-label">GCash</label>
</div>

<div class="form-check mb-3">
  <input class="form-check-input" type="radio" name="payment_method" value="Maya">
  <label class="form-check-label">Maya</label>
</div>

<button class="btn btn-success w-100 mt-3" name="pay">
  Pay Now
</button>

</form>
</div>
</div>

</body>
</html>
