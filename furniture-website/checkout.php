<?php
if (session_status() === PHP_SESSION_NONE) session_start();
define('SITE_NAME', 'MANE FURNITURE');
define('SITE_TAGLINE', 'Premium Furniture');
$page_title = 'Checkout';

define('RAZORPAY_KEY_ID',     'rzp_test_XXXXXXXXXXXXXXXX');
define('RAZORPAY_KEY_SECRET', 'XXXXXXXXXXXXXXXXXXXXXXXX');

if (empty($_SESSION['cart'])) {
    header('Location: /furniture-website/cart.php'); exit;
}

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

$valid_coupons = [
    'MANE10'  =>['type'=>'percent','value'=>10],
    'WELCOME' =>['type'=>'percent','value'=>15],
    'FREESHIP'=>['type'=>'fixed',  'value'=>2500],
    'MANE500' =>['type'=>'fixed',  'value'=>500],
];

$cart_items = []; $subtotal = 0;
foreach ($_SESSION['cart'] as $pid => $item) {
    if (isset($product_db[$pid])) {
        $p = $product_db[$pid];
        $line = $p['price'] * $item['qty'];
        $subtotal += $line;
        $cart_items[] = array_merge($p, ['qty'=>$item['qty'],'line_total'=>$line]);
    }
}

$coupon   = $_SESSION['coupon_code'] ?? '';
$discount = 0;
if ($coupon && isset($valid_coupons[$coupon])) {
    $c = $valid_coupons[$coupon];
    $discount = $c['type']==='percent' ? round($subtotal*$c['value']/100) : min($c['value'],$subtotal);
}
$discounted  = $subtotal - $discount;
$delivery    = ($discounted >= 50000 || $coupon === 'FREESHIP') ? 0 : 2500;
$gst         = round($discounted * 0.18);
$total       = $discounted + $delivery + $gst;
$total_paise = $total * 100;
$user        = $_SESSION['user'] ?? null;

// ── Handle COD / EMI form POST (no JS fetch needed) ────────────────────────
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['place_order'])) {
    $method = $_POST['payment_method'] ?? 'cod';

    // Re-validate shipping fields server-side
    $required = ['ship_first','ship_last','ship_email','ship_phone','ship_addr1','ship_city','ship_state','ship_pin'];
    $missing  = [];
    foreach ($required as $f) {
        if (empty(trim($_POST[$f] ?? ''))) $missing[] = $f;
    }
    if (!empty($missing)) {
        $form_error = 'Please fill in all required shipping fields.';
    } else {
        // Save order to DB
        require_once __DIR__ . '/config/db.php';

        // Recalculate totals server-side
        $sv_subtotal = 0;
        foreach ($_SESSION['cart'] as $pid => $item) {
            if (isset($product_db[$pid])) {
                $sv_subtotal += $product_db[$pid]['price'] * (int)$item['qty'];
            }
        }
        $sv_coupon   = $_SESSION['coupon_code'] ?? '';
        $sv_discount = 0;
        if ($sv_coupon && isset($valid_coupons[$sv_coupon])) {
            $c = $valid_coupons[$sv_coupon];
            $sv_discount = $c['type']==='percent' ? round($sv_subtotal*$c['value']/100) : min($c['value'],$sv_subtotal);
        }
        $sv_disc     = $sv_subtotal - $sv_discount;
        $sv_delivery = ($sv_disc >= 50000 || $sv_coupon === 'FREESHIP') ? 0 : 2500;
        $sv_gst      = round($sv_disc * 0.18);
        $sv_total    = $sv_disc + $sv_delivery + $sv_gst;

        $ship_name = trim($_POST['ship_first']) . ' ' . trim($_POST['ship_last']);

        try {
            $pdo->beginTransaction();

            $stmt = $pdo->prepare("
                INSERT INTO orders
                    (user_id, ship_name, ship_email, ship_phone,
                     ship_addr1, ship_addr2, ship_city, ship_state, ship_pin,
                     coupon_code, discount, subtotal, delivery, gst, total,
                     status, payment_method, order_note, created_at)
                VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,'paid',?,?,NOW())
            ");
            $stmt->execute([
                $user['id'] ?? null,
                $ship_name,
                trim($_POST['ship_email']),
                trim($_POST['ship_phone']),
                trim($_POST['ship_addr1']),
                trim($_POST['ship_addr2'] ?? ''),
                trim($_POST['ship_city']),
                trim($_POST['ship_state']),
                trim($_POST['ship_pin']),
                $sv_coupon ?: null,
                $sv_discount,
                $sv_subtotal,
                $sv_delivery,
                $sv_gst,
                $sv_total,
                $method,
                trim($_POST['order_note'] ?? ''),
            ]);
            $db_order_id  = $pdo->lastInsertId();
            $order_id_str = 'ORD' . str_pad($db_order_id, 6, '0', STR_PAD_LEFT);

            // Save order items
            $iStmt = $pdo->prepare("INSERT INTO order_items (order_id,product_id,product_name,price,qty,line_total) VALUES (?,NULL,?,?,?,?)");
            foreach ($_SESSION['cart'] as $pid => $item) {
                if (isset($product_db[$pid])) {
                    $p = $product_db[$pid];
                    $iStmt->execute([$db_order_id,$p["name"],$p["price"],$item["qty"],$p["price"]*$item["qty"]]);
                }
            }
            $pdo->commit();

            // Clear cart + coupon
            $_SESSION['cart']         = [];
            $_SESSION['coupon_code']  = '';
            $_SESSION['coupon_label'] = '';

            // Redirect to success page
            $city  = urlencode(trim($_POST['ship_city']));
            $state = urlencode(trim($_POST['ship_state']));
            header("Location: /furniture-website/order-success.php?order_id={$order_id_str}&method={$method}&city={$city}&state={$state}");
            exit;

        } catch (Exception $e) {
            if ($pdo->inTransaction()) $pdo->rollBack();
            $form_error = 'Order could not be saved: ' . $e->getMessage() . '. Please try again.';
        }
    }
}

