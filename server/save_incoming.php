<?php
require_once 'auth.php';
require_once 'db_connect.php';
requireLogin();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate and sanitize input
    $letter_number = trim($_POST['letter_number']);
    $date = trim($_POST['date']);
    $subject = trim($_POST['subject']);
    $description = trim($_POST['description'] ?? '');

    // Validate date format (dd/mm/yyyy)
    if (!preg_match('/^\d{2}\/\d{2}\/\d{4}$/', $date)) {
        header("Location: ../add_incoming.php?error=date");
        exit;
    }

    // Convert date to MySQL format (yyyy-mm-dd)
    $date_parts = explode('/', $date);
    $mysql_date = $date_parts[2].'-'.$date_parts[1].'-'.$date_parts[0];

    try {
        // Check for duplicate letter number
        $stmt = $conn->prepare("SELECT id FROM incoming_letters WHERE letter_number = ?");
        $stmt->execute([$letter_number]);
        
        if ($stmt->rowCount() > 0) {
            header("Location: ../add_incoming.php?error=duplicate");
            exit;
        }

        // Insert new record
        $stmt = $conn->prepare("INSERT INTO incoming_letters (letter_number, date, subject, description) VALUES (?, ?, ?, ?)");
        $stmt->execute([$letter_number, $mysql_date, $subject, $description]);

        header("Location: ../dashboard.php?success=1");
        exit;

    } catch (PDOException $e) {
        // Log error and redirect
        error_log("Database error: " . $e->getMessage());
        header("Location: ../add_incoming.php?error=db");
        exit;
    }
} else {
    header("Location: ../add_incoming.php");
    exit;
}
?>