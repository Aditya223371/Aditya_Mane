<?php
if (session_status() === PHP_SESSION_NONE) session_start();
define('SITE_NAME', 'MANE FURNITURE');
define('SITE_TAGLINE', 'Premium Furniture');
$page_title = 'My Account';

if (empty($_SESSION['user'])) {
    header('Location: /furniture-website/login.php'); exit;
}

$user   = $_SESSION['user'];
$orders = [];
$order_items_map = [];
$db_error = '';
$cancel_msg = '';

// ── Handle Cancel Order ─────────────────────────────────────────────────────
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['cancel_order_id'])) {
    $cancel_id = (int)$_POST['cancel_order_id'];
    $cp = __DIR__ . '/config/db.php';
    if (file_exists($cp)) {
        try {
            require_once $cp;
            $chk = $pdo->prepare("SELECT id,status FROM orders WHERE id=? AND (user_id=? OR ship_email=?) LIMIT 1");
            $chk->execute([$cancel_id, $user['id'], $user['email']]);
            $chkOrder = $chk->fetch();
            if (!$chkOrder) {
                $cancel_msg = ['type'=>'error','text'=>'Order not found.'];
            } elseif (!in_array($chkOrder['status'], ['paid','processing'])) {
                $cancel_msg = ['type'=>'error','text'=>'Cannot cancel — order already '.$chkOrder['status'].'.'];
            } else {
                $pdo->prepare("UPDATE orders SET status='cancelled', updated_at=NOW() WHERE id=?")->execute([$cancel_id]);
                $cancel_msg = ['type'=>'success','text'=>'Order ORD'.str_pad($cancel_id,6,'0',STR_PAD_LEFT).' cancelled successfully. A refund will be processed within 5–7 business days if payment was made online.'];
            }
        } catch (Exception $e) {
            $cancel_msg = ['type'=>'error','text'=>'Error: '.$e->getMessage()];
        }
    }
}
// ────────────────────────────────────────────────────────────────────────────


