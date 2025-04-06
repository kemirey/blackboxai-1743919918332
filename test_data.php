<?php
require 'server/db_connect.php';

header('Content-Type: text/plain');

try {
    // Test koneksi database
    $test = $conn->query("SELECT 1");
    echo "Koneksi database berhasil\n\n";
    
    // Cek data surat masuk
    $stmt = $conn->query("SELECT COUNT(*) as count FROM incoming_letters");
    $result = $stmt->fetch();
    echo "Total Surat Masuk: " . $result['count'] . "\n";
    
    // Cek data surat keluar 
    $stmt = $conn->query("SELECT COUNT(*) as count FROM outgoing_letters");
    $result = $stmt->fetch();
    echo "Total Surat Keluar: " . $result['count'] . "\n";
    
    // Tampilkan 5 data terbaru
    echo "\n5 Surat Masuk Terbaru:\n";
    $stmt = $conn->query("SELECT * FROM incoming_letters ORDER BY id DESC LIMIT 5");
    print_r($stmt->fetchAll(PDO::FETCH_ASSOC));
    
    echo "\n5 Surat Keluar Terbaru:\n";
    $stmt = $conn->query("SELECT * FROM outgoing_letters ORDER BY id DESC LIMIT 5");
    print_r($stmt->fetchAll(PDO::FETCH_ASSOC));

} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>