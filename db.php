<?php
session_start();

$serverName = "PATRICK-A\\SQLEXPRESS";
$connectionOptions = [
    "Database" => "DLSU2",
    "TrustServerCertificate" => true
];

$conn = sqlsrv_connect($serverName, $connectionOptions);

if (!$conn) {
    die("Database connection failed");
}
?>
