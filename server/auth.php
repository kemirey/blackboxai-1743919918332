<?php
session_start();
require_once 'db_connect.php';

// Default password: admin123 (hashed)
$hashed_password = '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi';

function isLoggedIn() {
    return isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true;
}

function login($password) {
    global $hashed_password;
    if (password_verify($password, $hashed_password)) {
        $_SESSION['loggedin'] = true;
        return true;
    }
    return false;
}

function logout() {
    session_destroy();
    header("Location: ../index.php");
    exit;
}

function requireLogin() {
    if (!isLoggedIn()) {
        header("Location: ../index.php");
        exit;
    }
}
?>