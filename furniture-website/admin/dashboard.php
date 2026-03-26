<?php
/**
 * admin/dashboard.php — MAISON Admin Panel
 */
session_start();

// Guard: only admin users
if (empty($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header('Location: ../login.php');
    exit;
}

// Database
require_once '../config/db.php';

// ── Fetch dashboard stats ────────────────────────────────────────────────────
$stats = [
    'total_orders'   => $pdo->query("SELECT COUNT(*) FROM orders")->fetchColumn(),
    'revenue'        => $pdo->query("SELECT COALESCE(SUM(total),0) FROM orders WHERE status='paid'")->fetchColumn(),
    'total_products' => $pdo->query("SELECT COUNT(*) FROM products")->fetchColumn(),
    'total_users'    => $pdo->query("SELECT COUNT(*) FROM users WHERE role='customer'")->fetchColumn(),
    'pending_orders' => $pdo->query("SELECT COUNT(*) FROM orders WHERE status='paid'")->fetchColumn(),
    'today_revenue'  => $pdo->query("SELECT COALESCE(SUM(total),0) FROM orders WHERE DATE(created_at)=CURDATE()")->fetchColumn(),
];

// Recent orders
$recent_orders = $pdo->query("
    SELECT o.*, u.first_name, u.last_name
    FROM orders o
    LEFT JOIN users u ON o.user_id = u.id
    ORDER BY o.created_at DESC
    LIMIT 10
")->fetchAll();

// Recent users
$recent_users = $pdo->query("
    SELECT * FROM users WHERE role='customer' ORDER BY created_at DESC LIMIT 5
")->fetchAll();

// Top products (by order items)
$top_products = $pdo->query("
    SELECT product_name, SUM(qty) as units, SUM(line_total) as revenue
    FROM order_items
    GROUP BY product_name
    ORDER BY revenue DESC
    LIMIT 5
")->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard — MAISON</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;600&family=Jost:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --cream:#F5F0E8;--brown:#2C1810;--gold:#C4942A;--sidebar-w:240px;
            --white:#fff;--bg:#F4F1EC;--border:#E8E1D5;--text:#1A0F0A;
            --text-mid:#5C3D2E;--text-light:#8B7355;--radius:8px;
            --shadow:0 2px 16px rgba(44,24,16,.08);
        }
        *{box-sizing:border-box;margin:0;padding:0}
        body{font-family:'Jost',sans-serif;font-weight:300;background:var(--bg);color:var(--text);display:flex;min-height:100vh}
        a{color:inherit;text-decoration:none}
        ul{list-style:none}

        /* ── SIDEBAR ── */
        .sidebar{width:var(--sidebar-w);background:var(--brown);flex-shrink:0;display:flex;flex-direction:column;min-height:100vh;position:sticky;top:0}
        .sidebar-logo{padding:1.5rem 1.25rem;border-bottom:1px solid rgba(255,255,255,.1);display:flex;align-items:center;gap:.5rem}
        .sidebar-logo span{color:#C4942A;font-size:1.1rem}
        .sidebar-logo h1{font-family:'Cormorant Garamond',serif;font-size:1.25rem;font-weight:600;letter-spacing:.15em;color:#F5F0E8}
        .sidebar-logo small{display:block;font-size:.6rem;letter-spacing:.15em;text-transform:uppercase;color:rgba(255,255,255,.4)}
        .sidebar-nav{flex:1;padding:1rem 0}
        .nav-section{padding:.5rem 1.25rem .25rem;font-size:.65rem;letter-spacing:.15em;text-transform:uppercase;color:rgba(255,255,255,.35)}
        .nav-item{display:flex;align-items:center;gap:.75rem;padding:.65rem 1.25rem;font-size:.82rem;color:rgba(255,255,255,.65);transition:all .2s;border-left:3px solid transparent;cursor:pointer}
        .nav-item:hover,.nav-item.active{color:#fff;background:rgba(255,255,255,.07);border-left-color:var(--gold)}
        .nav-item.active{color:var(--gold)}
        .nav-icon{width:16px;text-align:center;font-size:.9rem}
        .sidebar-footer{padding:1rem 1.25rem;border-top:1px solid rgba(255,255,255,.1)}
        .admin-user{display:flex;align-items:center;gap:.75rem}
        .admin-av{width:32px;height:32px;background:var(--gold);border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:.72rem;font-weight:600;color:#fff;flex-shrink:0}
        .admin-info{font-size:.75rem}
        .admin-info strong{display:block;color:#F5F0E8}
        .admin-info span{color:rgba(255,255,255,.45)}
        .logout-link{font-size:.7rem;color:rgba(255,255,255,.4);display:block;margin-top:.25rem;transition:color .2s}
        .logout-link:hover{color:var(--gold)}

        /* ── MAIN ── */
        .main{flex:1;overflow-x:hidden}
        .topbar{background:var(--white);border-bottom:1px solid var(--border);padding:.85rem 2rem;display:flex;align-items:center;justify-content:space-between;position:sticky;top:0;z-index:10;box-shadow:var(--shadow)}
        .topbar h2{font-family:'Cormorant Garamond',serif;font-size:1.4rem;font-weight:600;color:var(--brown)}
        .topbar-right{display:flex;align-items:center;gap:1rem;font-size:.82rem;color:var(--text-mid)}
        .topbar-right .live-dot{width:8px;height:8px;background:#22C55E;border-radius:50%;animation:pulse 2s infinite}
        @keyframes pulse{0%,100%{opacity:1}50%{opacity:.4}}
        .content{padding:2rem}

        /* ── STAT CARDS ── */
        .stats-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:1.25rem;margin-bottom:2rem}
        .stat-card{background:var(--white);border-radius:var(--radius);padding:1.5rem;border:1px solid var(--border);box-shadow:var(--shadow);transition:transform .2s}
        .stat-card:hover{transform:translateY(-2px)}
        .stat-top{display:flex;align-items:flex-start;justify-content:space-between;margin-bottom:1rem}
        .stat-label-sm{font-size:.72rem;font-weight:500;letter-spacing:.1em;text-transform:uppercase;color:var(--text-light)}
        .stat-icon{width:38px;height:38px;border-radius:8px;display:flex;align-items:center;justify-content:center;font-size:1.1rem}
        .stat-icon.gold{background:#FEF9EE}
        .stat-icon.brown{background:#F5F0E8}
        .stat-icon.green{background:#E8F5E9}
        .stat-num-big{font-family:'Cormorant Garamond',serif;font-size:2rem;font-weight:600;color:var(--brown);margin-bottom:.25rem}
        .stat-change{font-size:.75rem}
        .stat-change.up{color:#22C55E}
        .stat-change.down{color:#E05252}
        .stat-change.neutral{color:var(--text-light)}

        /* ── TABLES ── */
        .panel{background:var(--white);border-radius:var(--radius);border:1px solid var(--border);box-shadow:var(--shadow);overflow:hidden;margin-bottom:1.5rem}
        .panel-header{display:flex;align-items:center;justify-content:space-between;padding:1.1rem 1.5rem;border-bottom:1px solid var(--border)}
        .panel-header h3{font-family:'Cormorant Garamond',serif;font-size:1.1rem;font-weight:600;color:var(--brown)}
        .panel-action{font-size:.75rem;color:var(--gold);font-weight:500;cursor:pointer;padding:.3rem .75rem;border:1px solid var(--gold);border-radius:4px;transition:all .2s}
        .panel-action:hover{background:var(--gold);color:#fff}
        table{width:100%;border-collapse:collapse}
        th{padding:.7rem 1rem;font-size:.68rem;font-weight:600;letter-spacing:.1em;text-transform:uppercase;color:var(--text-light);background:var(--cream);text-align:left;border-bottom:1px solid var(--border)}
        td{padding:.85rem 1rem;font-size:.82rem;color:var(--text-mid);border-bottom:1px solid var(--border)}
        tr:last-child td{border-bottom:none}
        tr:hover td{background:var(--cream)}
        .order-id{font-weight:500;color:var(--brown);font-family:'Cormorant Garamond',serif;font-size:.95rem}
        .status-badge{display:inline-block;padding:.2rem .65rem;border-radius:20px;font-size:.68rem;font-weight:600;letter-spacing:.04em}
        .status-paid{background:#E8F5E9;color:#2E7D32}
        .status-pending{background:#FEF9EE;color:#C47A00}
        .status-shipped{background:#E3F2FD;color:#1565C0}
        .status-cancelled{background:#FEE;color:#C0392B}
        .status-delivered{background:#E8F5E9;color:#2E7D32}
        .action-link{color:var(--gold);font-size:.75rem;cursor:pointer;border:none;background:none;font-family:'Jost',sans-serif;padding:0}
        .action-link:hover{text-decoration:underline}

        /* ── DUAL PANEL ── */
        .dual-panels{display:grid;grid-template-columns:1.6fr 1fr;gap:1.25rem}

        /* ── QUICK ACTIONS ── */
        .quick-actions{display:grid;grid-template-columns:repeat(4,1fr);gap:.75rem;margin-bottom:2rem}
        .qa-btn{background:var(--white);border:1px solid var(--border);border-radius:var(--radius);padding:1rem;text-align:center;cursor:pointer;transition:all .2s;display:block}
        .qa-btn:hover{border-color:var(--gold);box-shadow:0 0 0 3px rgba(196,148,42,.1)}
        .qa-icon{font-size:1.4rem;margin-bottom:.4rem}
        .qa-label{font-size:.75rem;font-weight:500;color:var(--text-mid)}

        @media(max-width:1100px){.stats-grid{grid-template-columns:repeat(2,1fr)}}
        @media(max-width:900px){.dual-panels{grid-template-columns:1fr}.stats-grid{grid-template-columns:1fr 1fr}}
    </style>
</head>
<body>

<!-- ── SIDEBAR ── -->
<aside class="sidebar">
    <div class="sidebar-logo">
        <span>◈</span>
        <div><h1>MANE FURNITURE</h1><small>Admin Panel</small></div>
    </div>
    <nav class="sidebar-nav">
        <div class="nav-section">Main</div>
        <a href="dashboard.php" class="nav-item active"><span class="nav-icon">📊</span> Dashboard</a>
        <a href="orders.php" class="nav-item"><span class="nav-icon">📦</span> Orders <span style="margin-left:auto;background:var(--gold);color:#fff;font-size:.65rem;padding:.15rem .45rem;border-radius:20px"><?= $stats['pending_orders'] ?></span></a>
        <a href="products.php" class="nav-item"><span class="nav-icon">🛋️</span> Products</a>
        <a href="customers.php" class="nav-item"><span class="nav-icon">👥</span> Customers</a>
        <div class="nav-section" style="margin-top:1rem">Content</div>
        <a href="categories.php" class="nav-item"><span class="nav-icon">🗂️</span> Categories</a>
        <a href="coupons.php" class="nav-item"><span class="nav-icon">🏷️</span> Coupons</a>
        <a href="banners.php" class="nav-item"><span class="nav-icon">🖼️</span> Banners</a>
        <div class="nav-section" style="margin-top:1rem">Reports</div>
        <a href="reports.php" class="nav-item"><span class="nav-icon">📈</span> Sales Reports</a>
        <a href="reviews.php" class="nav-item"><span class="nav-icon">⭐</span> Reviews</a>
        <div class="nav-section" style="margin-top:1rem">Settings</div>
        <a href="settings.php" class="nav-item"><span class="nav-icon">⚙️</span> Site Settings</a>
        <a href="delivery.php" class="nav-item"><span class="nav-icon">🚚</span> Delivery Zones</a>
    </nav>
    <div class="sidebar-footer">
        <div class="admin-user">
            <div class="admin-av"><?= strtoupper(substr($_SESSION['user']['first_name'],0,1) . substr(explode(' ',$_SESSION['user']['name'])[1]??'',0,1)) ?></div>
            <div class="admin-info">
                <strong><?= htmlspecialchars($_SESSION['user']['name']) ?></strong>
                <span>Administrator</span>
                <a href="../logout.php" class="logout-link">Sign out →</a>
            </div>
        </div>
    </div>
</aside>

<!-- ── MAIN AREA ── -->
<main class="main">
    <div class="topbar">
        <h2>Dashboard</h2>
        <div class="topbar-right">
            <span class="live-dot"></span>
            <span>Live</span>
            <span>·</span>
            <span><?= date('D, d M Y') ?></span>
            <a href="../index.php" target="_blank" style="color:var(--gold);font-size:.8rem">View Site →</a>
        </div>
    </div>

    <div class="content">

        <!-- QUICK ACTIONS -->
        <div class="quick-actions">
            <a href="products.php?action=add" class="qa-btn"><div class="qa-icon">➕</div><div class="qa-label">Add Product</div></a>
            <a href="orders.php" class="qa-btn"><div class="qa-icon">📦</div><div class="qa-label">View Orders</div></a>
            <a href="coupons.php?action=add" class="qa-btn"><div class="qa-icon">🏷️</div><div class="qa-label">New Coupon</div></a>
            <a href="reports.php" class="qa-btn"><div class="qa-icon">📈</div><div class="qa-label">Sales Report</div></a>
        </div>

        <!-- STATS -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-top"><div class="stat-label-sm">Total Revenue</div><div class="stat-icon gold">💰</div></div>
                <div class="stat-num-big">₹<?= number_format($stats['revenue']) ?></div>
                <span class="stat-change up">↑ 12% vs last month</span>
            </div>
            <div class="stat-card">
                <div class="stat-top"><div class="stat-label-sm">Total Orders</div><div class="stat-icon brown">📦</div></div>
                <div class="stat-num-big"><?= number_format($stats['total_orders']) ?></div>
                <span class="stat-change up">↑ 8 new today</span>
            </div>
            <div class="stat-card">
                <div class="stat-top"><div class="stat-label-sm">Today's Revenue</div><div class="stat-icon green">📅</div></div>
                <div class="stat-num-big">₹<?= number_format($stats['today_revenue']) ?></div>
                <span class="stat-change neutral">Updated live</span>
            </div>
            <div class="stat-card">
                <div class="stat-top"><div class="stat-label-sm">Total Customers</div><div class="stat-icon gold">👥</div></div>
                <div class="stat-num-big"><?= number_format($stats['total_users']) ?></div>
                <span class="stat-change up">↑ 3 new today</span>
            </div>
            <div class="stat-card">
                <div class="stat-top"><div class="stat-label-sm">Products Listed</div><div class="stat-icon brown">🛋️</div></div>
                <div class="stat-num-big"><?= $stats['total_products'] ?></div>
                <span class="stat-change neutral">Across 5 categories</span>
            </div>
            <div class="stat-card">
                <div class="stat-top"><div class="stat-label-sm">Pending Orders</div><div class="stat-icon" style="background:#FEF9EE">⏳</div></div>
                <div class="stat-num-big" style="color:var(--gold)"><?= $stats['pending_orders'] ?></div>
                <span class="stat-change <?= $stats['pending_orders'] > 0 ? 'down' : 'up' ?>"><?= $stats['pending_orders'] > 0 ? 'Needs attention' : 'All clear ✓' ?></span>
            </div>
        </div>

        <!-- RECENT ORDERS + TOP PRODUCTS -->
        <div class="dual-panels">
            <!-- Recent Orders -->
            <div class="panel">
                <div class="panel-header">
                    <h3>Recent Orders</h3>
                    <a href="orders.php" class="panel-action">View All</a>
                </div>
                <table>
                    <thead>
                        <tr><th>Order ID</th><th>Customer</th><th>Amount</th><th>Status</th><th>Date</th><th>Action</th></tr>
                    </thead>
                    <tbody>
                    <?php if (empty($recent_orders)): ?>
                        <tr><td colspan="6" style="text-align:center;padding:2rem;color:var(--text-light)">No orders yet</td></tr>
                    <?php else: foreach ($recent_orders as $order): ?>
                        <tr>
                            <td><span class="order-id">ORD<?= str_pad($order['id'], 6, '0', STR_PAD_LEFT) ?></span></td>
                            <td><?= htmlspecialchars($order['first_name'] . ' ' . $order['last_name']) ?></td>
                            <td>₹<?= number_format($order['total']) ?></td>
                            <td><span class="status-badge status-<?= $order['status'] ?>"><?= ucfirst($order['status']) ?></span></td>
                            <td><?= date('d M, H:i', strtotime($order['created_at'])) ?></td>
                            <td><a href="order-detail.php?id=<?= $order['id'] ?>" class="action-link">View →</a></td>
                        </tr>
                    <?php endforeach; endif; ?>
                    </tbody>
                </table>
            </div>

            <!-- Top Products -->
            <div class="panel">
                <div class="panel-header">
                    <h3>Top Products</h3>
                    <a href="products.php" class="panel-action">Manage</a>
                </div>
                <table>
                    <thead><tr><th>Product</th><th>Units</th><th>Revenue</th></tr></thead>
                    <tbody>
                    <?php if (empty($top_products)): ?>
                        <tr><td colspan="3" style="text-align:center;padding:2rem;color:var(--text-light)">No sales data yet</td></tr>
                    <?php else: foreach ($top_products as $p): ?>
                        <tr>
                            <td style="font-weight:500;color:var(--brown)"><?= htmlspecialchars($p['product_name']) ?></td>
                            <td><?= $p['units'] ?></td>
                            <td>₹<?= number_format($p['revenue']) ?></td>
                        </tr>
                    <?php endforeach; endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- RECENT CUSTOMERS -->
        <div class="panel">
            <div class="panel-header">
                <h3>New Customers</h3>
                <a href="customers.php" class="panel-action">View All</a>
            </div>
            <table>
                <thead><tr><th>Name</th><th>Email</th><th>Phone</th><th>Joined</th><th>Status</th></tr></thead>
                <tbody>
                <?php if (empty($recent_users)): ?>
                    <tr><td colspan="5" style="text-align:center;padding:2rem;color:var(--text-light)">No customers yet</td></tr>
                <?php else: foreach ($recent_users as $u): ?>
                    <tr>
                        <td style="font-weight:500;color:var(--brown)"><?= htmlspecialchars($u['first_name'].' '.$u['last_name']) ?></td>
                        <td><?= htmlspecialchars($u['email']) ?></td>
                        <td><?= htmlspecialchars($u['phone'] ?? '—') ?></td>
                        <td><?= date('d M Y', strtotime($u['created_at'])) ?></td>
                        <td><span class="status-badge status-<?= $u['status'] === 'active' ? 'paid' : 'cancelled' ?>"><?= ucfirst($u['status']) ?></span></td>
                    </tr>
                <?php endforeach; endif; ?>
                </tbody>
            </table>
        </div>

    </div>
</main>

</body>
</html>
