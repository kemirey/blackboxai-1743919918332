<?php
// Simple PHP development server router
if (php_sapi_name() === 'cli-server') {
    $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    if (is_file(__DIR__ . $path)) {
        return false;
    }
}

// For production, redirect all requests to index.php
require __DIR__ . '/index.php';
?>