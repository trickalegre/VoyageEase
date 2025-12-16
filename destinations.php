<?php
include 'db.php';

if (empty($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

$local = [
["Boracay",12000,["Island Hopping","Parasailing","Beach Walk"]],
["El Nido",15000,["Lagoon Tour","Kayaking","Snorkeling"]],
["Palawan",14000,["Underground River","Island Tour","Wildlife"]],
["Bohol",13000,["Chocolate Hills","Tarsier Visit","River Cruise"]],
["Cebu",12500,["Kawasan Falls","City Tour","Diving"]],
["Siargao",16000,["Surfing","Island Hopping","Coconut Views"]],
["Baguio",9000,["Burnham Park","Mines View","Session Road"]],
["Vigan",10000,["Heritage Walk","Kalesa Ride","Museums"]],
["Davao",11000,["Mt Apo View","Fruit Farms","Eagle Center"]],
["Sagada",10500,["Hanging Coffins","Cave Tour","Sunrise View"]],
];

$intl = [
["Paris",45000,["Eiffel Tower","Louvre","Seine Cruise"]],
["Tokyo",40000,["Shibuya","Mt Fuji","Shopping"]],
["Seoul",38000,["Palaces","Street Food","Shopping"]],
["New York",50000,["Times Square","Central Park","Broadway"]],
["London",48000,["Big Ben","London Eye","Museums"]],
["Rome",42000,["Colosseum","Vatican","City Walk"]],
["Dubai",46000,["Burj Khalifa","Desert Safari","Mall Tour"]],
["Singapore",37000,["Marina Bay","Gardens","Food Tour"]],
["Bangkok",35000,["Temples","Floating Market","Street Food"]],
["Sydney",47000,["Opera House","Bondi Beach","Harbor Cruise"]],
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Destinations | EasyVoyage</title>
<meta name="viewport" content="width=device-width, initial-scale=1">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="style.css">
</head>

<body style="
  background:
    linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)),
    url('home_bg.jpg') no-repeat center center fixed;
  background-size: cover;
  min-height: 100vh;
">


<nav class="navbar navbar-dark bg-dark px-4">
  <div class="d-flex align-items-center">
    <img src="logo.png" class="logo-circle me-2">
    <span class="navbar-brand">EasyVoyage</span>
  </div>

  <div class="d-flex gap-2">
    <a href="mybookings.php" class="btn btn-outline-light">My Bookings</a>
    <a href="logout.php" class="btn btn-danger">Logout</a>
  </div>
</nav>

<div class="container mt-4">

<h3 class="text-white mb-3">🇵🇭 Local Destinations</h3>
<div class="row">

<?php foreach($local as $d):
  $img = strtolower(str_replace(' ','',$d[0]));
?>
<div class="col-md-4">
<div class="card mb-4 destination-card">

<div class="row g-1">
  <div class="col-4"><img src="images/<?= $img ?>1.jpg" class="img-fluid"></div>
  <div class="col-4"><img src="images/<?= $img ?>2.jpg" class="img-fluid"></div>
  <div class="col-4"><img src="images/<?= $img ?>3.jpg" class="img-fluid"></div>
</div>

<div class="card-body">
  <h5><?= $d[0] ?></h5>
  <ul><?php foreach($d[2] as $a) echo "<li>$a</li>"; ?></ul>
  <p class="fw-bold">₱<?= number_format($d[1]) ?></p>
  <a href="booking.php?dest=<?= $d[0] ?>&price=<?= $d[1] ?>" class="btn btn-primary w-100">
    Book Now
  </a>
</div>

</div>
</div>
<?php endforeach; ?>

</div>

<h3 class="text-white mt-4 mb-3">🌍 International Destinations</h3>
<div class="row">

<?php foreach($intl as $d):
  $img = strtolower(str_replace(' ','',$d[0]));
?>
<div class="col-md-4">
<div class="card mb-4 destination-card">

<div class="row g-1">
  <div class="col-4"><img src="images/<?= $img ?>1.jpg" class="img-fluid"></div>
  <div class="col-4"><img src="images/<?= $img ?>2.jpg" class="img-fluid"></div>
  <div class="col-4"><img src="images/<?= $img ?>3.jpg" class="img-fluid"></div>
</div>

<div class="card-body">
  <h5><?= $d[0] ?></h5>
  <ul><?php foreach($d[2] as $a) echo "<li>$a</li>"; ?></ul>
  <p class="fw-bold">₱<?= number_format($d[1]) ?></p>
  <a href="booking.php?dest=<?= $d[0] ?>&price=<?= $d[1] ?>" class="btn btn-success w-100">
    Book Now
  </a>
</div>

</div>
</div>
<?php endforeach; ?>

</div>
</div>

</body>
</html>
