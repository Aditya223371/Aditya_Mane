<?php
if (session_status() === PHP_SESSION_NONE) session_start();
define('SITE_NAME', 'MANE FURNITURE');
define('SITE_TAGLINE', 'Premium Furniture');
$page_title = 'Shopping Cart';

$product_db = [
    1  => ['id'=>1,  'name'=>'Aria Lounge Chair',        'price'=>1299, 'category'=>'Living Room', 'image'=>'https://images.unsplash.com/photo-1567538096630-e0c55bd6374c?w=200&q=80'],
    2  => ['id'=>2,  'name'=>'Nordic Oak Bed Frame',     'price'=>2199, 'category'=>'Bedroom',    'image'=>'https://images.unsplash.com/photo-1505693416388-ac5ce068fe85?w=200&q=80'],
    3  => ['id'=>3,  'name'=>'Executive Walnut Desk',    'price'=>1849, 'category'=>'Office',     'image'=>'https://images.unsplash.com/photo-1518455027359-f3f8164ba6bd?w=200&q=80'],
    4  => ['id'=>4,  'name'=>'Terrazzo Dining Table',    'price'=>3499, 'category'=>'Dining',     'image'=>'https://images.unsplash.com/photo-1555041469-a586c61ea9bc?w=200&q=80'],
    5  => ['id'=>5,  'name'=>'Velvet Sofa - Sage',       'price'=>2799, 'category'=>'Living Room', 'image'=>'https://images.unsplash.com/photo-1540574163026-643ea20ade25?w=200&q=80'],
    6  => ['id'=>6,  'name'=>'Garden Teak Lounger',      'price'=>899,  'category'=>'Outdoor',    'image'=>'https://images.unsplash.com/photo-1600210492493-0946911123ea?w=200&q=80'],
    7  => ['id'=>7,  'name'=>'Marble Console Table',     'price'=>1499, 'category'=>'Living Room', 'image'=>'https://images.unsplash.com/photo-1493663284031-b7e3aefcae8e?w=200&q=80'],
    8  => ['id'=>8,  'name'=>'Linen Platform Bed',       'price'=>1899, 'category'=>'Bedroom',    'image'=>'https://images.unsplash.com/photo-1522771739844-6a9f6d5f14af?w=200&q=80'],
    9  => ['id'=>9,  'name'=>'Ergonomic Study Chair',    'price'=>699,  'category'=>'Office',     'image'=>'https://images.unsplash.com/photo-1596079890701-dd42edf4a7e0?w=200&q=80'],
    10 => ['id'=>10, 'name'=>'Rattan Accent Chair',      'price'=>549,  'category'=>'Outdoor',    'image'=>'https://images.unsplash.com/photo-1586023492125-27b2c045efd7?w=200&q=80'],
    11 => ['id'=>11, 'name'=>'Herringbone Bookcase',     'price'=>1149, 'category'=>'Living Room', 'image'=>'https://images.unsplash.com/photo-1583847268964-b28dc8f51f92?w=200&q=80'],
    12 => ['id'=>12, 'name'=>'Stone Dining Bench',       'price'=>799,  'category'=>'Dining',     'image'=>'https://images.unsplash.com/photo-1616486338812-3dadae4b4ace?w=200&q=80'],
    13 => ['id'=>13, 'name'=>'Velvet Accent Chair',      'price'=>899,  'category'=>'Living Room', 'image'=>'https://images.unsplash.com/photo-1598300042247-d088f8ab3a91?w=200&q=80'],
    14 => ['id'=>14, 'name'=>'Linen 2-Seater Sofa',      'price'=>1999, 'category'=>'Living Room', 'image'=>'https://images.unsplash.com/photo-1555041469-a586c61ea9bc?w=200&q=80'],
    15 => ['id'=>15, 'name'=>'Rattan Coffee Table',      'price'=>849,  'category'=>'Living Room', 'image'=>'https://images.unsplash.com/photo-1499933374294-4584851b32e3?w=200&q=80'],
    16 => ['id'=>16, 'name'=>'Wooden Wall Shelf Set',    'price'=>399,  'category'=>'Living Room', 'image'=>'https://images.unsplash.com/photo-1618220179428-22790b461013?w=200&q=80'],
    17 => ['id'=>17, 'name'=>'Brass Floor Lamp',         'price'=>649,  'category'=>'Living Room', 'image'=>'https://images.unsplash.com/photo-1507473885765-e6ed057f782c?w=200&q=80'],
    18 => ['id'=>18, 'name'=>'Walnut TV Media Unit',     'price'=>1899, 'category'=>'Living Room', 'image'=>'https://images.unsplash.com/photo-1593030761757-71fae45fa0e7?w=200&q=80'],
    19 => ['id'=>19, 'name'=>'Leather Chesterfield Sofa','price'=>5499, 'category'=>'Living Room', 'image'=>'https://images.unsplash.com/photo-1571898223751-76b611d2b99c?w=200&q=80'],
    20 => ['id'=>20, 'name'=>'Ottoman Footstool',        'price'=>449,  'category'=>'Living Room', 'image'=>'https://images.unsplash.com/photo-1617325247661-675ab4b64ae2?w=200&q=80'],
    21 => ['id'=>21, 'name'=>'Cane Back Armchair',       'price'=>799,  'category'=>'Living Room', 'image'=>'https://images.unsplash.com/photo-1506439773649-6e0eb8cfb237?w=200&q=80'],
    22 => ['id'=>22, 'name'=>'Modular Sectional Sofa',   'price'=>4999, 'category'=>'Living Room', 'image'=>'https://images.unsplash.com/photo-1540574163026-643ea20ade25?w=200&q=80'],
    23 => ['id'=>23, 'name'=>'Teak Root Coffee Table',   'price'=>2299, 'category'=>'Living Room', 'image'=>'https://images.unsplash.com/photo-1567538096630-e0c55bd6374c?w=200&q=80'],
    24 => ['id'=>24, 'name'=>'Ceramic Table Lamp Set',   'price'=>699,  'category'=>'Living Room', 'image'=>'https://images.unsplash.com/photo-1513506003901-1e6a35294aa5?w=200&q=80'],
    25 => ['id'=>25, 'name'=>'Walnut Bedside Table',     'price'=>599,  'category'=>'Bedroom',    'image'=>'https://images.unsplash.com/photo-1505693416388-ac5ce068fe85?w=200&q=80'],
    26 => ['id'=>26, 'name'=>'King Size Wardrobe',       'price'=>5499, 'category'=>'Bedroom',    'image'=>'https://images.unsplash.com/photo-1558618047-3c8c76ca7d13?w=200&q=80'],
    27 => ['id'=>27, 'name'=>'Chest of Drawers',         'price'=>1399, 'category'=>'Bedroom',    'image'=>'https://images.unsplash.com/photo-1549497538-303791108f95?w=200&q=80'],
    28 => ['id'=>28, 'name'=>'Dressing Table and Mirror','price'=>1699, 'category'=>'Bedroom',    'image'=>'https://images.unsplash.com/photo-1616594039964-ae9021a400a0?w=200&q=80'],
    29 => ['id'=>29, 'name'=>'Upholstered Headboard',   'price'=>849,  'category'=>'Bedroom',    'image'=>'https://images.unsplash.com/photo-1631049307264-da0ec9d70304?w=200&q=80'],
    30 => ['id'=>30, 'name'=>'Four Poster Bed Frame',   'price'=>4299, 'category'=>'Bedroom',    'image'=>'https://images.unsplash.com/photo-1614148680759-4b99af7c3c14?w=200&q=80'],
    31 => ['id'=>31, 'name'=>'Bedroom Bench Velvet',    'price'=>749,  'category'=>'Bedroom',    'image'=>'https://images.unsplash.com/photo-1588046130717-0eb0c9a3ba15?w=200&q=80'],
    32 => ['id'=>32, 'name'=>'Loft Bunk Bed',           'price'=>2499, 'category'=>'Bedroom',    'image'=>'https://images.unsplash.com/photo-1595526114035-0d45ed16cfbf?w=200&q=80'],
    33 => ['id'=>33, 'name'=>'Wooden Blanket Ladder',   'price'=>299,  'category'=>'Bedroom',    'image'=>'https://images.unsplash.com/photo-1515488764276-beab7607c1e6?w=200&q=80'],
    34 => ['id'=>34, 'name'=>'Standing Desk Oak',       'price'=>2499, 'category'=>'Office',     'image'=>'https://images.unsplash.com/photo-1593642632559-0c6d3fc62b89?w=200&q=80'],
    35 => ['id'=>35, 'name'=>'Leather Executive Chair', 'price'=>1499, 'category'=>'Office',     'image'=>'https://images.unsplash.com/photo-1589364222378-4e328e90caaa?w=200&q=80'],
    36 => ['id'=>36, 'name'=>'L-Shape Corner Desk',     'price'=>1699, 'category'=>'Office',     'image'=>'https://images.unsplash.com/photo-1593642702821-c8da6771f0c6?w=200&q=80'],
    37 => ['id'=>37, 'name'=>'Monitor Riser Oak',       'price'=>449,  'category'=>'Office',     'image'=>'https://images.unsplash.com/photo-1547394765-185e1e68f34e?w=200&q=80'],
    38 => ['id'=>38, 'name'=>'Filing Cabinet 3 Drawer', 'price'=>799,  'category'=>'Office',     'image'=>'https://images.unsplash.com/photo-1586281380349-632531db7ed4?w=200&q=80'],
    39 => ['id'=>39, 'name'=>'Office Bookshelf',        'price'=>999,  'category'=>'Office',     'image'=>'https://images.unsplash.com/photo-1526040652367-ac003a0475fe?w=200&q=80'],
    40 => ['id'=>40, 'name'=>'Architect Desk Lamp',     'price'=>599,  'category'=>'Office',     'image'=>'https://images.unsplash.com/photo-1593078166039-c9878df5c520?w=200&q=80'],
    41 => ['id'=>41, 'name'=>'Hammock with Stand',      'price'=>1299, 'category'=>'Outdoor',    'image'=>'https://images.unsplash.com/photo-1520531158340-44015069e78e?w=200&q=80'],
    42 => ['id'=>42, 'name'=>'Outdoor Sofa Set 5pc',    'price'=>5999, 'category'=>'Outdoor',    'image'=>'https://images.unsplash.com/photo-1600585154526-990dced4db0d?w=200&q=80'],
    43 => ['id'=>43, 'name'=>'Garden Bistro Set',       'price'=>799,  'category'=>'Outdoor',    'image'=>'https://images.unsplash.com/photo-1533090481720-856c6e3c1fdc?w=200&q=80'],
    44 => ['id'=>44, 'name'=>'Garden Swing Chair',      'price'=>1499, 'category'=>'Outdoor',    'image'=>'https://images.unsplash.com/photo-1591988575840-4d0c7c78b42e?w=200&q=80'],
    45 => ['id'=>45, 'name'=>'Teak Outdoor Dining Set', 'price'=>4299, 'category'=>'Outdoor',    'image'=>'https://images.unsplash.com/photo-1600210492493-0946911123ea?w=200&q=80'],
    46 => ['id'=>46, 'name'=>'Folding Teak Chair',      'price'=>449,  'category'=>'Outdoor',    'image'=>'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=200&q=80'],
    47 => ['id'=>47, 'name'=>'Round Oak Dining Table',  'price'=>2199, 'category'=>'Dining',     'image'=>'https://images.unsplash.com/photo-1617806118233-18e1de247200?w=200&q=80'],
    48 => ['id'=>48, 'name'=>'Wishbone Dining Chair',   'price'=>499,  'category'=>'Dining',     'image'=>'https://images.unsplash.com/photo-1592078615290-033ee584e267?w=200&q=80'],
    49 => ['id'=>49, 'name'=>'Extendable Dining Table', 'price'=>2799, 'category'=>'Dining',     'image'=>'https://images.unsplash.com/photo-1549497538-303791108f95?w=200&q=80'],
    50 => ['id'=>50, 'name'=>'Marble Dining Table',     'price'=>4999, 'category'=>'Dining',     'image'=>'https://images.unsplash.com/photo-1560448075-cbc16bb4af8e?w=200&q=80'],
    51 => ['id'=>51, 'name'=>'Dining Sideboard',        'price'=>1999, 'category'=>'Dining',     'image'=>'https://images.unsplash.com/photo-1555041469-a586c61ea9bc?w=200&q=80'],
    52 => ['id'=>52, 'name'=>'Bar Height Stools Set 2', 'price'=>899,  'category'=>'Dining',     'image'=>'https://images.unsplash.com/photo-1581539250439-c96689b516dd?w=200&q=80'],
];