include 'includes/header.php';
?>

<?php if (!empty($form_error)): ?>
<div style="background:#FEE2E2;color:#991B1B;padding:1rem 2rem;text-align:center;font-size:.9rem;border-bottom:1px solid #FCA5A5">
    ⚠ <?= htmlspecialchars($form_error) ?>
</div>
<?php endif; ?>

<section class="page-banner" style="padding:2rem 0">
    <div class="container">
        <div class="breadcrumb">
            <a href="/furniture-website/index.php">Home</a><span>›</span>
            <a href="/furniture-website/cart.php">Cart</a><span>›</span>
            <span>Checkout</span>
        </div>
        <h1>Checkout</h1>
    </div>
</section>

<!-- STEPS -->
<div class="checkout-steps-bar">
    <div class="container">
        <div class="steps">
            <div class="step active" id="s1"><span class="step-num">1</span><span class="step-label">Shipping</span></div>
            <div class="step-line"></div>
            <div class="step" id="s2"><span class="step-num">2</span><span class="step-label">Payment</span></div>
            <div class="step-line"></div>
            <div class="step" id="s3"><span class="step-num">3</span><span class="step-label">Confirm</span></div>
        </div>
    </div>
</div>

<div class="checkout-page">
    <div class="container">
        <div class="checkout-layout">

            <!-- LEFT: FORM -->
            <div class="checkout-form-col">

                <!-- Single form wrapping everything — standard POST -->
                <form method="POST" action="/furniture-website/checkout.php" id="checkoutForm">
                    <input type="hidden" name="place_order" value="1" />
                    <input type="hidden" name="payment_method" id="hidden_pm" value="cod" />

                    <!-- SHIPPING -->
                    <div class="checkout-card" id="shippingSection">
                        <div class="cc-header">
                            <h3>🚚 Shipping Address</h3>
                            <?php if ($user): ?>
                            <span style="font-size:.8rem;color:var(--gold)">Hi <?= htmlspecialchars($user['first_name']) ?> ✓</span>
                            <?php endif; ?>
                        </div>
                        <div class="cc-body">
                            <div class="form-row">
                                <div class="form-group">
                                    <label>First Name *</label>
                                    <input type="text" name="ship_first" id="s_first" required placeholder="Aditya"
                                        value="<?= htmlspecialchars($_POST['ship_first'] ?? $user['first_name'] ?? '') ?>" />
                                </div>
                                <div class="form-group">
                                    <label>Last Name *</label>
                                    <input type="text" name="ship_last" id="s_last" required placeholder="Mane"
                                        value="<?= htmlspecialchars($_POST['ship_last'] ?? explode(' ',$user['name']??'')[1]??'') ?>" />
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group">
                                    <label>Email *</label>
                                    <input type="email" name="ship_email" required placeholder="aditya@example.com"
                                        value="<?= htmlspecialchars($_POST['ship_email'] ?? $user['email'] ?? '') ?>" />
                                </div>
                                <div class="form-group">
                                    <label>Phone *</label>
                                    <input type="tel" name="ship_phone" required placeholder="+91 98765 43210"
                                        value="<?= htmlspecialchars($_POST['ship_phone'] ?? '') ?>" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Address Line 1 *</label>
                                <input type="text" name="ship_addr1" required placeholder="Flat / Building, Street"
                                    value="<?= htmlspecialchars($_POST['ship_addr1'] ?? '') ?>" />
                            </div>
                            <div class="form-group">
                                <label>Address Line 2</label>
                                <input type="text" name="ship_addr2" placeholder="Area, Landmark (optional)"
                                    value="<?= htmlspecialchars($_POST['ship_addr2'] ?? '') ?>" />
                            </div>
                            <div class="form-row form-row-3">
                                <div class="form-group">
                                    <label>City *</label>
                                    <input type="text" name="ship_city" required placeholder="Pune"
                                        value="<?= htmlspecialchars($_POST['ship_city'] ?? '') ?>" />
                                </div>
                                <div class="form-group">
                                    <label>State *</label>
                                    <select name="ship_state" required>
                                        <option value="">Select state…</option>
                                        <?php
                                        $states = ['Andhra Pradesh','Arunachal Pradesh','Assam','Bihar','Chhattisgarh','Goa','Gujarat','Haryana','Himachal Pradesh','Jharkhand','Karnataka','Kerala','Madhya Pradesh','Maharashtra','Manipur','Meghalaya','Mizoram','Nagaland','Odisha','Punjab','Rajasthan','Sikkim','Tamil Nadu','Telangana','Tripura','Uttar Pradesh','Uttarakhand','West Bengal','Delhi','Jammu & Kashmir'];
                                        foreach ($states as $st):
                                            $sel = (($_POST['ship_state'] ?? '') === $st) ? 'selected' : '';
                                        ?>
                                        <option value="<?= $st ?>" <?= $sel ?>><?= $st ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>PIN Code *</label>
                                    <input type="text" name="ship_pin" required placeholder="411001" maxlength="6"
                                        value="<?= htmlspecialchars($_POST['ship_pin'] ?? '') ?>" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Delivery Note</label>
                                <textarea name="order_note" rows="2" placeholder="Call before delivery, leave at door, etc."><?= htmlspecialchars($_POST['order_note'] ?? '') ?></textarea>
                            </div>
                            <button type="button" class="btn btn-primary" style="width:100%;justify-content:center" onclick="proceedToPayment()">
                                Continue to Payment →
                            </button>
                        </div>
                    </div>

                    <!-- PAYMENT -->
                    <div class="checkout-card" id="paymentSection" style="display:none">
                        <div class="cc-header">
                            <h3>💳 Payment Method</h3>
                            <button type="button" class="cc-edit" onclick="editShipping()">← Edit Address</button>
                        </div>
                        <div class="cc-body">
                            <div class="addr-preview" id="addrPreview"></div>

                            <p style="font-size:.78rem;font-weight:500;text-transform:uppercase;letter-spacing:.08em;color:var(--text-mid);margin-bottom:.75rem">Choose Payment Method</p>

                            <div class="pm-list">
                                <div class="pm-opt active" onclick="selectPM('cod',this)">
                                    <input type="radio" name="_pm_display" value="cod" checked style="display:none"/>
                                    <div class="pm-content">
                                        <span class="pm-icon">💵</span>
                                        <div>
                                            <strong>Cash on Delivery</strong>
                                            <p>Pay when your furniture arrives</p>
                                        </div>
                                    </div>
                                    <span class="pm-check">✓</span>
                                </div>
                                <div class="pm-opt" onclick="selectPM('razorpay',this)">
                                    <input type="radio" name="_pm_display" value="razorpay" style="display:none"/>
                                    <div class="pm-content">
                                        <span class="pm-icon">💳</span>
                                        <div>
                                            <strong>Pay Online via Razorpay</strong>
                                            <p>UPI, Cards, Net Banking, Wallets</p>
                                        </div>
                                    </div>
                                    <span class="pm-check">✓</span>
                                </div>
                                <div class="pm-opt" onclick="selectPM('emi',this)">
                                    <input type="radio" name="_pm_display" value="emi" style="display:none"/>
                                    <div class="pm-content">
                                        <span class="pm-icon">📅</span>
                                        <div>
                                            <strong>No-Cost EMI</strong>
                                            <p>3, 6, 9 or 12 month plans</p>
                                        </div>
                                    </div>
                                    <span class="pm-check">✓</span>
                                </div>
                            </div>

                            <label style="display:flex;align-items:center;gap:.5rem;font-size:.83rem;color:var(--text-mid);margin-bottom:1.25rem;cursor:pointer">
                                <input type="checkbox" id="termsCheck" style="accent-color:var(--gold)" />
                                I agree to the <a href="#" style="color:var(--gold)">Terms &amp; Conditions</a>
                            </label>

                            <!-- This button submits the form directly to PHP -->
                            <button type="button" id="payBtn" class="checkout-pay-btn" onclick="submitOrder()">
                                Place Order — ₹<?= number_format($total) ?>
                            </button>
                            <p style="font-size:.73rem;color:var(--text-light);text-align:center;margin-top:.5rem">
                                🔒 Your data is safe · SSL secured
                            </p>
                        </div>
                    </div>
                </form>
            </div>

            <!-- RIGHT: SUMMARY -->
            <aside class="checkout-summary-col">
                <div class="checkout-card">
                    <div class="cc-header"><h3>🧾 Order Summary</h3></div>
                    <div class="cc-body">
                        <?php foreach ($cart_items as $item): ?>
                        <div class="ci-row">
                            <div class="ci-img-wrap">
                                <img src="<?= $item['image'] ?>" alt="<?= $item['name'] ?>" />
                                <span class="ci-qty-badge"><?= $item['qty'] ?></span>
                            </div>
                            <div style="flex:1;font-size:.84rem;color:var(--text-mid)"><?= $item['name'] ?></div>
                            <div style="font-family:var(--font-serif);font-size:.95rem;font-weight:600;color:var(--brown);white-space:nowrap">
                                ₹<?= number_format($item['line_total']) ?>
                            </div>
                        </div>
                        <?php endforeach; ?>

                        <div class="co-summary-lines">
                            <div class="co-line"><span>Subtotal</span><span>₹<?= number_format($subtotal) ?></span></div>
                            <?php if ($discount > 0): ?>
                            <div class="co-line" style="color:#2E7D32"><span>Discount (<?= $coupon ?>)</span><span>−₹<?= number_format($discount) ?></span></div>
                            <?php endif; ?>
                            <div class="co-line">
                                <span>Delivery</span>
                                <span class="<?= $delivery===0?'free-tag':'' ?>"><?= $delivery===0?'FREE':'₹'.number_format($delivery) ?></span>
                            </div>
                            <div class="co-line"><span>GST (18%)</span><span>₹<?= number_format($gst) ?></span></div>
                            <div class="co-total"><span>Total</span><span>₹<?= number_format($total) ?></span></div>
                        </div>

                        <div class="delivery-est-box">
                            <span>📅</span>
                            <div>
                                <strong>Estimated Delivery</strong>
                                <p>7–10 business days · White-glove assembly included</p>
                            </div>
                        </div>
                    </div>
                </div>
            </aside>
        </div>
    </div>
