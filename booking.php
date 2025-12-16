<?php
include 'db.php';

$dest  = $_GET['dest'];
$price = $_GET['price']; // PHP Peso

/* DESTINATION COORDINATES */
$coords = [
  "Boracay" => [11.9674, 121.9248],
  "El Nido" => [11.2027, 119.4079],
  "Palawan" => [9.8349, 118.7384],
  "Bohol" => [9.8500, 124.1435],
  "Cebu" => [10.3157, 123.8854],
  "Siargao" => [9.8480, 126.0458],
  "Baguio" => [16.4023, 120.5960],
  "Vigan" => [17.5747, 120.3869],
  "Davao" => [7.1907, 125.4553],
  "Sagada" => [17.0833, 120.9000],

  "Paris" => [48.8566, 2.3522],
  "Tokyo" => [35.6762, 139.6503],
  "Seoul" => [37.5665, 126.9780],
  "New York" => [40.7128, -74.0060],
  "London" => [51.5074, -0.1278],
  "Rome" => [41.9028, 12.4964],
  "Dubai" => [25.2048, 55.2708],
  "Singapore" => [1.3521, 103.8198],
  "Bangkok" => [13.7563, 100.5018],
  "Sydney" => [-33.8688, 151.2093],
];

$lat = $coords[$dest][0];
$lng = $coords[$dest][1];
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Booking | EasyVoyage</title>
<meta name="viewport" content="width=device-width, initial-scale=1">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="style.css">

<!-- MAPBOX -->
<link href="https://api.mapbox.com/mapbox-gl-js/v2.15.0/mapbox-gl.css" rel="stylesheet">
<script src="https://api.mapbox.com/mapbox-gl-js/v2.15.0/mapbox-gl.js"></script>
</head>

<body class="bg-booking">

<!-- NAVBAR -->
<nav class="navbar navbar-dark bg-dark px-4">
  <div class="d-flex align-items-center">
    <img src="logo.png" class="logo-circle me-2">
    <span class="navbar-brand">EasyVoyage</span>
  </div>

  <a href="destinations.php" class="btn btn-outline-light">
    ← Back
  </a>
</nav>

<div class="container mt-4">
<div class="row">

<!-- BOOKING FORM -->
<div class="col-md-4">
<div class="card p-4 mb-3">

<h4><?= $dest ?></h4>
<p><strong>Price (PHP):</strong> ₱<?= number_format($price) ?></p>

<label class="mt-2">Convert Price</label>
<select id="currency" class="form-select mb-2">
  <option value="USD">USD</option>
  <option value="EUR">EUR</option>
  <option value="JPY">JPY</option>
  <option value="GBP">GBP</option>
</select>

<div id="converted" class="mb-3 text-success fw-bold">
  Converted price will appear here
</div>

<form method="POST" action="payment.php">
<input type="hidden" name="dest" value="<?= $dest ?>">
<input type="hidden" name="price" value="<?= $price ?>">

<label>Travel Date</label>
<input class="form-control mb-2" type="date" name="date" required>

<label>Travelers</label>
<input class="form-control mb-3" type="number" name="trav" value="1" min="1">

<button class="btn btn-success w-100 mb-2">
  Proceed to Payment
</button>

<a href="destinations.php" class="btn btn-outline-danger w-100">
  Cancel Booking
</a>
</form>

</div>
</div>

<!-- MAP + WEATHER -->
<div class="col-md-8">

<div class="card p-3 mb-3">
<h5>📍 Location</h5>
<div id="map" style="height:300px;"></div>
</div>

<div class="card p-3">
<h5>☀ Weather</h5>
<div id="weather">Loading weather...</div>
</div>

</div>
</div>
</div>

<script>
/* MAPBOX MAP */
mapboxgl.accessToken = 'pk.eyJ1IjoibWFkbGFuZ3R1dGEzMjIiLCJhIjoiY21qN2ZmcXgyMDNtZDNlb2VyN3RqZmlmcyJ9.-4-QaPTc-8HXc3xVgZP3vg';

const map = new mapboxgl.Map({
  container: 'map',
  style: 'mapbox://styles/mapbox/streets-v12',
  center: [<?= $lng ?>, <?= $lat ?>],
  zoom: 12
});

new mapboxgl.Marker()
  .setLngLat([<?= $lng ?>, <?= $lat ?>])
  .setPopup(new mapboxgl.Popup().setText("<?= $dest ?>"))
  .addTo(map);

/* WEATHER */
fetch(`https://api.openweathermap.org/data/2.5/weather?lat=<?= $lat ?>&lon=<?= $lng ?>&units=metric&appid=0820140edc48fe0e433abe1f3dae7bda`)
.then(res => res.json())
.then(data => {
  document.getElementById("weather").innerHTML =
    `<strong>${data.weather[0].description}</strong><br>
     Temperature: ${data.main.temp}°C`;
});

/* CURRENCY */
const pricePHP = <?= $price ?>;
document.getElementById("currency").addEventListener("change", function(){
  const currency = this.value;

  fetch(`https://v6.exchangerate-api.com/v6/181da9f16f4c8db2ad46a178/latest/PHP`)
  .then(res => res.json())
  .then(data => {
    const rate = data.conversion_rates[currency];
    document.getElementById("converted").innerHTML =
      `Price in ${currency}: <strong>${(pricePHP * rate).toFixed(2)}</strong>`;
  });
});
</script>

</body>
</html>
