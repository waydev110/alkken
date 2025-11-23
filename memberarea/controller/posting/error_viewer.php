<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Member Registration Error Viewer</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #0033a0 0%, #0055d4 100%);
            color: #e0e0e0;
            min-height: 100vh;
            padding: 20px;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
        }
        .header {
            background: linear-gradient(135deg, #d4af37 0%, #f4e5a1 100%);
            color: #1a1a1a;
            padding: 24px;
            border-radius: 12px;
            margin-bottom: 24px;
            box-shadow: 0 4px 16px rgba(212, 175, 55, 0.3);
        }
        .header h1 {
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 8px;
        }
        .header p {
            font-size: 14px;
            opacity: 0.8;
        }
        .stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 16px;
            margin-bottom: 24px;
        }
        .stat-card {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(212, 175, 55, 0.3);
            border-radius: 8px;
            padding: 16px;
        }
        .stat-label {
            color: #888;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 8px;
        }
        .stat-value {
            color: #d4af37;
            font-size: 32px;
            font-weight: 700;
        }
        .controls {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(212, 175, 55, 0.3);
            border-radius: 8px;
            padding: 16px;
            margin-bottom: 24px;
        }
        .btn {
            background: linear-gradient(135deg, #d4af37 0%, #f4e5a1 100%);
            color: #1a1a1a;
            border: none;
            padding: 10px 20px;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 600;
            font-size: 14px;
            transition: transform 0.2s;
        }
        .btn:hover {
            transform: translateY(-2px);
        }
        .error-list {
            display: grid;
            gap: 16px;
        }
        .error-item {
            background: rgba(255, 255, 255, 0.05);
            border-left: 4px solid #d4af37;
            border-radius: 8px;
            padding: 20px;
            position: relative;
        }
        .error-item.critical {
            border-left-color: #ff4444;
        }
        .error-item.warning {
            border-left-color: #ffaa00;
        }
        .error-header {
            display: flex;
            justify-content: space-between;
            align-items: start;
            margin-bottom: 12px;
        }
        .error-operation {
            color: #d4af37;
            font-size: 18px;
            font-weight: 600;
        }
        .error-timestamp {
            color: #888;
            font-size: 12px;
        }
        .error-details {
            display: grid;
            gap: 12px;
        }
        .error-row {
            display: grid;
            grid-template-columns: 120px 1fr;
            gap: 12px;
        }
        .error-label {
            color: #888;
            font-size: 13px;
            font-weight: 600;
        }
        .error-value {
            color: #e0e0e0;
            font-size: 13px;
            font-family: 'Courier New', monospace;
        }
        .error-message {
            background: rgba(255, 68, 68, 0.1);
            border: 1px solid rgba(255, 68, 68, 0.3);
            border-radius: 6px;
            padding: 12px;
            color: #ff8888;
            font-family: 'Courier New', monospace;
            font-size: 13px;
        }
        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #888;
        }
        .empty-state svg {
            width: 64px;
            height: 64px;
            fill: #444;
            margin-bottom: 16px;
        }
        .filter-group {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
        }
        .filter-input {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(212, 175, 55, 0.3);
            color: #e0e0e0;
            padding: 8px 12px;
            border-radius: 6px;
            font-size: 14px;
        }
        .filter-input:focus {
            outline: none;
            border-color: #d4af37;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>📊 Member Registration Error Tracker</h1>
            <p>Real-time monitoring dan debugging untuk proses pendaftaran member</p>
        </div>

        <div class="stats">
            <div class="stat-card">
                <div class="stat-label">Total Errors</div>
                <div class="stat-value" id="totalErrors">0</div>
            </div>
            <div class="stat-card">
                <div class="stat-label">Last 24 Hours</div>
                <div class="stat-value" id="recentErrors">0</div>
            </div>
            <div class="stat-card">
                <div class="stat-label">Most Common</div>
                <div class="stat-value" id="commonOperation" style="font-size: 16px;">-</div>
            </div>
        </div>

        <div class="controls">
            <div class="filter-group">
                <button class="btn" onclick="loadErrors()">🔄 Refresh</button>
                <button class="btn" onclick="clearLog()">🗑️ Clear Log</button>
                <input type="text" class="filter-input" id="searchInput" placeholder="Search by Member ID, Operation..." onkeyup="filterErrors()">
                <select class="filter-input" id="dateFilter" onchange="filterErrors()">
                    <option value="">All Time</option>
                    <option value="today">Today</option>
                    <option value="yesterday">Yesterday</option>
                    <option value="week">Last 7 Days</option>
                </select>
            </div>
        </div>

        <div class="error-list" id="errorList">
            <div class="empty-state">
                <svg viewBox="0 0 24 24">
                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                </svg>
                <h3>No Errors Found</h3>
                <p>Sistem berjalan normal atau belum ada log error.</p>
            </div>
        </div>
    </div>

    <script>
        let allErrors = [];

        function loadErrors() {
            fetch('?action=load')
                .then(response => response.json())
                .then(data => {
                    allErrors = data.errors;
                    updateStats(data.stats);
                    displayErrors(allErrors);
                })
                .catch(error => {
                    console.error('Error loading logs:', error);
                });
        }

        function updateStats(stats) {
            document.getElementById('totalErrors').textContent = stats.total;
            document.getElementById('recentErrors').textContent = stats.recent;
            document.getElementById('commonOperation').textContent = stats.commonOperation || '-';
        }

        function displayErrors(errors) {
            const errorList = document.getElementById('errorList');
            
            if (errors.length === 0) {
                errorList.innerHTML = `
                    <div class="empty-state">
                        <svg viewBox="0 0 24 24">
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                        </svg>
                        <h3>No Errors Found</h3>
                        <p>Sistem berjalan normal atau belum ada log error.</p>
                    </div>
                `;
                return;
            }

            errorList.innerHTML = errors.map(error => `
                <div class="error-item ${error.severity}">
                    <div class="error-header">
                        <div class="error-operation">⚠️ ${error.operation}</div>
                        <div class="error-timestamp">${error.timestamp}</div>
                    </div>
                    <div class="error-details">
                        <div class="error-row">
                            <div class="error-label">Member ID:</div>
                            <div class="error-value">${error.memberId}</div>
                        </div>
                        <div class="error-row">
                            <div class="error-label">Sponsor:</div>
                            <div class="error-value">${error.sponsor}</div>
                        </div>
                        <div class="error-message">
                            ${error.error}
                        </div>
                    </div>
                </div>
            `).join('');
        }

        function filterErrors() {
            const searchTerm = document.getElementById('searchInput').value.toLowerCase();
            const dateFilter = document.getElementById('dateFilter').value;
            
            let filtered = allErrors.filter(error => {
                const matchesSearch = !searchTerm || 
                    error.operation.toLowerCase().includes(searchTerm) ||
                    error.memberId.toLowerCase().includes(searchTerm) ||
                    error.sponsor.toLowerCase().includes(searchTerm);
                
                // Add date filtering logic here if needed
                
                return matchesSearch;
            });
            
            displayErrors(filtered);
        }

        function clearLog() {
            if (confirm('Are you sure you want to clear all error logs?')) {
                fetch('?action=clear', {method: 'POST'})
                    .then(() => loadErrors())
                    .catch(error => console.error('Error clearing log:', error));
            }
        }

        // Auto-refresh every 30 seconds
        setInterval(loadErrors, 30000);

        // Initial load
        loadErrors();
    </script>
</body>
</html>

<?php
// Backend logic for log viewer
if (isset($_GET['action'])) {
    header('Content-Type: application/json');
    
    $logFile = __DIR__ . '/../../log/member_registration_errors.log';
    
    switch ($_GET['action']) {
        case 'load':
            $errors = [];
            $stats = [
                'total' => 0,
                'recent' => 0,
                'commonOperation' => ''
            ];
            
            if (file_exists($logFile)) {
                $content = file_get_contents($logFile);
                $entries = preg_split('/\n(?=\[)/', trim($content));
                
                $operationCount = [];
                $now = time();
                $oneDayAgo = $now - 86400;
                
                foreach ($entries as $entry) {
                    if (empty(trim($entry))) continue;
                    
                    preg_match('/\[(.*?)\]/', $entry, $timestamp);
                    preg_match('/Operation: (.*?)\n/', $entry, $operation);
                    preg_match('/Member ID: (.*?)\n/', $entry, $memberId);
                    preg_match('/Sponsor: (.*?)\n/', $entry, $sponsor);
                    preg_match('/Error: (.*?)\n/', $entry, $error);
                    
                    $errorTime = isset($timestamp[1]) ? strtotime($timestamp[1]) : 0;
                    $operationName = isset($operation[1]) ? trim($operation[1]) : 'Unknown';
                    
                    // Count operations
                    if (!isset($operationCount[$operationName])) {
                        $operationCount[$operationName] = 0;
                    }
                    $operationCount[$operationName]++;
                    
                    // Count recent errors
                    if ($errorTime >= $oneDayAgo) {
                        $stats['recent']++;
                    }
                    
                    $errors[] = [
                        'timestamp' => isset($timestamp[1]) ? $timestamp[1] : '',
                        'operation' => $operationName,
                        'memberId' => isset($memberId[1]) ? trim($memberId[1]) : 'N/A',
                        'sponsor' => isset($sponsor[1]) ? trim($sponsor[1]) : 'N/A',
                        'error' => isset($error[1]) ? trim($error[1]) : 'Unknown error',
                        'severity' => 'critical'
                    ];
                }
                
                // Find most common operation
                if (!empty($operationCount)) {
                    arsort($operationCount);
                    $stats['commonOperation'] = key($operationCount);
                }
                
                $stats['total'] = count($errors);
                
                // Reverse to show newest first
                $errors = array_reverse($errors);
            }
            
            echo json_encode(['errors' => $errors, 'stats' => $stats]);
            break;
            
        case 'clear':
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                if (file_exists($logFile)) {
                    file_put_contents($logFile, '');
                }
                echo json_encode(['success' => true]);
            }
            break;
    }
    exit;
}
?>
