<?php
/**
 * config/db.php
 * PDO database connection — include this in any page that needs DB access.
 * Update credentials before deploying.
 */

define('DB_HOST', 'localhost');
define('DB_NAME', 'maison_db');
define('DB_USER', 'root');
define('DB_PASS', '');         // ← Set your MySQL password here
define('DB_CHARSET', 'utf8mb4');

$dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET;

$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
} catch (PDOException $e) {
    // In production, log to file instead of displaying
    error_log('DB Connection Error: ' . $e->getMessage());
    die('<h2 style="font-family:sans-serif;color:#C0392B;padding:2rem">
        Database connection failed. Please check your configuration in config/db.php
    </h2>');
}
