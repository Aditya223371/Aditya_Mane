<?php
if (session_status() === PHP_SESSION_NONE) session_start();

// Simple auth check
if (empty($_SESSION['user'])) {
    die('<p style="font-family:sans-serif;color:red">Please <a href="/furniture-website/login.php">login first</a></p>');
}

$user = $_SESSION['user'];
echo '<style>body{font-family:sans-serif;padding:20px;max-width:900px;margin:0 auto}
table{width:100%;border-collapse:collapse;margin:15px 0}
th,td{border:1px solid #ddd;padding:8px 12px;text-align:left;font-size:13px}
th{background:#f5f0e8;color:#2C1810}
.ok{color:green;font-weight:bold}.err{color:red;font-weight:bold}
.box{background:#f9f6f0;border:1px solid #DDD3C0;border-radius:8px;padding:15px;margin:15px 0}
h2{color:#2C1810;border-bottom:2px solid #C4942A;padding-bottom:8px}
</style>';

echo '<h1 style="color:#2C1810">🔍 Order Debug Tool — MANE FURNITURE</h1>';

// Step 1: Check session
echo '<h2>Step 1: Session Info</h2>';
echo '<div class="box">';
echo '<p><b>User ID:</b> ' . ($user['id'] ?? 'NOT SET') . '</p>';
echo '<p><b>Name:</b> ' . ($user['name'] ?? 'NOT SET') . '</p>';
echo '<p><b>Email:</b> ' . ($user['email'] ?? 'NOT SET') . '</p>';
echo '<p><b>Role:</b> ' . ($user['role'] ?? 'NOT SET') . '</p>';
echo '</div>';

// Step 2: Check DB connection
echo '<h2>Step 2: Database Connection</h2>';
$config_path = __DIR__ . '/config/db.php';
if (!file_exists($config_path)) {
    echo '<p class="err">✗ config/db.php NOT FOUND at: ' . $config_path . '</p>';
    exit;
}

try {
    require_once $config_path;
    echo '<p class="ok">✓ Database connected successfully</p>';
} catch (Exception $e) {
    echo '<p class="err">✗ DB Connection Failed: ' . $e->getMessage() . '</p>';
    exit;
}

// Step 3: Check orders table exists
echo '<h2>Step 3: Orders Table</h2>';
try {
    $tables = $pdo->query("SHOW TABLES LIKE 'orders'")->fetchAll();
    if (empty($tables)) {
        echo '<p class="err">✗ orders table does NOT exist! Run config/schema.sql first.</p>';
    } else {
        echo '<p class="ok">✓ orders table exists</p>';
        $count = $pdo->query("SELECT COUNT(*) FROM orders")->fetchColumn();
        echo '<p><b>Total orders in database:</b> ' . $count . '</p>';
    }
} catch (Exception $e) {
    echo '<p class="err">✗ Error checking table: ' . $e->getMessage() . '</p>';
}

// Step 4: Show ALL orders in DB
echo '<h2>Step 4: All Orders in Database</h2>';
try {
    $all = $pdo->query("SELECT id, user_id, ship_name, ship_email, ship_city, total, status, payment_method, created_at FROM orders ORDER BY created_at DESC LIMIT 20")->fetchAll();
    if (empty($all)) {
        echo '<p class="err">✗ NO orders found in database at all!<br>This means <b>save-order.php</b> is not saving orders. Check if save-order.php exists.</p>';
    } else {
        echo '<p class="ok">✓ Found ' . count($all) . ' order(s) in DB</p>';
        echo '<table><tr><th>ID</th><th>User ID</th><th>Name</th><th>Email</th><th>City</th><th>Total</th><th>Status</th><th>Method</th><th>Date</th></tr>';
        foreach ($all as $o) {
            echo '<tr>';
            echo '<td>ORD'.str_pad($o['id'],6,'0',STR_PAD_LEFT).'</td>';
            echo '<td>'.($o['user_id']??'<span style="color:orange">NULL</span>').'</td>';
            echo '<td>'.htmlspecialchars($o['ship_name']).'</td>';
            echo '<td>'.htmlspecialchars($o['ship_email']).'</td>';
            echo '<td>'.htmlspecialchars($o['ship_city']).'</td>';
            echo '<td>₹'.number_format($o['total']).'</td>';
            echo '<td>'.ucfirst($o['status']).'</td>';
            echo '<td>'.ucfirst($o['payment_method']).'</td>';
            echo '<td>'.date('d M Y H:i', strtotime($o['created_at'])).'</td>';
            echo '</tr>';
        }
        echo '</table>';
    }
} catch (Exception $e) {
    echo '<p class="err">✗ Query error: ' . $e->getMessage() . '</p>';
}

// Step 5: Query exactly like my-account.php does
echo '<h2>Step 5: Orders for YOUR Account (same query as My Account)</h2>';
try {
    $stmt = $pdo->prepare("SELECT * FROM orders WHERE user_id = ? OR ship_email = ? ORDER BY created_at DESC");
    $stmt->execute([$user['id'], $user['email']]);
    $my_orders = $stmt->fetchAll();
    if (empty($my_orders)) {
        echo '<p class="err">✗ No orders found for user_id=' . ($user['id']??'NULL') . ' OR email=' . $user['email'] . '</p>';
        echo '<p><b>Fix:</b> Either place a new order while logged in, or the email in the order does not match your login email.</p>';
    } else {
        echo '<p class="ok">✓ Found ' . count($my_orders) . ' order(s) for your account</p>';
        foreach ($my_orders as $o) {
            echo '<div class="box"><b>Order:</b> ORD'.str_pad($o['id'],6,'0',STR_PAD_LEFT).' | <b>Status:</b> '.ucfirst($o['status']).' | <b>Total:</b> ₹'.number_format($o['total']).'</div>';
        }
    }
} catch (Exception $e) {
    echo '<p class="err">✗ Query error: ' . $e->getMessage() . '</p>';
}

// Step 6: Check save-order.php exists
echo '<h2>Step 6: save-order.php Check</h2>';
if (file_exists(__DIR__ . '/save-order.php')) {
    echo '<p class="ok">✓ save-order.php exists</p>';
} else {
    echo '<p class="err">✗ save-order.php is MISSING! This is why orders are not saved.</p>';
    echo '<p>Download and copy save-order.php from the ZIP to: C:\\xampp\\htdocs\\furniture-website\\save-order.php</p>';
}

echo '<br><p style="font-size:12px;color:#888">Delete this file after debugging: <b>debug-orders.php</b></p>';