// Valid coupons
$valid_coupons = [
    'MANE10'    => ['type'=>'percent','value'=>10,  'label'=>'10% off'],
    'WELCOME'   => ['type'=>'percent','value'=>15,  'label'=>'15% off'],
    'FREESHIP'  => ['type'=>'fixed',  'value'=>2500,'label'=>'Free Delivery'],
    'MANE500'   => ['type'=>'fixed',  'value'=>500, 'label'=>'₹500 off'],
    'SAVE20'    => ['type'=>'percent','value'=>20,  'label'=>'20% off'],
];

// Handle coupon apply via POST
$coupon_msg   = '';
$coupon_type  = ''; // success or error
$coupon_code  = $_SESSION['coupon_code']  ?? '';
$coupon_label = $_SESSION['coupon_label'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['apply_coupon'])) {
    $code = strtoupper(trim($_POST['coupon_code'] ?? ''));
    if (isset($valid_coupons[$code])) {
        $_SESSION['coupon_code']  = $code;
        $_SESSION['coupon_label'] = $valid_coupons[$code]['label'];
        $coupon_code  = $code;
        $coupon_label = $valid_coupons[$code]['label'];
        $coupon_msg   = '✓ Coupon applied: ' . $valid_coupons[$code]['label'];
        $coupon_type  = 'success';
    } else {
        unset($_SESSION['coupon_code'], $_SESSION['coupon_label']);
        $coupon_code  = '';
        $coupon_label = '';
        $coupon_msg   = '✗ Invalid coupon code. Try MANE10 for 10% off.';
        $coupon_type  = 'error';
    }
    header('Location: cart.php'); exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['remove_coupon'])) {
    unset($_SESSION['coupon_code'], $_SESSION['coupon_label']);
    header('Location: cart.php'); exit;
}

