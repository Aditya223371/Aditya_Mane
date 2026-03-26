<?php if (session_status() === PHP_SESSION_NONE) session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($page_title) ? $page_title . ' — ' . SITE_NAME : SITE_NAME . ' — Premium Furniture' ?></title>
    <meta name="description" content="<?= isset($page_desc) ? $page_desc : 'Discover handcrafted luxury furniture at Mane Furniture. Premium living room, bedroom, office and outdoor furniture.' ?>">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,600;1,300;1,400&family=Jost:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/furniture-website/assets/css/style.css">
</head>
<body>

<!-- TOP BAR -->
<div class="topbar">
    <div class="topbar-inner">
        <span>📞 +91 98765 43210</span>
        <span>✦ Free Delivery Above ₹50,000</span>
        <div class="topbar-right">
            <a href="#">Track Order</a>
            <a href="#">Store Locator</a>
        </div>
    </div>
</div>

<!-- HEADER / NAV -->
<header class="site-header" id="site-header">
    <div class="header-inner">
        <button class="mobile-menu-btn" id="mobileMenuBtn" aria-label="Menu">
            <span></span><span></span><span></span>
        </button>

        <a href="/furniture-website/index.php" class="logo">
            <span class="logo-icon">◈</span>
            <span class="logo-text">MANE FURNITURE</span>
        </a>

        <nav class="main-nav" id="mainNav">
            <ul>
                <li><a href="/furniture-website/index.php">Home</a></li>
                <li class="has-dropdown">
                    <a href="/furniture-website/catalog.php">Collection ▾</a>
                    <div class="dropdown-mega">
                        <div class="dropdown-col">
                            <h4>By Room</h4>
                            <a href="/furniture-website/catalog.php?category=Living+Room">Living Room</a>
                            <a href="/furniture-website/catalog.php?category=Bedroom">Bedroom</a>
                            <a href="/furniture-website/catalog.php?category=Office">Office</a>
                            <a href="/furniture-website/catalog.php?category=Outdoor">Outdoor</a>
                            <a href="/furniture-website/catalog.php?category=Dining">Dining</a>
                        </div>
                        <div class="dropdown-col">
                            <h4>By Type</h4>
                            <a href="/furniture-website/catalog.php?type=sofas">Sofas &amp; Lounges</a>
                            <a href="/furniture-website/catalog.php?type=beds">Beds &amp; Frames</a>
                            <a href="/furniture-website/catalog.php?type=tables">Tables</a>
                            <a href="/furniture-website/catalog.php?type=chairs">Chairs</a>
                            <a href="/furniture-website/catalog.php?type=storage">Storage</a>
                        </div>
                        <div class="dropdown-col">
                            <h4>Highlights</h4>
                            <a href="/furniture-website/catalog.php?filter=new">New Arrivals</a>
                            <a href="/furniture-website/catalog.php?filter=bestseller">Bestsellers</a>
                            <a href="/furniture-website/catalog.php?filter=sale">On Sale</a>
                            <a href="/furniture-website/catalog.php?filter=premium">Premium Edit</a>
                        </div>
                        <div class="dropdown-feature">
                            <img src="https://images.unsplash.com/photo-1555041469-a586c61ea9bc?w=300&q=80" alt="Featured" />
                            <div>
                                <p>Featured</p>
                                <h4>New Season Collection</h4>
                                <a href="/furniture-website/catalog.php?filter=new">Shop Now →</a>
                            </div>
                        </div>
                    </div>
                </li>
                <li><a href="/furniture-website/about.php">About</a></li>
                <li><a href="/furniture-website/contact.php">Contact</a></li>
            </ul>
        </nav>

        <div class="header-actions">
            <button class="action-btn" id="searchToggle" aria-label="Search">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
            </button>

            <?php if (!empty($_SESSION['user'])): ?>
            <div class="account-menu-wrap">
                <button class="action-btn" id="accountToggle" aria-label="Account">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                </button>
                <div class="account-dropdown" id="accountDropdown">
                    <div class="acc-greeting">Hello, <?= htmlspecialchars(explode(' ', $_SESSION['user']['name'])[0]) ?>!</div>
                    <a href="/furniture-website/my-account.php">My Account</a>
                    <?php if (!empty($_SESSION['user']['role']) && $_SESSION['user']['role'] === 'admin'): ?>
                    <a href="/furniture-website/admin/dashboard.php" class="acc-admin-link">&#9881; Admin Panel</a>
                    <?php endif; ?>
                    <a href="/furniture-website/logout.php" class="acc-logout">Sign Out</a>
                </div>
            </div>
            <?php else: ?>
            <a href="/furniture-website/login.php" class="action-btn" aria-label="Login" title="Sign In">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
            </a>
            <?php endif; ?>

            <a href="/furniture-website/cart.php" class="action-btn cart-btn" aria-label="Cart">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>
                <span class="cart-count" id="cartCount"><?php $ct=0; foreach($_SESSION['cart']??[] as $i) $ct+=$i['qty']; echo $ct; ?></span>
            </a>
        </div>
    </div>

    <!-- SEARCH BAR -->
    <div class="search-bar" id="searchBar">
        <div class="search-inner">
            <input type="text" placeholder="Search for furniture, rooms, styles..." id="searchInput" />
            <button class="search-submit">Search</button>
            <button class="search-close" id="searchClose">✕</button>
        </div>
    </div>
</header>

<!-- MOBILE NAV OVERLAY -->
<div class="mobile-overlay" id="mobileOverlay"></div>
