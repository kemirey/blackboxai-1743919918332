<?php
require_once 'auth.php';
require_once 'db_connect.php';
requireLogin();

header('Content-Type: application/json');

try {
    // Hitung total surat masuk
    $incoming = $conn->query("SELECT COUNT(*) as total FROM incoming_letters")->fetch()['total'];
    
    // Hitung total surat keluar
    $outgoing = $conn->query("SELECT COUNT(*) as total FROM outgoing_letters")->fetch()['total'];
    
    // Hitung surat bulan ini
    $currentMonth = date('m');
    $monthlyIncoming = $conn->query("SELECT COUNT(*) as total FROM incoming_letters WHERE MONTH(date) = $currentMonth")->fetch()['total'];
    $monthlyOutgoing = $conn->query("SELECT COUNT(*) as total FROM outgoing_letters WHERE MONTH(date) = $currentMonth")->fetch()['total'];

    echo json_encode([
        'success' => true,
        'data' => [
            'incoming' => $incoming,
            'outgoing' => $outgoing,
            'monthly_incoming' => $monthlyIncoming,
            'monthly_outgoing' => $monthlyOutgoing
        ]
    ]);
} catch (PDOException $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Database error'
    ]);
}
?>