// Handle cart item actions (update / remove / clear)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $action     = $_POST['action'];
    $product_id = (int)($_POST['product_id'] ?? 0);
    if ($action === 'update') {
        $qty = (int)$_POST['qty'];
        if ($qty < 1) unset($_SESSION['cart'][$product_id]);
        else $_SESSION['cart'][$product_id]['qty'] = min($qty, 10);
    } elseif ($action === 'remove') {
        unset($_SESSION['cart'][$product_id]);
    } elseif ($action === 'clear') {
        $_SESSION['cart'] = [];
        unset($_SESSION['coupon_code'], $_SESSION['coupon_label']);
    }
    header('Location: cart.php'); exit;
}

// Build cart items
$cart_items = [];
$subtotal   = 0;
foreach ($_SESSION['cart'] ?? [] as $pid => $item) {
    if (isset($product_db[$pid])) {
        $p          = $product_db[$pid];
        $line_total = $p['price'] * $item['qty'];
        $subtotal  += $line_total;
        $cart_items[] = array_merge($p, ['qty'=>$item['qty'],'color'=>$item['color']??'Default','line_total'=>$line_total]);
    }
}

// Calculate discount
$discount = 0;
if ($coupon_code && isset($valid_coupons[$coupon_code])) {
    $c = $valid_coupons[$coupon_code];
    if ($c['type'] === 'percent') {
        $discount = round($subtotal * $c['value'] / 100);
    } else {
        $discount = min($c['value'], $subtotal);
    }
}

