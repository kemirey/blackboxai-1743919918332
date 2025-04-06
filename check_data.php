<?php
require 'server/db_connect.php';

echo "=== TEST DATABASE ===\n";

// Test koneksi
try {
    $conn->query("SELECT 1");
    echo "✓ Koneksi database berhasil\n\n";
} catch(PDOException $e) {
    die("✗ Gagal terkoneksi: " . $e->getMessage());
}

// Cek tabel dan data
$tables = ['incoming_letters', 'outgoing_letters'];
foreach ($tables as $table) {
    echo "\n=== $table ===\n";
    try {
        $count = $conn->query("SELECT COUNT(*) FROM $table")->fetchColumn();
        echo "Jumlah data: $count\n";
        
        if ($count > 0) {
            $data = $conn->query("SELECT * FROM $table ORDER BY id DESC LIMIT 3")->fetchAll(PDO::FETCH_ASSOC);
            print_r($data);
        }
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage() . "\n";
    }
}
?>