$config_path = __DIR__ . '/config/db.php';
if (file_exists($config_path)) {
    try {
        require_once $config_path;

        // Fetch by user_id OR email (covers both logged-in and guest orders)
        $stmt = $pdo->prepare("
            SELECT * FROM orders
            WHERE user_id = ? OR ship_email = ?
            ORDER BY created_at DESC
        ");
        $stmt->execute([$user['id'], $user['email']]);
        $orders = $stmt->fetchAll();

        // Fetch all items for these orders
        if (!empty($orders)) {
            $order_ids   = array_column($orders, 'id');
            $placeholders = implode(',', array_fill(0, count($order_ids), '?'));
            $stmt2 = $pdo->prepare("SELECT * FROM order_items WHERE order_id IN ($placeholders)");
            $stmt2->execute($order_ids);
            foreach ($stmt2->fetchAll() as $item) {
                $order_items_map[$item['order_id']][] = $item;
            }
        }

    } catch (Exception $e) {
        $db_error = $e->getMessage();
    }
} else {
    $db_error = 'config/db.php not found';
}

// Stats
$total_orders    = count($orders);
$delivered_count = count(array_filter($orders, function($o){ return $o['status']==='delivered'; }));
$total_spent     = array_sum(array_column($orders, 'total'));

include 'includes/header.php';
?>

<div class="account-page">
    <div class="container">

        <!-- ACCOUNT HEADER -->
        <div class="account-header">
            <div class="account-avatar">
                <?= strtoupper(substr($user['first_name']??'U',0,1).substr(explode(' ',$user['name']??'')[1]??'U',0,1)) ?>
            </div>
            <div class="account-header-info">
                <h1>Welcome back, <?= htmlspecialchars($user['first_name']) ?>!</h1>
                <p><?= htmlspecialchars($user['email']) ?></p>
                <span class="<?= (!empty($user['role'])&&$user['role']==='admin')?'admin-badge':'member-badge' ?>">
                    <?= (!empty($user['role'])&&$user['role']==='admin')?'Administrator':'Member' ?>
                </span>
            </div>
            <?php if (!empty($user['role'])&&$user['role']==='admin'): ?>
            <a href="/furniture-website/admin/dashboard.php" class="btn-admin-link">⚙ Admin Panel</a>
            <?php endif; ?>
            <a href="/furniture-website/logout.php" class="btn-signout">Sign Out</a>
        </div>

        <!-- STATS -->
        <div class="account-stats">
            <div class="acc-stat">
                <span class="acc-stat-num"><?= $total_orders ?></span>
                <span class="acc-stat-label">Total Orders</span>
            </div>
            <div class="acc-stat">
                <span class="acc-stat-num"><?= $delivered_count ?></span>
                <span class="acc-stat-label">Delivered</span>
            </div>
            <div class="acc-stat">
                <span class="acc-stat-num">₹<?= $total_spent > 0 ? number_format($total_spent) : '0' ?></span>
                <span class="acc-stat-label">Total Spent</span>
            </div>
            <div class="acc-stat">
                <span class="acc-stat-num">0</span>
                <span class="acc-stat-label">Wishlist Items</span>
            </div>
        </div>

        <!-- LAYOUT -->
        <div class="account-layout">

            <!-- SIDEBAR -->
            <aside class="account-sidebar">
                <nav class="acc-nav">
                    <a href="#" class="acc-nav-item active" onclick="showTab('orders',this)">
                        <span>📦</span> My Orders
                        <?php if ($total_orders > 0): ?>
                        <span class="nav-badge"><?= $total_orders ?></span>
                        <?php endif; ?>
                    </a>
                    <a href="#" class="acc-nav-item" onclick="showTab('profile',this)">
                        <span>👤</span> My Profile
                    </a>
                    <a href="#" class="acc-nav-item" onclick="showTab('addresses',this)">
                        <span>📍</span> Addresses
                    </a>
                    <a href="#" class="acc-nav-item" onclick="showTab('wishlist',this)">
                        <span>♡</span> Wishlist
                    </a>
                    <a href="/furniture-website/catalog.php" class="acc-nav-item">
                        <span>🛋️</span> Browse Collection
                    </a>
                    <a href="/furniture-website/logout.php" class="acc-nav-item acc-nav-logout">
                        <span>→</span> Sign Out
                    </a>
                </nav>
            </aside>

            <!-- MAIN CONTENT -->
            <main class="account-main">

                <!-- ORDERS TAB -->
                <div class="acc-tab active" id="tab-orders">
                    <div class="acc-section-header">
                        <h2>My Orders</h2>
                        <a href="/furniture-website/catalog.php" class="section-link">Shop More →</a>
                    </div>


                    <?php if (!empty($cancel_msg)): ?>
                    <div class="cancel-alert cancel-alert-<?= $cancel_msg['type'] ?>">
                        <?= $cancel_msg['type']==='success' ? '✓' : '⚠' ?> <?= htmlspecialchars($cancel_msg['text']) ?>
                    </div>
                    <?php endif; ?>

                    <?php if ($db_error): ?>
                    <div class="db-error-box">
                        <strong>⚠ Database not connected</strong>
                        <p>Orders will appear here once your database is set up.</p>
                        <small>Error: <?= htmlspecialchars($db_error) ?></small>
                    </div>
                    <?php elseif (empty($orders)): ?>
                    <div class="acc-empty">
                        <div class="acc-empty-icon">📦</div>
                        <h3>No orders yet</h3>
                        <p>You haven't placed any orders yet. Start exploring our collection!</p>
                        <a href="/furniture-website/catalog.php" class="btn btn-primary">Browse Collection</a>
                    </div>
                    <?php else: ?>
                    <div class="orders-list">
                        <?php foreach ($orders as $order): ?>
                        <div class="order-card">
                            <!-- Order Header -->
                            <div class="order-card-header">
                                <div class="order-id-wrap">
                                    <span class="order-id">ORD<?= str_pad($order['id'],6,'0',STR_PAD_LEFT) ?></span>
                                    <span class="order-date"><?= date('d M Y, h:i A', strtotime($order['created_at'])) ?></span>
                                </div>
                                <span class="order-status status-<?= $order['status'] ?>"><?= ucfirst($order['status']) ?></span>
                            </div>

                            <!-- Order Items -->
                            <?php if (!empty($order_items_map[$order['id']])): ?>
                            <div class="order-items-list">
                                <?php foreach ($order_items_map[$order['id']] as $oi): ?>
                                <div class="order-item-row">
                                    <div class="oi-name">
                                        <strong><?= htmlspecialchars($oi['product_name']) ?></strong>
                                        <span>Qty: <?= $oi['qty'] ?></span>
                                    </div>
                                    <div class="oi-price">₹<?= number_format($oi['line_total']) ?></div>
                                </div>
                                <?php endforeach; ?>
                            </div>
                            <?php endif; ?>

                            <!-- Order Footer -->
                            <div class="order-card-footer">
                                <div class="order-delivery-info">
                                    <span class="odi">📍 <?= htmlspecialchars($order['ship_city'].', '.$order['ship_state']) ?></span>
                                    <span class="odi">💳 <?= $order['payment_method']==='cod'?'Cash on Delivery':ucfirst($order['payment_method']) ?></span>
                                    <span class="odi">🚚 <?= $order['status']==='delivered'?'Delivered':'Est. 7–10 business days' ?></span>
                                </div>
                                <div class="order-total-wrap">
                                    <?php if ($order['discount'] > 0): ?>
                                    <span class="order-discount-tag">Saved ₹<?= number_format($order['discount']) ?></span>
                                    <?php endif; ?>
                                    <span class="order-total-amt">₹<?= number_format($order['total']) ?></span>
                                </div>
                            </div>

                            <!-- Cancel Button — only show if not shipped/delivered/cancelled -->
                            <?php if (in_array($order['status'], ['paid','processing'])): ?>
                            <div class="cancel-order-row">
                                <div class="cancel-info">
                                    <span class="cancel-info-icon">ℹ️</span>
                                    <span>You can cancel this order before it is shipped.</span>
                                </div>
                                <form method="POST" onsubmit="return confirmCancel('<?= 'ORD'.str_pad($order['id'],6,'0',STR_PAD_LEFT) ?>')">
                                    <input type="hidden" name="cancel_order_id" value="<?= $order['id'] ?>" />
                                    <button type="submit" class="btn-cancel-order">Cancel Order</button>
                                </form>
                            </div>
                            <?php elseif ($order['status'] === 'cancelled'): ?>
                            <div class="cancelled-notice">
                                ✕ This order was cancelled.
                                <?php if (!empty($order['cancel_reason'])): ?>
                                Reason: <?= htmlspecialchars($order['cancel_reason']) ?>
                                <?php endif; ?>
                            </div>
                            <?php elseif ($order['status'] === 'shipped'): ?>
                            <div class="shipped-notice">
                                🚚 Order has been shipped — cancellation is no longer possible.
                            </div>
                            <?php endif; ?>

                            <!-- Delivery Progress Bar -->
                            <?php if ($order['status'] !== 'cancelled'): ?>
                            <?php
                            $statuses = ['paid'=>1,'processing'=>2,'shipped'=>3,'delivered'=>4];
                            $current_step = $statuses[$order['status']] ?? 1;
                            $steps = ['Confirmed','Processing','Shipped','Delivered'];
                            ?>
                            <div class="delivery-progress">
                                <?php foreach ($steps as $i => $step): ?>
                                <div class="dp-step <?= ($i+1)<=$current_step?'dp-done':'' ?> <?= ($i+1)==$current_step?'dp-active':'' ?>">
                                    <div class="dp-dot"></div>
                                    <span><?= $step ?></span>
                                </div>
                                <?php if ($i < count($steps)-1): ?>
                                <div class="dp-line <?= ($i+1)<$current_step?'dp-line-done':'' ?>"></div>
                                <?php endif; ?>
                                <?php endforeach; ?>
                            </div>
                            <?php endif; ?>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>
                </div>

                <!-- PROFILE TAB -->
                <div class="acc-tab" id="tab-profile">
                    <div class="acc-section-header"><h2>My Profile</h2></div>
                    <form class="profile-form" method="POST" action="/furniture-website/update-profile.php">
                        <div class="form-row-2">
                            <div class="form-group">
                                <label>First Name</label>
                                <input type="text" name="first_name" value="<?= htmlspecialchars($user['first_name']) ?>" />
                            </div>
                            <div class="form-group">
                                <label>Last Name</label>
                                <input type="text" name="last_name" value="<?= htmlspecialchars(explode(' ',$user['name'])[1]??'') ?>" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Email Address</label>
                            <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" />
                        </div>
                        <div class="form-group">
                            <label>Phone Number</label>
                            <input type="tel" name="phone" placeholder="+91 98765 43210" />
                        </div>
                        <div class="profile-divider">Change Password</div>
                        <div class="form-group">
                            <label>New Password</label>
                            <input type="password" name="new_password" placeholder="Leave blank to keep current" />
                        </div>
                        <div class="form-group">
                            <label>Confirm New Password</label>
                            <input type="password" name="confirm_password" placeholder="Repeat new password" />
                        </div>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </form>
                </div>

                <!-- ADDRESSES TAB -->
                <div class="acc-tab" id="tab-addresses">
                    <div class="acc-section-header">
                        <h2>Saved Addresses</h2>
                        <button class="btn-sm-gold" onclick="document.getElementById('addAddrForm').style.display='block';this.style.display='none'">+ Add New Address</button>
                    </div>
                    <!-- Pull from recent order -->
                    <?php if (!empty($orders)): ?>
                    <?php $last = $orders[0]; ?>
                    <div class="saved-address-card">
                        <div class="sa-badge">Default</div>
                        <p><strong><?= htmlspecialchars($last['ship_name']) ?></strong></p>
                        <p><?= htmlspecialchars($last['ship_addr1']) ?><?= $last['ship_addr2']?', '.$last['ship_addr2']:'' ?></p>
                        <p><?= htmlspecialchars($last['ship_city'].', '.$last['ship_state'].' – '.$last['ship_pin']) ?></p>
                        <p><?= htmlspecialchars($last['ship_phone']) ?></p>
                    </div>
                    <?php else: ?>
                    <div class="acc-empty">
                        <div class="acc-empty-icon">📍</div>
                        <h3>No saved addresses</h3>
                        <p>Your delivery addresses will appear here after your first order.</p>
                    </div>
                    <?php endif; ?>
                    <div id="addAddrForm" style="display:none" class="address-form-box">
                        <div class="form-row-2">
                            <div class="form-group"><label>Full Name</label><input type="text" placeholder="Aditya Mane" /></div>
                            <div class="form-group"><label>Phone</label><input type="tel" placeholder="+91 98765 43210" /></div>
                        </div>
                        <div class="form-group"><label>Address</label><input type="text" placeholder="Flat / Building, Street" /></div>
                        <div class="form-row-3">
                            <div class="form-group"><label>City</label><input type="text" placeholder="Pune" /></div>
                            <div class="form-group"><label>State</label><input type="text" placeholder="Maharashtra" /></div>
                            <div class="form-group"><label>PIN</label><input type="text" placeholder="411001" /></div>
                        </div>
                        <button class="btn btn-primary">Save Address</button>
                    </div>
                </div>

                <!-- WISHLIST TAB -->
                <div class="acc-tab" id="tab-wishlist">
                    <div class="acc-section-header"><h2>My Wishlist</h2></div>
                    <div class="acc-empty">
                        <div class="acc-empty-icon">♡</div>
                        <h3>Your wishlist is empty</h3>
                        <p>Click the heart icon on any product to save it here.</p>
                        <a href="/furniture-website/catalog.php" class="btn btn-primary">Explore Collection</a>
                    </div>
                </div>

            </main>
        </div>
    </div>
</div>

<style>
.account-page{padding:2.5rem 0 5rem}
/* Header */
.account-header{display:flex;align-items:center;gap:1.25rem;margin-bottom:2rem;padding:1.75rem;background:var(--white);border-radius:var(--radius-lg);border:1px solid var(--border);box-shadow:var(--shadow);flex-wrap:wrap}
.account-avatar{width:60px;height:60px;background:var(--gold);color:var(--white);border-radius:50%;display:flex;align-items:center;justify-content:center;font-family:var(--font-serif);font-size:1.3rem;font-weight:600;flex-shrink:0}
.account-header-info{flex:1;min-width:180px}
.account-header-info h1{font-family:var(--font-serif);font-size:1.5rem;font-weight:400;color:var(--brown);margin-bottom:.2rem}
.account-header-info p{font-size:.83rem;color:var(--text-light);margin-bottom:.35rem}
.admin-badge{background:var(--gold);color:var(--white);padding:.2rem .7rem;border-radius:20px;font-size:.7rem;font-weight:600}
.member-badge{background:var(--cream);color:var(--gold);padding:.2rem .7rem;border-radius:20px;font-size:.7rem;font-weight:600;border:1px solid var(--gold)}
.btn-admin-link{padding:.55rem 1rem;background:var(--gold);color:var(--white);border-radius:var(--radius);font-size:.78rem;font-weight:500;transition:all .2s;white-space:nowrap}
.btn-admin-link:hover{background:var(--brown)}
.btn-signout{padding:.55rem 1rem;border:1.5px solid var(--border);border-radius:var(--radius);font-size:.78rem;color:var(--text-light);transition:all .2s;white-space:nowrap}
.btn-signout:hover{border-color:#E05252;color:#E05252}
/* Stats */
.account-stats{display:grid;grid-template-columns:repeat(4,1fr);gap:1rem;margin-bottom:2rem}
.acc-stat{background:var(--white);border:1px solid var(--border);border-radius:var(--radius-lg);padding:1.25rem;text-align:center;box-shadow:var(--shadow)}
.acc-stat-num{display:block;font-family:var(--font-serif);font-size:1.75rem;font-weight:600;color:var(--gold);margin-bottom:.25rem}
.acc-stat-label{font-size:.7rem;text-transform:uppercase;letter-spacing:.1em;color:var(--text-light)}
/* Layout */
.account-layout{display:grid;grid-template-columns:220px 1fr;gap:1.75rem;align-items:start}
.account-sidebar{position:sticky;top:90px}
.acc-nav{background:var(--white);border:1px solid var(--border);border-radius:var(--radius-lg);overflow:hidden;box-shadow:var(--shadow)}
.acc-nav-item{display:flex;align-items:center;gap:.7rem;padding:.82rem 1.25rem;font-size:.84rem;color:var(--text-mid);border-bottom:1px solid var(--cream-dark);transition:all .2s;cursor:pointer;position:relative}
.acc-nav-item:last-child{border-bottom:none}
.acc-nav-item span:first-child{font-size:.95rem;flex-shrink:0}
.acc-nav-item:hover,.acc-nav-item.active{background:var(--cream);color:var(--gold);padding-left:1.5rem}
.nav-badge{margin-left:auto;background:var(--gold);color:#fff;font-size:.65rem;padding:.15rem .45rem;border-radius:20px;font-weight:600}
.acc-nav-logout{color:#E05252}
.acc-nav-logout:hover{background:#FEE;color:#C0392B}
/* Main */
.account-main{background:var(--white);border:1px solid var(--border);border-radius:var(--radius-lg);padding:1.75rem;box-shadow:var(--shadow);min-height:400px}
.acc-tab{display:none}
.acc-tab.active{display:block}
.acc-section-header{display:flex;align-items:center;justify-content:space-between;margin-bottom:1.5rem;padding-bottom:1rem;border-bottom:1px solid var(--border)}
.acc-section-header h2{font-family:var(--font-serif);font-size:1.35rem;font-weight:600;color:var(--brown)}
/* Orders */
.orders-list{display:flex;flex-direction:column;gap:1.25rem}
.order-card{background:var(--off-white);border:1px solid var(--border);border-radius:var(--radius-lg);overflow:hidden;transition:box-shadow .2s}
.order-card:hover{box-shadow:var(--shadow)}
.order-card-header{display:flex;align-items:center;justify-content:space-between;padding:.9rem 1.25rem;background:var(--cream);border-bottom:1px solid var(--border)}
.order-id-wrap{display:flex;align-items:center;gap:.75rem;flex-wrap:wrap}
.order-id{font-family:var(--font-serif);font-size:1.05rem;font-weight:600;color:var(--brown)}
.order-date{font-size:.75rem;color:var(--text-light)}
.order-status{font-size:.7rem;font-weight:600;padding:.25rem .75rem;border-radius:20px;text-transform:capitalize;white-space:nowrap}
.status-paid,.status-delivered{background:#D1FAE5;color:#065F46}
.status-processing,.status-shipped{background:#DBEAFE;color:#1E40AF}
.status-pending{background:#FEF3C7;color:#92400E}
.status-cancelled{background:#FEE2E2;color:#991B1B}
/* Order items list */
.order-items-list{padding:.75rem 1.25rem;border-bottom:1px solid var(--border);background:#fff}
.order-item-row{display:flex;align-items:center;justify-content:space-between;padding:.45rem 0;border-bottom:1px solid var(--cream-dark)}
.order-item-row:last-child{border-bottom:none}
.oi-name strong{display:block;font-size:.85rem;color:var(--brown)}
.oi-name span{font-size:.75rem;color:var(--text-light)}
.oi-price{font-family:var(--font-serif);font-size:.9rem;font-weight:600;color:var(--brown);white-space:nowrap}
/* Footer */
.order-card-footer{display:flex;align-items:center;justify-content:space-between;padding:.85rem 1.25rem;flex-wrap:wrap;gap:.5rem}
.order-delivery-info{display:flex;flex-wrap:wrap;gap:.75rem}
.odi{font-size:.76rem;color:var(--text-light)}
.order-total-wrap{display:flex;align-items:center;gap:.75rem}
.order-discount-tag{background:#D1FAE5;color:#065F46;font-size:.7rem;font-weight:600;padding:.2rem .6rem;border-radius:20px}
.order-total-amt{font-family:var(--font-serif);font-size:1.15rem;font-weight:600;color:var(--brown)}
/* Delivery progress */
.delivery-progress{display:flex;align-items:center;padding:.85rem 1.25rem;background:#fff;border-top:1px solid var(--border)}
.dp-step{display:flex;flex-direction:column;align-items:center;gap:.3rem;position:relative;z-index:1}
.dp-dot{width:14px;height:14px;border-radius:50%;border:2px solid var(--border);background:#fff;transition:all .3s;flex-shrink:0}
.dp-step.dp-done .dp-dot{background:var(--gold);border-color:var(--gold)}
.dp-step.dp-active .dp-dot{background:#fff;border-color:var(--gold);box-shadow:0 0 0 3px rgba(196,148,42,.2)}
.dp-step span{font-size:.65rem;color:var(--text-light);white-space:nowrap;font-weight:500}
.dp-step.dp-done span,.dp-step.dp-active span{color:var(--gold)}
.dp-line{flex:1;height:2px;background:var(--border);margin:0 4px;margin-bottom:16px}
.dp-line-done{background:var(--gold)}
/* Error box */
.db-error-box{background:#FEF3C7;border:1px solid #F59E0B;border-radius:var(--radius);padding:1rem 1.25rem;margin-bottom:1rem}
.db-error-box strong{display:block;color:#92400E;margin-bottom:.25rem}
.db-error-box p{font-size:.85rem;color:#92400E}
.db-error-box small{font-size:.75rem;color:#B45309;display:block;margin-top:.35rem}
/* Profile */
.profile-form .form-row-2,.form-row-2{display:grid;grid-template-columns:1fr 1fr;gap:1rem}
.form-row-3{display:grid;grid-template-columns:1fr 1fr .8fr;gap:1rem}
.form-group{margin-bottom:1rem}
.form-group label{display:block;font-size:.72rem;font-weight:500;text-transform:uppercase;letter-spacing:.06em;color:var(--text-mid);margin-bottom:.4rem}
.form-group input{width:100%;padding:.75rem 1rem;border:1.5px solid var(--border);border-radius:var(--radius);font-family:var(--font-sans);font-size:.9rem;outline:none;transition:border-color .2s;background:var(--off-white)}
.form-group input:focus{border-color:var(--gold);background:#fff}
.profile-divider{font-size:.72rem;font-weight:500;text-transform:uppercase;letter-spacing:.1em;color:var(--text-light);padding:1rem 0 .75rem;border-top:1px solid var(--border);margin:.5rem 0}
/* Address */
.saved-address-card{background:var(--cream);border:1px solid var(--border);border-radius:var(--radius-lg);padding:1.25rem;position:relative;margin-bottom:1rem}
.sa-badge{position:absolute;top:1rem;right:1rem;background:var(--gold);color:#fff;font-size:.68rem;font-weight:600;padding:.2rem .6rem;border-radius:20px}
.saved-address-card p{font-size:.85rem;color:var(--text-mid);line-height:1.7}
.btn-sm-gold{font-size:.78rem;color:var(--gold);border:1px solid var(--gold);padding:.35rem .85rem;border-radius:var(--radius);cursor:pointer;background:none;font-family:var(--font-sans);transition:all .2s}
.btn-sm-gold:hover{background:var(--gold);color:#fff}
.address-form-box{background:var(--cream);border-radius:var(--radius-lg);padding:1.5rem;margin-top:1rem}
/* Empty */
.acc-empty{text-align:center;padding:3rem 1rem}
.acc-empty-icon{font-size:3rem;margin-bottom:1rem}
.acc-empty h3{font-family:var(--font-serif);font-size:1.3rem;color:var(--brown);margin-bottom:.5rem}
.acc-empty p{font-size:.88rem;color:var(--text-light);margin-bottom:1.5rem}

/* Cancel Order */
.cancel-order-row{display:flex;align-items:center;justify-content:space-between;padding:.75rem 1.25rem;background:#FEF9EE;border-top:1px solid var(--border);flex-wrap:wrap;gap:.5rem}
.cancel-info{display:flex;align-items:center;gap:.5rem;font-size:.8rem;color:var(--text-light)}
.cancel-info-icon{font-size:.9rem}
.btn-cancel-order{padding:.45rem 1.1rem;background:none;border:1.5px solid #E05252;color:#E05252;border-radius:var(--radius);font-size:.78rem;font-weight:500;cursor:pointer;font-family:var(--font-sans);transition:all .2s;white-space:nowrap}
.btn-cancel-order:hover{background:#E05252;color:#fff}
.cancelled-notice{padding:.75rem 1.25rem;background:#FEE2E2;font-size:.8rem;color:#991B1B;border-top:1px solid #FCA5A5}
.shipped-notice{padding:.75rem 1.25rem;background:#EFF6FF;font-size:.8rem;color:#1E40AF;border-top:1px solid #BFDBFE}
.cancel-alert{padding:.85rem 1.25rem;border-radius:var(--radius);font-size:.85rem;margin-bottom:1rem;font-weight:500}
.cancel-alert-success{background:#D1FAE5;color:#065F46;border:1px solid #6EE7B7}
.cancel-alert-error{background:#FEE2E2;color:#991B1B;border:1px solid #FCA5A5}
/* Responsive */
@media(max-width:900px){.account-layout{grid-template-columns:1fr}.account-sidebar{position:static}.account-stats{grid-template-columns:repeat(2,1fr)}}
@media(max-width:600px){.account-header{flex-direction:column;align-items:flex-start}.account-stats{grid-template-columns:1fr 1fr}.form-row-2,.form-row-3{grid-template-columns:1fr}.order-card-footer{flex-direction:column;align-items:flex-start}.delivery-progress{overflow-x:auto;padding-bottom:1rem}}
</style>

<script>
function showTab(name, el) {
    event.preventDefault();
    document.querySelectorAll('.acc-tab').forEach(function(t){ t.classList.remove('active'); });
    document.querySelectorAll('.acc-nav-item').forEach(function(n){ n.classList.remove('active'); });
    var tab = document.getElementById('tab-' + name);
    if (tab) tab.classList.add('active');
    if (el) el.classList.add('active');
}
</script>

<?php include 'includes/footer.php'; ?>