$discounted_subtotal = $subtotal - $discount;
$delivery = ($discounted_subtotal >= 50000 || ($coupon_code === 'FREESHIP')) ? 0 : 2500;
$gst      = round($discounted_subtotal * 0.18);
$total    = $discounted_subtotal + $delivery + $gst;

include 'includes/header.php';
?>

<section class="page-banner">
    <div class="container">
        <div class="breadcrumb"><a href="/furniture-website/index.php">Home</a><span>›</span><span>Cart</span></div>
        <h1>Your Cart</h1>
        <p><?= count($cart_items) > 0 ? count($cart_items).' item'.(count($cart_items)>1?'s':'').' in your cart' : 'Your cart is empty' ?></p>
    </div>
</section>

<div class="cart-page">
    <div class="container">
        <?php if (empty($cart_items)): ?>
        <div class="empty-cart">
            <div class="empty-icon">🛍️</div>
            <h2>Your cart is empty</h2>
            <p>Looks like you haven't added any pieces yet. Explore our curated collection.</p>
            <a href="/furniture-website/catalog.php" class="btn btn-primary">Browse Collection</a>
        </div>
        <?php else: ?>

        <div class="cart-layout">
            <!-- CART ITEMS -->
            <div class="cart-items">
                <div class="cart-header-row">
                    <span>Product</span><span>Price</span><span>Qty</span><span>Total</span><span></span>
                </div>

                <?php foreach ($cart_items as $item): ?>
                <div class="cart-item">
                    <div class="item-product">
                        <img src="<?= $item['image'] ?>" alt="<?= $item['name'] ?>" />
                        <div class="item-details">
                            <p class="item-cat"><?= $item['category'] ?></p>
                            <h3><?= $item['name'] ?></h3>
                            <p class="item-color">Colour: <?= $item['color'] ?></p>
                        </div>
                    </div>
                    <div class="item-price">₹<?= number_format($item['price']) ?></div>
                    <div class="item-qty">
                        <form method="POST">
                            <input type="hidden" name="action" value="update" />
                            <input type="hidden" name="product_id" value="<?= $item['id'] ?>" />
                            <div class="qty-ctrl">
                                <button type="submit" name="qty" value="<?= max(1,$item['qty']-1) ?>">−</button>
                                <span><?= $item['qty'] ?></span>
                                <button type="submit" name="qty" value="<?= min(10,$item['qty']+1) ?>">+</button>
                            </div>
                        </form>
                    </div>
                    <div class="item-total">₹<?= number_format($item['line_total']) ?></div>
                    <div class="item-remove">
                        <form method="POST">
                            <input type="hidden" name="action" value="remove" />
                            <input type="hidden" name="product_id" value="<?= $item['id'] ?>" />
                            <button type="submit" class="remove-btn" title="Remove">✕</button>
                        </form>
                    </div>
                </div>
                <?php endforeach; ?>

                <div class="cart-footer-row">
                    <a href="/furniture-website/catalog.php" class="btn-continue">← Continue Shopping</a>
                    <form method="POST" style="display:inline">
                        <input type="hidden" name="action" value="clear" />
                        <button type="submit" class="btn-clear" onclick="return confirm('Clear entire cart?')">Clear Cart</button>
                    </form>
                </div>
            </div>

            <!-- ORDER SUMMARY -->
            <aside class="order-summary">
                <h3>Order Summary</h3>

                <div class="summary-lines">
                    <div class="sum-line"><span>Subtotal (<?= count($cart_items) ?> items)</span><span>₹<?= number_format($subtotal) ?></span></div>

                    <?php if ($discount > 0): ?>
                    <div class="sum-line discount-line">
                        <span>Discount (<?= $coupon_code ?>)</span>
                        <span class="discount-val">−₹<?= number_format($discount) ?></span>
                    </div>
                    <?php endif; ?>

                    <div class="sum-line">
                        <span>Delivery</span>
                        <span class="<?= $delivery === 0 ? 'free-tag' : '' ?>"><?= $delivery === 0 ? 'FREE ✓' : '₹'.number_format($delivery) ?></span>
                    </div>
                    <div class="sum-line"><span>GST (18%)</span><span>₹<?= number_format($gst) ?></span></div>

                    <?php if ($delivery > 0 && $coupon_code !== 'FREESHIP'): ?>
                    <div class="free-ship-note">
                        Add ₹<?= number_format(50000 - $discounted_subtotal) ?> more for free delivery
                        <div class="ship-progress"><div class="ship-bar" style="width:<?= min(100,round($discounted_subtotal/500)) ?>%"></div></div>
                    </div>
                    <?php endif; ?>

                    <div class="sum-total">
                        <span>Total</span>
                        <span>₹<?= number_format($total) ?></span>
                    </div>
                </div>

                <!-- COUPON BOX -->
                <?php if ($coupon_code): ?>
                <div class="coupon-applied">
                    <span>🏷️ <strong><?= $coupon_code ?></strong> — <?= $coupon_label ?></span>
                    <form method="POST" style="display:inline">
                        <button type="submit" name="remove_coupon" value="1" class="coupon-remove">✕ Remove</button>
                    </form>
                </div>
                <?php else: ?>
                <form method="POST" class="coupon-form">
                    <input type="text" name="coupon_code" placeholder="Coupon code"
                           value="<?= htmlspecialchars($_POST['coupon_code'] ?? '') ?>" required />
                    <button type="submit" name="apply_coupon" value="1">Apply</button>
                </form>
                <p class="coupon-hint">Try: <strong>MANE10</strong> · <strong>WELCOME</strong> · <strong>FREESHIP</strong></p>
                <?php endif; ?>

                <?php if (isset($_GET['coupon_msg'])): ?>
                <div class="coupon-msg <?= $_GET['coupon_type'] ?? '' ?>">
                    <?= htmlspecialchars(urldecode($_GET['coupon_msg'])) ?>
                </div>
                <?php endif; ?>

                <a href="/furniture-website/checkout.php" class="checkout-btn">
                    PROCEED TO CHECKOUT →
                </a>

                <div class="secure-badge">
                    <span>🔒</span>
                    <p>Secure checkout with 256-bit SSL encryption</p>
                </div>

                <div class="payment-methods">
                    <p>We accept:</p>
                    <div class="pm-icons">
                        <span>💳 Visa</span><span>💳 Mastercard</span><span>📱 UPI</span><span>🏦 NetBanking</span><span>📦 EMI</span>
                    </div>
                </div>

                <div class="delivery-promise">
                    <div class="dp-item"><span>🚚</span><div><strong>White-Glove Delivery</strong><p>Assembly included</p></div></div>
                    <div class="dp-item"><span>↩️</span><div><strong>30-Day Returns</strong><p>Hassle-free policy</p></div></div>
                    <div class="dp-item"><span>🛡️</span><div><strong>10-Year Warranty</strong><p>On all pieces</p></div></div>
                </div>
            </aside>
        </div>

        <!-- RELATED PRODUCTS -->
        <section class="related-section">
            <div class="section-header">
                <div>
                    <p class="section-eyebrow">Complete Your Space</p>
                    <h2 class="section-title">You May Also Like</h2>
                </div>
                <a href="/furniture-website/catalog.php" class="section-link">View All →</a>
            </div>
            <div class="related-grid">
                <?php foreach (array_slice($product_db, 0, 4) as $p): ?>
                <div class="product-card">
                    <div class="product-img-wrap">
                        <img src="<?= $p['image'] ?>" alt="<?= $p['name'] ?>" loading="lazy" />
                    </div>
                    <div class="product-info">
                        <p class="product-category"><?= $p['category'] ?></p>
                        <h3 class="product-name"><a href="/furniture-website/product.php?id=<?= $p['id'] ?>"><?= $p['name'] ?></a></h3>
                        <div class="product-price"><span class="price-current">₹<?= number_format($p['price']) ?></span></div>
                        <form method="POST" action="/furniture-website/cart-handler.php">
                            <input type="hidden" name="action" value="add" />
                            <input type="hidden" name="product_id" value="<?= $p['id'] ?>" />
                            <input type="hidden" name="ref" value="/furniture-website/cart.php" />
                            <button type="submit" class="btn btn-add-cart">Add to Cart</button>
                        </form>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </section>
        <?php endif; ?>
    </div>
