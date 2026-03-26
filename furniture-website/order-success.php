<?php
if (session_status() === PHP_SESSION_NONE) session_start();
define('SITE_NAME', 'MANE FURNITURE');
define('SITE_TAGLINE', 'Premium Furniture');
$page_title = 'Order Confirmed';

$order_id = htmlspecialchars($_GET['order_id'] ?? ('ORD' . date('YmdHis')));
$method   = htmlspecialchars($_GET['method']   ?? 'razorpay');
$city     = htmlspecialchars($_GET['city']     ?? 'your city');
$state    = htmlspecialchars($_GET['state']    ?? '');

// Calculate delivery dates
$order_date     = date('d M Y');
$dispatch_date  = date('d M Y', strtotime('+2 days'));
$transit_date   = date('d M Y', strtotime('+5 days'));
$delivery_date  = date('d M Y', strtotime('+8 days'));
$delivery_range = date('d M', strtotime('+7 days')) . ' – ' . date('d M Y', strtotime('+10 days'));

// Try load order from DB
$order = null;
$order_items = [];
if (!empty($_GET['order_id']) && file_exists(__DIR__ . '/config/db.php')) {
    try {
        require_once __DIR__ . '/config/db.php';
        $raw_id = preg_replace('/[^0-9]/', '', $_GET['order_id']);
        if ($raw_id) {
            $stmt = $pdo->prepare("SELECT * FROM orders WHERE id = ? LIMIT 1");
            $stmt->execute([$raw_id]);
            $order = $stmt->fetch();
            if ($order) {
                $stmt2 = $pdo->prepare("SELECT * FROM order_items WHERE order_id = ?");
                $stmt2->execute([$raw_id]);
                $order_items = $stmt2->fetchAll();
                $city  = $order['ship_city'];
                $state = $order['ship_state'];
            }
        }
    } catch (Exception $e) { /* ignore */ }
}

include 'includes/header.php';
?>

