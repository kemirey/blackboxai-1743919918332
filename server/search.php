<?php
require_once 'auth.php';
require_once 'db_connect.php';
requireLogin();

header('Content-Type: application/json');

// Log untuk debugging
file_put_contents('debug.log', "\n\n[".date('Y-m-d H:i:s')."] New Request\n", FILE_APPEND);
file_put_contents('debug.log', "GET Parameters: ".print_r($_GET, true)."\n", FILE_APPEND);

try {
    // Test koneksi database
    file_put_contents('debug.log', "Testing database connection...\n", FILE_APPEND);
    $conn->query("SELECT 1");
    file_put_contents('debug.log', "✓ Database connection OK\n", FILE_APPEND);
    $type = $_GET['type'] ?? 'incoming';
    $search = $_GET['search'] ?? '';
    $page = $_GET['page'] ?? 1;
    $perPage = 10;
    $offset = ($page - 1) * $perPage;

    $table = $type === 'incoming' ? 'incoming_letters' : 'outgoing_letters';
    $searchTerm = "%$search%";

    // Get total count
    $countStmt = $conn->prepare("
        SELECT COUNT(*) as total 
        FROM $table 
        WHERE letter_number LIKE ? OR 
              subject LIKE ? OR 
              recipient LIKE ? OR 
              description LIKE ?
    ");
    $params = [$searchTerm];
    if ($type === 'incoming') {
        $countStmt->execute([$searchTerm, $searchTerm, $searchTerm, $searchTerm]);
    } else {
        $countStmt->execute([$searchTerm, $searchTerm, $searchTerm, $searchTerm]);
    }
    $total = $countStmt->fetch()['total'];

    // Get paginated results
    $query = "
        SELECT 
            id,
            letter_number,
            DATE_FORMAT(date, '%d/%m/%Y') as date,
            " . ($type === 'incoming' ? 'subject' : 'recipient') . ",
            description
        FROM $table
        WHERE letter_number LIKE ? OR 
              " . ($type === 'incoming' ? 'subject' : 'recipient') . " LIKE ? OR 
              description LIKE ?
        ORDER BY date DESC
        LIMIT ? OFFSET ?
    ";

    $stmt = $conn->prepare($query);
    $stmt->execute([$searchTerm, $searchTerm, $searchTerm, $perPage, $offset]);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode([
        'success' => true,
        'data' => $results,
        'pagination' => [
            'total' => $total,
            'per_page' => $perPage,
            'current_page' => $page,
            'last_page' => ceil($total / $perPage)
        ]
    ]);

} catch (PDOException $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Database error: ' . $e->getMessage()
    ]);
}
?>