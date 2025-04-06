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
    
    // Hitung surat bulan ini (dengan prepared statement)
    $currentMonth = date('m');
    $currentYear = date('Y');
    
    $stmt = $conn->prepare("SELECT COUNT(*) as total FROM incoming_letters WHERE MONTH(date) = ? AND YEAR(date) = ?");
    $stmt->execute([$currentMonth, $currentYear]);
    $monthlyIncoming = $stmt->fetch()['total'];
    
    $stmt = $conn->prepare("SELECT COUNT(*) as total FROM outgoing_letters WHERE MONTH(date) = ? AND YEAR(date) = ?");
    $stmt->execute([$currentMonth, $currentYear]);
    $monthlyOutgoing = $stmt->fetch()['total'];

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