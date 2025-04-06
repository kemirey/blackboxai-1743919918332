<?php
require_once 'auth.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $password = $_POST['password'] ?? '';
    
    if (login($password)) {
        header("Location: ../dashboard.php");
        exit;
    } else {
        header("Location: ../index.php?error=1");
        exit;
    }
} else {
    header("Location: ../index.php");
    exit;
}
?>