<div class="success-page">
    <div class="container">
        <div class="success-wrap">

            <!-- HEADER -->
            <div class="success-header">
                <div class="success-check">✓</div>
                <h1>Order Confirmed!</h1>
                <p>Thank you for choosing Mane Furniture. Your order has been placed successfully.</p>
                <div class="success-order-id"><?= $order_id ?></div>
            </div>

            <!-- DELIVERY TRACKING TIMELINE -->
            <div class="tracking-card">
                <div class="tracking-header">
                    <h3>📦 Delivery Tracking</h3>
                    <span class="delivery-to">Delivering to: <strong><?= $city ?><?= $state ? ', '.$state : '' ?></strong></span>
                </div>
                <div class="tracking-body">
                    <div class="tracking-timeline">
                        <div class="track-step done">
                            <div class="track-dot done"></div>
                            <div class="track-line"></div>
                            <div class="track-info">
                                <strong>Order Placed</strong>
                                <span><?= $order_date ?></span>
                                <p>Your order has been received and confirmed</p>
                            </div>
                        </div>
                        <div class="track-step active">
                            <div class="track-dot active"></div>
                            <div class="track-line"></div>
                            <div class="track-info">
                                <strong>Processing & Packing</strong>
                                <span>Expected: <?= $dispatch_date ?></span>
                                <p>Our team is carefully packing your furniture</p>
                            </div>
                        </div>
                        <div class="track-step">
                            <div class="track-dot"></div>
                            <div class="track-line"></div>
                            <div class="track-info">
                                <strong>Dispatched</strong>
                                <span>Expected: <?= $transit_date ?></span>
                                <p>Your order will be picked up by our delivery partner</p>
                            </div>
                        </div>
                        <div class="track-step">
                            <div class="track-dot"></div>
                            <div class="track-line"></div>
                            <div class="track-info">
                                <strong>Out for Delivery</strong>
                                <span>Expected: <?= $delivery_date ?></span>
                                <p>Our team will call before arriving at your door</p>
                            </div>
                        </div>
                        <div class="track-step">
                            <div class="track-dot last"></div>
                            <div class="track-line last"></div>
                            <div class="track-info">
                                <strong>Delivered</strong>
                                <span>Expected by: <?= $delivery_range ?></span>
                                <p>White-glove delivery with assembly included</p>
                            </div>
                        </div>
                    </div>
                    <div class="delivery-summary-box">
                        <div class="dsb-item">
                            <span class="dsb-icon">🚚</span>
                            <div>
                                <strong>White-Glove Delivery</strong>
                                <p>Free assembly & packaging removal</p>
                            </div>
                        </div>
                        <div class="dsb-item">
                            <span class="dsb-icon">📅</span>
                            <div>
                                <strong>Estimated Arrival</strong>
                                <p><?= $delivery_range ?></p>
                            </div>
                        </div>
                        <div class="dsb-item">
                            <span class="dsb-icon">📍</span>
                            <div>
                                <strong>Delivery Location</strong>
                                <p><?= $city ?><?= $state ? ', '.$state : '' ?></p>
                            </div>
                        </div>
                        <div class="dsb-item">
                            <span class="dsb-icon">📞</span>
                            <div>
                                <strong>Our team will call you</strong>
                                <p>1 day before delivery to confirm timing</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ORDER DETAILS GRID -->
            <div class="success-details-grid">
                <div class="sd-card">
                    <div class="sd-icon">📧</div>
                    <div>
                        <strong>Confirmation Email</strong>
                        <p>Sent to your registered email</p>
                    </div>
                </div>
                <div class="sd-card">
                    <div class="sd-icon">💳</div>
                    <div>
                        <strong>Payment Method</strong>
                        <p><?= $method === 'cod' ? 'Cash on Delivery' : ($method === 'emi' ? 'No-Cost EMI' : 'Paid via Razorpay') ?></p>
                    </div>
                </div>
                <div class="sd-card">
                    <div class="sd-icon">🛡️</div>
                    <div>
                        <strong>10-Year Warranty</strong>
                        <p>On all Mane Furniture pieces</p>
                    </div>
                </div>
                <div class="sd-card">
                    <div class="sd-icon">📞</div>
                    <div>
                        <strong>Need Help?</strong>
                        <p>+91 98765 43210 · Mon–Sat 10am–7pm</p>
                    </div>
                </div>
            </div>

            <?php if (!empty($order_items)): ?>
            <!-- ORDER ITEMS -->
            <div class="success-items-card">
                <h3>Items in This Order</h3>
                <?php foreach ($order_items as $oi): ?>
                <div class="si-row">
                    <div class="si-info">
                        <strong><?= htmlspecialchars($oi['product_name']) ?></strong>
                        <span>Qty: <?= $oi['qty'] ?></span>
                    </div>
                    <div class="si-price">₹<?= number_format($oi['line_total']) ?></div>
                </div>
                <?php endforeach; ?>
                <?php if ($order): ?>
                <div class="si-totals">
                    <?php if ($order['discount'] > 0): ?>
                    <div class="si-total-line"><span>Discount</span><span style="color:#2E7D32">−₹<?= number_format($order['discount']) ?></span></div>
                    <?php endif; ?>
                    <div class="si-total-line"><span>Delivery</span><span><?= $order['delivery']==0?'FREE':'₹'.number_format($order['delivery']) ?></span></div>
                    <div class="si-total-line"><span>GST (18%)</span><span>₹<?= number_format($order['gst']) ?></span></div>
                    <div class="si-total-line si-grand-total"><span>Total Paid</span><span>₹<?= number_format($order['total']) ?></span></div>
                </div>
                <?php endif; ?>
            </div>
            <?php endif; ?>

            <!-- ACTION BUTTONS -->
            <div class="success-actions">
                <a href="/furniture-website/catalog.php" class="btn btn-primary">Continue Shopping</a>
                <a href="/furniture-website/my-account.php" class="btn-orders-link">View My Orders →</a>
            </div>

        </div>
    </div>
</div>

