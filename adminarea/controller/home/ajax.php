<?php

// your database connection code here
// ...

// Function to fetch data based on the specified period
function fetchData($startDate = null, $endDate = null) {
    // Perform database query based on $period, $startDate, and $endDate
    // Example: Select relevant data from your database table

    // Replace the following lines with your actual database query
    $data = [
        'labels' => ['Day 1', 'Day 2', 'Day 3', 'Day 4', 'Day 5'],
        'totalAktivasi' => [100, 150, 120, 200, 180],
        'totalBonusTransfer' => [50, 80, 60, 100, 90],
        'totalBonusPending' => [20, 30, 25, 40, 35],
        'totalPenjualan' => [120, 180, 150, 220, 200],
    ];

    echo json_encode($data);
}

// Check if the required parameters are set
if (isset($_POST['startDate'])) {
    $startDate = isset($_POST['startDate']) ? $_POST['startDate'] : null;
    $endDate = isset($_POST['endDate']) ? $_POST['endDate'] : null;

    // Fetch data based on the specified period
    fetchData($startDate, $endDate);
} else {
    // Return an error message if 'period' parameter is not set
    echo json_encode(['error' => 'Invalid request']);
}

?>
