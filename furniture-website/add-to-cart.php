<?php
/**
 * add-to-cart.php — handles Add to Cart for ALL 52 products
 */
if (session_status() === PHP_SESSION_NONE) session_start();

$product_db = [
    1  => ['id'=>1,  'name'=>'Aria Lounge Chair',        'price'=>1299],
    2  => ['id'=>2,  'name'=>'Nordic Oak Bed Frame',      'price'=>2199],
    3  => ['id'=>3,  'name'=>'Executive Walnut Desk',     'price'=>1849],
    4  => ['id'=>4,  'name'=>'Terrazzo Dining Table',     'price'=>3499],
    5  => ['id'=>5,  'name'=>'Velvet Sofa - Sage',        'price'=>2799],
    6  => ['id'=>6,  'name'=>'Garden Teak Lounger',       'price'=>899],
    7  => ['id'=>7,  'name'=>'Marble Console Table',      'price'=>1499],
    8  => ['id'=>8,  'name'=>'Linen Platform Bed',        'price'=>1899],
    9  => ['id'=>9,  'name'=>'Ergonomic Study Chair',     'price'=>699],
    10 => ['id'=>10, 'name'=>'Rattan Accent Chair',       'price'=>549],
    11 => ['id'=>11, 'name'=>'Herringbone Bookcase',      'price'=>1149],
    12 => ['id'=>12, 'name'=>'Stone Dining Bench',        'price'=>799],
    // Living Room extras
    13 => ['id'=>13, 'name'=>'Velvet Accent Chair',       'price'=>899],
    14 => ['id'=>14, 'name'=>'Linen 2-Seater Sofa',       'price'=>1999],
    15 => ['id'=>15, 'name'=>'Rattan Coffee Table',       'price'=>849],
    16 => ['id'=>16, 'name'=>'Wooden Wall Shelf Set',     'price'=>399],
    17 => ['id'=>17, 'name'=>'Brass Floor Lamp',          'price'=>649],
    18 => ['id'=>18, 'name'=>'Walnut TV Media Unit',      'price'=>1899],
    19 => ['id'=>19, 'name'=>'Leather Chesterfield Sofa', 'price'=>5499],
    20 => ['id'=>20, 'name'=>'Ottoman Footstool',         'price'=>449],
    21 => ['id'=>21, 'name'=>'Cane Back Armchair',        'price'=>799],
    22 => ['id'=>22, 'name'=>'Modular Sectional Sofa',    'price'=>4999],
    23 => ['id'=>23, 'name'=>'Teak Root Coffee Table',    'price'=>2299],
    24 => ['id'=>24, 'name'=>'Ceramic Table Lamp Set',    'price'=>699],
    // Bedroom
    25 => ['id'=>25, 'name'=>'Walnut Bedside Table',      'price'=>599],
    26 => ['id'=>26, 'name'=>'King Size Wardrobe',        'price'=>5499],
    27 => ['id'=>27, 'name'=>'Chest of Drawers',          'price'=>1399],
    28 => ['id'=>28, 'name'=>'Dressing Table and Mirror', 'price'=>1699],
    29 => ['id'=>29, 'name'=>'Upholstered Headboard',     'price'=>849],
    30 => ['id'=>30, 'name'=>'Four Poster Bed Frame',     'price'=>4299],
    31 => ['id'=>31, 'name'=>'Bedroom Bench Velvet',      'price'=>749],
    32 => ['id'=>32, 'name'=>'Loft Bunk Bed',             'price'=>2499],
    33 => ['id'=>33, 'name'=>'Wooden Blanket Ladder',     'price'=>299],
    // Office
    34 => ['id'=>34, 'name'=>'Standing Desk Oak',         'price'=>2499],
    35 => ['id'=>35, 'name'=>'Leather Executive Chair',   'price'=>1499],
    36 => ['id'=>36, 'name'=>'L-Shape Corner Desk',       'price'=>1699],
    37 => ['id'=>37, 'name'=>'Monitor Riser Oak',         'price'=>449],
    38 => ['id'=>38, 'name'=>'Filing Cabinet 3 Drawer',   'price'=>799],
    39 => ['id'=>39, 'name'=>'Office Bookshelf',          'price'=>999],
    40 => ['id'=>40, 'name'=>'Architect Desk Lamp',       'price'=>599],
    // Outdoor
    41 => ['id'=>41, 'name'=>'Hammock with Stand',        'price'=>1299],
    42 => ['id'=>42, 'name'=>'Outdoor Sofa Set 5pc',      'price'=>5999],
    43 => ['id'=>43, 'name'=>'Garden Bistro Set',         'price'=>799],
    44 => ['id'=>44, 'name'=>'Garden Swing Chair',        'price'=>1499],
    45 => ['id'=>45, 'name'=>'Teak Outdoor Dining Set',   'price'=>4299],
    46 => ['id'=>46, 'name'=>'Folding Teak Chair',        'price'=>449],
    // Dining
    47 => ['id'=>47, 'name'=>'Round Oak Dining Table',    'price'=>2199],
    48 => ['id'=>48, 'name'=>'Wishbone Dining Chair',     'price'=>499],
    49 => ['id'=>49, 'name'=>'Extendable Dining Table',   'price'=>2799],
    50 => ['id'=>50, 'name'=>'Marble Dining Table',       'price'=>4999],
    51 => ['id'=>51, 'name'=>'Dining Sideboard',          'price'=>1999],
    52 => ['id'=>52, 'name'=>'Bar Height Stools Set 2',   'price'=>899],
];

$pid   = (int)($_POST['product_id'] ?? 0);
$qty   = max(1, (int)($_POST['qty'] ?? 1));
$color = htmlspecialchars($_POST['color'] ?? 'Default');
$back  = $_POST['redirect'] ?? '/furniture-website/index.php';

if (isset($product_db[$pid])) {
    if (!isset($_SESSION['cart'][$pid])) {
        $_SESSION['cart'][$pid] = ['qty' => 0, 'color' => $color];
    }
    $_SESSION['cart'][$pid]['qty'] += $qty;
    $_SESSION['cart_message'] = '✓ Added to cart!';
}

header('Location: ' . $back);
exit;