<style>
.success-page{padding:3rem 0 5rem;min-height:60vh}
.success-wrap{max-width:780px;margin:0 auto}
.success-header{text-align:center;margin-bottom:2.5rem}
.success-check{width:72px;height:72px;background:#D1FAE5;border:3px solid #6EE7B7;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:2rem;color:#065F46;margin:0 auto 1.5rem}
.success-header h1{font-family:var(--font-serif);font-size:2.25rem;font-weight:400;color:var(--brown);margin-bottom:.5rem}
.success-header p{color:var(--text-light);margin-bottom:1.25rem}
.success-order-id{display:inline-block;background:var(--cream);border:1px solid var(--border);padding:.5rem 1.75rem;border-radius:20px;font-family:var(--font-serif);font-size:1.1rem;font-weight:600;color:var(--brown);letter-spacing:.05em}

/* TRACKING */
.tracking-card{background:var(--white);border:1px solid var(--border);border-radius:var(--radius-lg);overflow:hidden;margin-bottom:1.5rem;box-shadow:var(--shadow)}
.tracking-header{display:flex;align-items:center;justify-content:space-between;padding:1.25rem 1.5rem;background:var(--cream);border-bottom:1px solid var(--border)}
.tracking-header h3{font-family:var(--font-serif);font-size:1.2rem;font-weight:600;color:var(--brown)}
.delivery-to{font-size:.82rem;color:var(--text-light)}
.delivery-to strong{color:var(--gold)}
.tracking-body{padding:1.75rem 1.5rem}
.tracking-timeline{margin-bottom:2rem}
.track-step{display:grid;grid-template-columns:20px 1fr;grid-template-rows:auto auto;gap:0 1.25rem;margin-bottom:.25rem}
.track-dot{width:20px;height:20px;border-radius:50%;border:2.5px solid var(--border);background:var(--white);grid-row:1;flex-shrink:0;transition:all .3s;margin-top:2px}
.track-dot.done{background:var(--gold);border-color:var(--gold)}
.track-dot.active{background:var(--white);border-color:var(--gold);box-shadow:0 0 0 4px rgba(196,148,42,.15)}
.track-dot.last{border-color:var(--border)}
.track-line{width:2px;background:var(--border);margin:4px auto 0;height:100%;min-height:40px;grid-column:1;grid-row:2}
.track-line.last{background:transparent}
.track-step.done .track-line{background:var(--gold)}
.track-step.active .track-line{background:linear-gradient(to bottom,var(--gold) 0%,var(--border) 100%)}
.track-info{grid-column:2;grid-row:1 / 3;padding-bottom:1.5rem}
.track-info strong{display:block;font-size:.9rem;font-weight:500;color:var(--brown);margin-bottom:.2rem}
.track-info span{display:block;font-size:.75rem;color:var(--gold);margin-bottom:.25rem;font-weight:500}
.track-info p{font-size:.8rem;color:var(--text-light);line-height:1.5}
.track-step.done .track-info strong{color:var(--gold)}
.delivery-summary-box{display:grid;grid-template-columns:1fr 1fr;gap:1rem;background:var(--cream);border-radius:var(--radius-lg);padding:1.25rem}
.dsb-item{display:flex;align-items:center;gap:.75rem}
.dsb-icon{font-size:1.4rem;flex-shrink:0}
.dsb-item strong{display:block;font-size:.83rem;color:var(--brown);margin-bottom:.15rem}
.dsb-item p{font-size:.78rem;color:var(--text-light)}

/* DETAILS GRID */
.success-details-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:1rem;margin-bottom:1.5rem}
.sd-card{background:var(--white);border:1px solid var(--border);border-radius:var(--radius-lg);padding:1.1rem;display:flex;align-items:flex-start;gap:.75rem;box-shadow:var(--shadow)}
.sd-icon{font-size:1.3rem;flex-shrink:0}
.sd-card strong{display:block;font-size:.82rem;color:var(--brown);margin-bottom:.2rem}
.sd-card p{font-size:.76rem;color:var(--text-light);line-height:1.4}

/* ORDER ITEMS */
.success-items-card{background:var(--white);border:1px solid var(--border);border-radius:var(--radius-lg);padding:1.5rem;margin-bottom:1.5rem;box-shadow:var(--shadow)}
.success-items-card h3{font-family:var(--font-serif);font-size:1.1rem;font-weight:600;color:var(--brown);margin-bottom:1.25rem;padding-bottom:.75rem;border-bottom:1px solid var(--border)}
.si-row{display:flex;align-items:center;justify-content:space-between;padding:.6rem 0;border-bottom:1px solid var(--cream-dark)}
.si-info strong{display:block;font-size:.87rem;color:var(--brown)}
.si-info span{font-size:.75rem;color:var(--text-light)}
.si-price{font-family:var(--font-serif);font-size:.95rem;font-weight:600;color:var(--brown)}
.si-totals{margin-top:.75rem;padding-top:.75rem;border-top:1px solid var(--border)}
.si-total-line{display:flex;justify-content:space-between;font-size:.85rem;color:var(--text-mid);padding:.3rem 0}
.si-grand-total{font-family:var(--font-serif);font-size:1.2rem;font-weight:600;color:var(--brown);border-top:1px solid var(--border);padding-top:.5rem;margin-top:.25rem}

/* ACTIONS */
.success-actions{display:flex;align-items:center;justify-content:center;gap:1.5rem;flex-wrap:wrap}
.btn-orders-link{font-size:.88rem;color:var(--gold);font-weight:500}

@media(max-width:700px){
  .success-details-grid{grid-template-columns:repeat(2,1fr)}
  .delivery-summary-box{grid-template-columns:1fr}
  .tracking-header{flex-direction:column;align-items:flex-start;gap:.5rem}
}
@media(max-width:480px){.success-details-grid{grid-template-columns:1fr}}
</style>

<?php include 'includes/footer.php'; ?>
