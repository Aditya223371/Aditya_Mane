<?php
require_once 'config/db.php';
echo '<h2 style="color:green">✓ Database connected!</h2>';
$tables = $pdo->query("SHOW TABLES")->fetchAll(PDO::FETCH_COLUMN);
echo '<p>Tables found: ' . implode(', ', $tables) . '</p>';