</div>

<style>
.cart-page{padding:2rem 0 5rem}
.empty-cart{text-align:center;padding:5rem 2rem}
.empty-icon{font-size:4rem;margin-bottom:1.5rem}
.empty-cart h2{font-family:var(--font-serif);font-size:2rem;color:var(--brown);margin-bottom:.75rem}
.empty-cart p{color:var(--text-light);margin-bottom:2rem}
.cart-layout{display:grid;grid-template-columns:1fr 360px;gap:3rem;align-items:start;margin-bottom:4rem}
.cart-header-row{display:grid;grid-template-columns:3fr 1fr 1.2fr 1fr 40px;gap:1rem;padding:.75rem 1rem;background:var(--cream);border-radius:var(--radius);font-size:.72rem;font-weight:500;letter-spacing:.08em;text-transform:uppercase;color:var(--text-light);margin-bottom:.5rem}
.cart-item{display:grid;grid-template-columns:3fr 1fr 1.2fr 1fr 40px;gap:1rem;align-items:center;padding:1.25rem 1rem;background:var(--white);border-radius:var(--radius-lg);border:1px solid var(--border);margin-bottom:.75rem;transition:box-shadow var(--transition)}
.cart-item:hover{box-shadow:var(--shadow)}
.item-product{display:flex;align-items:center;gap:1rem}
.item-product img{width:80px;height:80px;object-fit:cover;border-radius:var(--radius);flex-shrink:0}
.item-cat{font-size:.68rem;font-weight:500;letter-spacing:.1em;text-transform:uppercase;color:var(--gold);margin-bottom:.2rem}
.item-details h3{font-family:var(--font-serif);font-size:1rem;font-weight:600;color:var(--brown);margin-bottom:.2rem}
.item-color{font-size:.78rem;color:var(--text-light)}
.item-price,.item-total{font-family:var(--font-serif);font-size:1.05rem;font-weight:600;color:var(--brown)}
.qty-ctrl{display:flex;align-items:center;border:1.5px solid var(--border);border-radius:var(--radius);width:fit-content;overflow:hidden}
.qty-ctrl button{width:30px;height:34px;font-size:1.1rem;color:var(--text-mid);transition:all var(--transition);background:none;border:none;cursor:pointer;font-family:var(--font-sans)}
.qty-ctrl button:hover{background:var(--cream);color:var(--gold)}
.qty-ctrl span{width:36px;text-align:center;font-size:.9rem;font-family:var(--font-sans)}
.remove-btn{width:32px;height:32px;border-radius:50%;border:1px solid var(--border);color:var(--text-light);font-size:.75rem;display:flex;align-items:center;justify-content:center;transition:all var(--transition);cursor:pointer;background:none}
.remove-btn:hover{background:#FEE;border-color:#E05252;color:#E05252}
.cart-footer-row{display:flex;justify-content:space-between;align-items:center;padding:1rem 0}
.btn-continue{font-size:.8rem;color:var(--gold);font-weight:500}
.btn-clear{font-size:.8rem;color:var(--text-light);background:none;border:1px solid var(--border);border-radius:var(--radius);padding:.4rem .9rem;cursor:pointer;transition:all var(--transition);font-family:var(--font-sans)}
.btn-clear:hover{border-color:#E05252;color:#E05252}
/* Summary */
.order-summary{background:var(--white);border-radius:var(--radius-lg);padding:2rem;border:1px solid var(--border);position:sticky;top:90px;box-shadow:var(--shadow)}
.order-summary h3{font-family:var(--font-serif);font-size:1.4rem;font-weight:600;color:var(--brown);margin-bottom:1.5rem;padding-bottom:1rem;border-bottom:1px solid var(--border)}
.summary-lines{margin-bottom:1.25rem}
.sum-line{display:flex;justify-content:space-between;font-size:.88rem;color:var(--text-mid);padding:.5rem 0;border-bottom:1px solid var(--cream-dark)}
.discount-line{color:#2E7D32}
.discount-val{font-weight:600;color:#2E7D32}
.free-tag{color:#2E7D32;font-weight:600}
.free-ship-note{font-size:.78rem;color:var(--gold);margin:.5rem 0}
.ship-progress{background:var(--cream-dark);border-radius:20px;height:4px;margin-top:.35rem;overflow:hidden}
.ship-bar{height:100%;background:var(--gold);border-radius:20px;transition:width .5s}
.sum-total{display:flex;justify-content:space-between;font-family:var(--font-serif);font-size:1.35rem;font-weight:600;color:var(--brown);padding:.85rem 0 0}
/* Coupon */
.coupon-applied{display:flex;align-items:center;justify-content:space-between;background:#D1FAE5;border:1px solid #6EE7B7;border-radius:var(--radius);padding:.75rem 1rem;margin:1.25rem 0 .5rem;font-size:.84rem;color:#065F46}
.coupon-remove{background:none;border:none;color:#065F46;cursor:pointer;font-size:.8rem;font-family:var(--font-sans);font-weight:500;opacity:.7;transition:opacity .2s}
.coupon-remove:hover{opacity:1}
.coupon-form{display:flex;gap:.5rem;margin:1.25rem 0 .35rem}
.coupon-form input{flex:1;padding:.65rem 1rem;border:1.5px solid var(--border);border-radius:var(--radius);font-family:var(--font-sans);font-size:.85rem;outline:none;transition:border-color var(--transition)}
.coupon-form input:focus{border-color:var(--gold)}
.coupon-form button{padding:.65rem 1rem;background:var(--cream);border:1.5px solid var(--border);border-radius:var(--radius);font-size:.8rem;font-weight:500;cursor:pointer;font-family:var(--font-sans);transition:all var(--transition);color:var(--text-mid)}
.coupon-form button:hover{background:var(--gold);color:var(--white);border-color:var(--gold)}
.coupon-hint{font-size:.75rem;color:var(--text-light);margin-bottom:.5rem}
.checkout-btn{display:block;width:100%;padding:1rem;background:var(--gold);color:var(--white);text-align:center;font-family:var(--font-sans);font-size:.85rem;font-weight:600;letter-spacing:.12em;text-transform:uppercase;border-radius:var(--radius);margin:1.25rem 0 1rem;transition:all var(--transition)}
.checkout-btn:hover{background:var(--brown);transform:translateY(-1px)}
.secure-badge{display:flex;align-items:center;gap:.75rem;background:var(--cream);border-radius:var(--radius);padding:.75rem;margin-bottom:1rem}
.secure-badge>span{font-size:1.1rem;flex-shrink:0}
.secure-badge p{font-size:.75rem;color:var(--text-light);line-height:1.4}
.payment-methods p{font-size:.72rem;text-transform:uppercase;letter-spacing:.1em;color:var(--text-light);margin-bottom:.5rem}
.pm-icons{display:flex;flex-wrap:wrap;gap:.4rem;margin-bottom:1.25rem}
.pm-icons span{font-size:.7rem;padding:.25rem .5rem;border:1px solid var(--border);border-radius:var(--radius);color:var(--text-mid)}
.delivery-promise{border-top:1px solid var(--border);padding-top:1rem;display:flex;flex-direction:column;gap:.75rem}
.dp-item{display:flex;align-items:center;gap:.75rem}
.dp-item>span{font-size:1.2rem;flex-shrink:0}
.dp-item strong{display:block;font-size:.82rem;color:var(--brown)}
.dp-item p{font-size:.75rem;color:var(--text-light)}
.related-section{border-top:1px solid var(--border);padding-top:3rem}
.related-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:1.5rem;margin-top:2rem}
@media(max-width:1000px){.cart-layout{grid-template-columns:1fr}.order-summary{position:static}}
@media(max-width:700px){.cart-header-row{display:none}.cart-item{grid-template-columns:1fr 40px}.item-price{display:none}.related-grid{grid-template-columns:repeat(2,1fr)}}
</style>

<?php include 'includes/footer.php'; ?>
