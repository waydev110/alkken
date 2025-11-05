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
    <meta charset="UTF-8" />
    <title>Monitoring MySQL Connections</title>
    <style>
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #ccc; padding: 5px; text-align: left; }
    </style>
</head>
<body><div>
    <h2>Total User Online Saat Ini: <?= $totalOnline ?></h2>
    Total koneksi MySQL aktif: <span id="totalConn">loading...</span>
</div>

<script>
    async function fetchTotalConnections() {
        const response = await fetch('monitor_connections.php');
        const data = await response.json();
        document.getElementById('totalConn').textContent = data.total_connections;
    }

    fetchTotalConnections();
    setInterval(fetchTotalConnections, 5000);
</script>

</body>
</html>
