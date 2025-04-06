<?php
require 'server/db_connect.php';

// Parameter sederhana
$type = isset($_GET['type']) ? $_GET['type'] : 'incoming';
$table = ($type === 'incoming') ? 'incoming_letters' : 'outgoing_letters';

// Query dasar
$query = "SELECT * FROM $table ORDER BY date DESC LIMIT 5";

try {
    $stmt = $conn->query($query);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo "<h2>Test Search Results ($table)</h2>";
    echo "<pre>";
    print_r($results);
    echo "</pre>";
} catch(PDOException $e) {
    echo "<h2>Error</h2>";
    echo "<p>" . $e->getMessage() . "</p>";
    echo "<p>Query: " . $query . "</p>";
}
?>