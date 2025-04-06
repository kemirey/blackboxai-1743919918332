<?php
require_once 'auth.php';
require_once 'db_connect.php';
requireLogin();

$allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
$maxSize = 2 * 1024 * 1024; // 2MB
$uploadDir = __DIR__ . '/../../uploads/images/';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['image'])) {
    $file = $_FILES['image'];
    
    // Validasi file
    if ($file['error'] !== UPLOAD_ERR_OK) {
        die(json_encode(['success' => false, 'message' => 'Error uploading file']));
    }

    if (!in_array($file['type'], $allowedTypes)) {
        die(json_encode(['success' => false, 'message' => 'File type not allowed']));
    }

    if ($file['size'] > $maxSize) {
        die(json_encode(['success' => false, 'message' => 'File too large (max 2MB)']));
    }

    // Generate unique filename
    $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
    $filename = uniqid() . '.' . $ext;
    $targetPath = $uploadDir . $filename;

    if (move_uploaded_file($file['tmp_name'], $targetPath)) {
        echo json_encode([
            'success' => true,
            'path' => 'uploads/images/' . $filename
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Failed to save file'
        ]);
    }
} else {
    header("Location: ../dashboard.php");
    exit;
}
?>