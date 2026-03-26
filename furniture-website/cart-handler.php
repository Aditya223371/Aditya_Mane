<?php
/**
 * cart-handler.php — handles both AJAX and direct form POST cart actions
 */
if (session_status() === PHP_SESSION_NONE) session_start();

$is_ajax = !empty($_POST['ajax']) || !empty($_GET['ajax']) || 
           (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest');

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

function cartCount(): int {
    $c = 0;
    foreach ($_SESSION['cart'] ?? [] as $item) $c += (int)$item['qty'];
    return $c;
}

$action = $_POST['action'] ?? $_GET['action'] ?? '';

switch ($action) {

    case 'count':
        header('Content-Type: application/json');
        echo json_encode(['success'=>true, 'count'=>cartCount()]);
        exit;

    case 'add':
        $pid   = (int)($_POST['product_id'] ?? $_GET['product_id'] ?? 0);
        $color = htmlspecialchars(trim($_POST['color'] ?? 'Default'));
        $ref   = $_POST['ref'] ?? $_GET['ref'] ?? '/furniture-website/index.php';

        if (isset($product_db[$pid])) {
            if (!isset($_SESSION['cart'][$pid])) {
                $_SESSION['cart'][$pid] = ['qty' => 0, 'color' => $color];
            }
            $_SESSION['cart'][$pid]['qty']++;
        }

        if ($is_ajax) {
            header('Content-Type: application/json');
            echo json_encode(['success'=>true, 'cart_count'=>cartCount()]);
            exit;
        }
        // Non-AJAX: redirect back to referrer page
        header('Location: ' . $ref);
        exit;

    case 'update':
        $pid = (int)($_POST['product_id'] ?? 0);
        $qty = (int)($_POST['qty'] ?? 0);
        if ($qty < 1) unset($_SESSION['cart'][$pid]);
        elseif (isset($_SESSION['cart'][$pid])) $_SESSION['cart'][$pid]['qty'] = min($qty, 10);
        if ($is_ajax) { header('Content-Type: application/json'); echo json_encode(['success'=>true,'cart_count'=>cartCount()]); exit; }
        header('Location: /furniture-website/cart.php'); exit;

    case 'remove':
        $pid = (int)($_POST['product_id'] ?? 0);
        unset($_SESSION['cart'][$pid]);
        if ($is_ajax) { header('Content-Type: application/json'); echo json_encode(['success'=>true,'cart_count'=>cartCount()]); exit; }
        header('Location: /furniture-website/cart.php'); exit;

    case 'clear':
        $_SESSION['cart'] = [];
        if ($is_ajax) { header('Content-Type: application/json'); echo json_encode(['success'=>true,'cart_count'=>0]); exit; }
        header('Location: /furniture-website/cart.php'); exit;

    default:
        header('Content-Type: application/json');
        echo json_encode(['success'=>false,'error'=>'Unknown action','count'=>cartCount()]);
        exit;
}
