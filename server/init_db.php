<?php
require_once 'db_connect.php';

try {
    // Create incoming letters table
    $conn->exec("
        CREATE TABLE IF NOT EXISTS incoming_letters (
            id INT AUTO_INCREMENT PRIMARY KEY,
            letter_number VARCHAR(50) UNIQUE NOT NULL,
            date DATE NOT NULL,
            subject TEXT NOT NULL,
            description TEXT,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )
    ");

    // Create outgoing letters table
    $conn->exec("
        CREATE TABLE IF NOT EXISTS outgoing_letters (
            id INT AUTO_INCREMENT PRIMARY KEY,
            letter_number VARCHAR(50) UNIQUE NOT NULL,
            date DATE NOT NULL,
            recipient TEXT NOT NULL,
            description TEXT,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )
    ");

    // Set default password (admin123)
    $hashed_password = password_hash('admin123', PASSWORD_DEFAULT);
    $conn->exec("
        CREATE TABLE IF NOT EXISTS users (
            id INT AUTO_INCREMENT PRIMARY KEY,
            username VARCHAR(50) NOT NULL DEFAULT 'admin',
            password VARCHAR(255) NOT NULL DEFAULT '$hashed_password'
        )
    ");

    // Insert default admin user if not exists
    $stmt = $conn->prepare("SELECT id FROM users WHERE username = 'admin'");
    $stmt->execute();
    
    if ($stmt->rowCount() === 0) {
        $conn->exec("INSERT INTO users (username, password) VALUES ('admin', '$hashed_password')");
    }

    echo "Database initialized successfully!";
    
} catch (PDOException $e) {
    die("Database initialization failed: " . $e->getMessage());
}
?>