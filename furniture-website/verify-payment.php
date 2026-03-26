<?php
/**
 * verify-payment.php
 * Called by checkout.php after Razorpay payment succeeds.
 * Verifies the HMAC signature and saves the order to the database.
 */
session_start();
header('Content-Type: application/json');

define('RAZORPAY_KEY_SECRET', 'XXXXXXXXXXXXXXXXXXXXXXXX'); // ← Replace

require_once 'config/db.php';

$body = json_decode(file_get_contents('php://input'), true);
if (!$body) {
    echo json_encode(['success' => false, 'error' => 'Invalid request']);
    exit;
}

$payment_id = $body['razorpay_payment_id'] ?? '';
$order_id   = $body['razorpay_order_id']   ?? '';
$signature  = $body['razorpay_signature']  ?? '';
$shipping   = $body['shipping']            ?? [];

// ── Signature Verification ──────────────────────────────────────────────────
$expected = hash_hmac('sha256', $order_id . '|' . $payment_id, RAZORPAY_KEY_SECRET);

if (!hash_equals($expected, $signature)) {
    // Signature mismatch — do NOT fulfil the order
    echo json_encode(['success' => false, 'error' => 'Signature verification failed']);
    exit;
}

// ── Save Order to Database ───────────────────────────────────────────────────
try {
    $pdo->beginTransaction();

    // 1. Insert order header
    $stmt = $pdo->prepare("
        INSERT INTO orders
            (user_id, razorpay_payment_id, razorpay_order_id, razorpay_signature,
             ship_name, ship_email, ship_phone, ship_addr1, ship_addr2,
             ship_city, ship_state, ship_pin,
             subtotal, delivery, gst, total, status, created_at)
        VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,'paid', NOW())
    ");

    // Recalculate totals server-side from session cart
    $product_db = require 'config/products.php'; // simple product price lookup
    $subtotal   = 0;
    foreach ($_SESSION['cart'] ?? [] as $pid => $item) {
        if (isset($product_db[$pid])) {
            $subtotal += $product_db[$pid]['price'] * $item['qty'];
        }
    }
    $delivery = $subtotal >= 50000 ? 0 : 2500;
    $gst      = round($subtotal * 0.18);
    $total    = $subtotal + $delivery + $gst;

    $stmt->execute([
        $_SESSION['user']['id'] ?? null,
        $payment_id,
        $order_id,
        $signature,
        $shipping['name']  ?? '',
        $shipping['email'] ?? '',
        $shipping['phone'] ?? '',
        $shipping['addr1'] ?? '',
        $shipping['addr2'] ?? '',
        $shipping['city']  ?? '',
        $shipping['state'] ?? '',
        $shipping['pin']   ?? '',
        $subtotal,
        $delivery,
        $gst,
        $total,
    ]);
    $db_order_id = $pdo->lastInsertId();

    // 2. Insert order items
    $item_stmt = $pdo->prepare("
        INSERT INTO order_items (order_id, product_id, product_name, price, qty, line_total)
        VALUES (?,?,?,?,?,?)
    ");
    foreach ($_SESSION['cart'] ?? [] as $pid => $item) {
        if (isset($product_db[$pid])) {
            $p = $product_db[$pid];
            $item_stmt->execute([
                $db_order_id,
                $pid,
                $p['name'],
                $p['price'],
                $item['qty'],
                $p['price'] * $item['qty'],
            ]);
        }
    }

    $pdo->commit();

    // 3. Clear cart
    $_SESSION['cart'] = [];

    echo json_encode(['success' => true, 'order_id' => 'ORD' . str_pad($db_order_id, 6, '0', STR_PAD_LEFT)]);

} catch (Exception $e) {
    $pdo->rollBack();
    error_log('Order save error: ' . $e->getMessage());
    echo json_encode(['success' => false, 'error' => 'Order could not be saved. Please contact support.']);
}