</div>

<style>
.checkout-steps-bar{background:var(--cream);border-bottom:1px solid var(--border);padding:1rem 0}
.steps{display:flex;align-items:center;justify-content:center;max-width:420px;margin:0 auto}
.step{display:flex;align-items:center;gap:.5rem}
.step-num{width:28px;height:28px;border-radius:50%;border:2px solid var(--border);display:flex;align-items:center;justify-content:center;font-size:.75rem;font-weight:600;color:var(--text-light);transition:all .3s}
.step.active .step-num{background:var(--gold);border-color:var(--gold);color:#fff}
.step.done .step-num{background:var(--brown);border-color:var(--brown);color:#fff}
.step-label{font-size:.72rem;font-weight:500;text-transform:uppercase;letter-spacing:.08em;color:var(--text-light)}
.step.active .step-label{color:var(--gold)}
.step-line{flex:1;height:2px;background:var(--border);margin:0 .75rem;min-width:40px}
.checkout-page{padding:2rem 0 5rem}
.checkout-layout{display:grid;grid-template-columns:1fr 380px;gap:2rem;align-items:start}
.checkout-card{background:var(--white);border:1px solid var(--border);border-radius:var(--radius-lg);overflow:hidden;margin-bottom:1.5rem}
.cc-header{display:flex;align-items:center;justify-content:space-between;padding:1.25rem 1.5rem;border-bottom:1px solid var(--border);background:var(--cream)}
.cc-header h3{font-family:var(--font-serif);font-size:1.15rem;font-weight:600;color:var(--brown)}
.cc-edit{font-size:.78rem;color:var(--gold);border:1px solid var(--gold);padding:.25rem .75rem;border-radius:var(--radius);cursor:pointer;background:none;font-family:var(--font-sans);transition:all .2s}
.cc-edit:hover{background:var(--gold);color:#fff}
.cc-body{padding:1.5rem}
.form-row{display:grid;grid-template-columns:1fr 1fr;gap:1rem}
.form-row-3{grid-template-columns:1fr 1fr .8fr}
.form-group{margin-bottom:1rem}
.form-group label{display:block;font-size:.72rem;font-weight:500;text-transform:uppercase;letter-spacing:.06em;color:var(--text-mid);margin-bottom:.4rem}
.form-group input,.form-group select,.form-group textarea{width:100%;padding:.75rem 1rem;border:1.5px solid var(--border);border-radius:var(--radius);font-family:var(--font-sans);font-size:.9rem;background:var(--off-white);outline:none;transition:border-color .2s;resize:vertical;color:var(--text)}
.form-group input:focus,.form-group select:focus,.form-group textarea:focus{border-color:var(--gold);background:#fff}
.addr-preview{background:var(--cream);border-radius:var(--radius);padding:1rem 1.25rem;margin-bottom:1.5rem;font-size:.85rem;color:var(--text-mid);line-height:1.8;border-left:3px solid var(--gold)}
.pm-list{display:flex;flex-direction:column;gap:.6rem;margin-bottom:1.5rem}
.pm-opt{display:flex;align-items:center;justify-content:space-between;padding:1rem 1.1rem;border:1.5px solid var(--border);border-radius:var(--radius);cursor:pointer;transition:all .2s}
.pm-opt.active{border-color:var(--gold);background:#FEF9EE}
.pm-content{display:flex;align-items:center;gap:.75rem;flex:1}
.pm-icon{font-size:1.25rem;flex-shrink:0}
.pm-content strong{display:block;font-size:.88rem;color:var(--brown);font-weight:500}
.pm-content p{font-size:.78rem;color:var(--text-light)}
.pm-check{color:var(--gold);font-size:1rem;display:none}
.pm-opt.active .pm-check{display:block}
.checkout-pay-btn{width:100%;padding:1.1rem;background:var(--gold);color:#fff;border:none;border-radius:var(--radius);font-family:var(--font-sans);font-size:.9rem;font-weight:600;letter-spacing:.1em;text-transform:uppercase;cursor:pointer;transition:all .2s;display:block}
.checkout-pay-btn:hover{background:var(--brown);transform:translateY(-1px)}
.checkout-pay-btn:disabled{background:var(--text-light);cursor:not-allowed;transform:none}
.ci-row{display:flex;align-items:center;gap:.75rem;margin-bottom:1rem;padding-bottom:1rem;border-bottom:1px solid var(--cream-dark)}
.ci-img-wrap{position:relative;flex-shrink:0}
.ci-img-wrap img{width:56px;height:56px;object-fit:cover;border-radius:var(--radius)}
.ci-qty-badge{position:absolute;top:-6px;right:-6px;background:var(--brown);color:#fff;font-size:.65rem;font-weight:600;width:18px;height:18px;border-radius:50%;display:flex;align-items:center;justify-content:center}
.co-summary-lines{margin-top:.5rem}
.co-line{display:flex;justify-content:space-between;font-size:.87rem;color:var(--text-mid);padding:.45rem 0;border-bottom:1px solid var(--cream-dark)}
.free-tag{color:#2E7D32;font-weight:600}
.co-total{display:flex;justify-content:space-between;font-family:var(--font-serif);font-size:1.3rem;font-weight:600;color:var(--brown);padding:.8rem 0 0}
.delivery-est-box{display:flex;align-items:center;gap:.75rem;background:var(--cream);border-radius:var(--radius);padding:.85rem 1rem;margin-top:1rem;font-size:.82rem}
.delivery-est-box>span{font-size:1.3rem;flex-shrink:0}
.delivery-est-box strong{display:block;color:var(--brown);margin-bottom:.15rem}
.delivery-est-box p{color:var(--text-light)}
@media(max-width:900px){.checkout-layout{grid-template-columns:1fr}.form-row-3{grid-template-columns:1fr 1fr}}
@media(max-width:500px){.form-row,.form-row-3{grid-template-columns:1fr}}
</style>

<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
var selectedPM = 'cod';

function selectPM(val, el) {
    selectedPM = val;
    document.getElementById('hidden_pm').value = val;
    document.querySelectorAll('.pm-opt').forEach(function(o){ o.classList.remove('active'); });
    el.classList.add('active');
}

function proceedToPayment() {
    var first = document.getElementById('s_first').value.trim();
    var last  = document.getElementById('s_last').value.trim();
    var email = document.querySelector('[name=ship_email]').value.trim();
    var phone = document.querySelector('[name=ship_phone]').value.trim();
    var addr  = document.querySelector('[name=ship_addr1]').value.trim();
    var city  = document.querySelector('[name=ship_city]').value.trim();
    var state = document.querySelector('[name=ship_state]').value;
    var pin   = document.querySelector('[name=ship_pin]').value.trim();

    if (!first || !last || !email || !phone || !addr || !city || !state || pin.length < 6) {
        alert('Please fill in all required shipping fields correctly.\n\nMake sure PIN code is 6 digits.');
        return;
    }

    document.getElementById('addrPreview').innerHTML =
        '<strong>' + first + ' ' + last + '</strong><br>' +
        addr + '<br>' + city + ', ' + state + '<br>📞 ' + phone;

    document.getElementById('shippingSection').style.display = 'none';
    document.getElementById('paymentSection').style.display  = 'block';
    document.getElementById('s2').classList.add('active');
    window.scrollTo({top: 150, behavior: 'smooth'});
}

function editShipping() {
    document.getElementById('shippingSection').style.display = 'block';
    document.getElementById('paymentSection').style.display  = 'none';
    document.getElementById('s2').classList.remove('active');
}

function submitOrder() {
    if (!document.getElementById('termsCheck').checked) {
        alert('Please agree to the Terms & Conditions.');
        return;
    }

    var btn = document.getElementById('payBtn');

    if (selectedPM === 'razorpay') {
        // Razorpay flow
        btn.textContent = 'Opening payment…';
        btn.disabled = true;
        var options = {
            key:      '<?= RAZORPAY_KEY_ID ?>',
            amount:   <?= $total_paise ?>,
            currency: 'INR',
            name:     'MANE FURNITURE',
            theme:    {color: '#C4942A'},
            prefill: {
                name:    document.getElementById('s_first').value + ' ' + document.getElementById('s_last').value,
                email:   document.querySelector('[name=ship_email]').value,
                contact: document.querySelector('[name=ship_phone]').value,
            },
            handler: function(response) {
                // After Razorpay success, submit form as razorpay
                document.getElementById('hidden_pm').value = 'razorpay';
                document.getElementById('checkoutForm').submit();
            },
            modal: {
                ondismiss: function() {
                    btn.textContent = 'Place Order — ₹<?= number_format($total) ?>';
                    btn.disabled = false;
                }
            }
        };
        var rzp = new Razorpay(options);
        rzp.on('payment.failed', function(r) {
            alert('Payment failed: ' + r.error.description);
            btn.textContent = 'Place Order — ₹<?= number_format($total) ?>';
            btn.disabled = false;
        });
        rzp.open();
        return;
    }

    // COD or EMI: just submit the form
    btn.textContent = 'Placing order…';
    btn.disabled = true;
    document.getElementById('checkoutForm').submit();
}
</script>

<?php include 'includes/footer.php'; ?>
