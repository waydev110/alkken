<?php
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit;
}
    include('../../../helper/all_member.php');    
    include("../../../model/classSpinReward.php");
    $csr = new classSpinReward();
    $spinRewards = $csr->index();
    $rewardItems = [];
    while ($row = $spinRewards->fetch_object()) {
        $rewardItems[] = [
            "label" => $row->reward,
            "image" => "../images/spin_reward/" . $row->gambar
        ];
    }
    echo json_encode([
        "items" => $rewardItems
    ]);
