<?php
session_start();

// Lama user dianggap online (detik)
$timeout = 300; // 5 menit

// Cari path session dari konfigurasi PHP
$sessionPath = ini_get("session.save_path");

// Beberapa shared hosting menggunakan path user spesifik
if (!$sessionPath || !is_dir($sessionPath)) {
    $sessionPath = "/tmp"; // fallback default
}

// Ambil semua file session
$sessionFiles = glob($sessionPath . "/sess_*");

$totalOnline = 0;
$now = time();

foreach ($sessionFiles as $file) {
    if (is_file($file) && ($now - filemtime($file)) < $timeout) {
        $totalOnline++;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Total User Online</title>
    <script>
        // Refresh halaman tiap 5 detik
        setTimeout(() => location.reload(), 5000);
    </script>
</head>
<body>
    <h2>Total User Online Saat Ini: <?= $totalOnline ?></h2>
</body>
</html>
