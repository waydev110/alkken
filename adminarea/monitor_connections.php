<?php
$dbHost = "localhost";
$dbUser = "netp7474_mlm";
$dbPass = "indonesia2020";
$dbName = "netp7474_mlm";

$conn = new mysqli($dbHost, $dbUser, $dbPass, $dbName);
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

$result = $conn->query("SHOW STATUS WHERE variable_name = 'Threads_connected'");

$totalConnections = 0;
if ($result) {
    $row = $result->fetch_assoc();
    $totalConnections = $row['Value'] ?? 0;
}

$conn->close();

header('Content-Type: application/json');
echo json_encode(['total_connections' => (int)$totalConnections]);
