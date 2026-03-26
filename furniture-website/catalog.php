<?php
if (session_status() === PHP_SESSION_NONE) session_start();
define('SITE_NAME', 'MANE FURNITURE');
define('SITE_TAGLINE', 'Luxury Furniture & Living');
$page_title = 'Collection';

$active_category = isset($_GET['category']) ? htmlspecialchars($_GET['category']) : 'All';
$sort = isset($_GET['sort']) ? htmlspecialchars($_GET['sort']) : 'featured';
$categories = ['All','Living Room','Bedroom','Office','Outdoor','Dining'];

$all_products = [
    ['id'=>1, 'name'=>'Aria Lounge Chair',        'category'=>'Living Room','price'=>1299,'original_price'=>1599,'image'=>'https://images.unsplash.com/photo-1567538096630-e0c55bd6374c?w=500&q=80','badge'=>'Bestseller','rating'=>4.9,'reviews'=>128],
    ['id'=>2, 'name'=>'Nordic Oak Bed Frame',      'category'=>'Bedroom',   'price'=>2199,'original_price'=>null, 'image'=>'https://images.unsplash.com/photo-1540574163026-643ea20ade25?w=500&q=80','badge'=>'New',       'rating'=>4.8,'reviews'=>64],
    ['id'=>3, 'name'=>'Executive Walnut Desk',     'category'=>'Office',    'price'=>1849,'original_price'=>2100, 'image'=>'https://images.unsplash.com/photo-1493663284031-b7e3aefcae8e?w=500&q=80','badge'=>'Sale',      'rating'=>4.7,'reviews'=>92],
    ['id'=>4, 'name'=>'Terrazzo Dining Table',     'category'=>'Dining',    'price'=>3499,'original_price'=>null, 'image'=>'https://images.unsplash.com/photo-1583847268964-b28dc8f51f92?w=500&q=80','badge'=>'Premium',   'rating'=>5.0,'reviews'=>41],
    ['id'=>5, 'name'=>'Velvet Sofa - Sage',        'category'=>'Living Room','price'=>2799,'original_price'=>3200,'image'=>'https://images.unsplash.com/photo-1555041469-a586c61ea9bc?w=500&q=80','badge'=>'Sale',      'rating'=>4.9,'reviews'=>210],
    ['id'=>6, 'name'=>'Garden Teak Lounger',       'category'=>'Outdoor',   'price'=>899, 'original_price'=>null, 'image'=>'https://images.unsplash.com/photo-1507473885765-e6ed057f782c?w=500&q=80','badge'=>'New',       'rating'=>4.6,'reviews'=>37],
    ['id'=>7, 'name'=>'Marble Console Table',      'category'=>'Living Room','price'=>1499,'original_price'=>null, 'image'=>'https://images.unsplash.com/photo-1493663284031-b7e3aefcae8e?w=500&q=80','badge'=>null,        'rating'=>4.5,'reviews'=>55],
    ['id'=>8, 'name'=>'Linen Platform Bed',        'category'=>'Bedroom',   'price'=>1899,'original_price'=>2300, 'image'=>'https://images.unsplash.com/photo-1522771739844-6a9f6d5f14af?w=500&q=80','badge'=>'Sale',      'rating'=>4.8,'reviews'=>78],
    ['id'=>9, 'name'=>'Ergonomic Study Chair',     'category'=>'Office',    'price'=>699, 'original_price'=>null, 'image'=>'https://images.unsplash.com/photo-1596079890701-dd42edf4a7e0?w=500&q=80','badge'=>'New',       'rating'=>4.7,'reviews'=>43],
    ['id'=>10,'name'=>'Rattan Accent Chair',       'category'=>'Outdoor',   'price'=>549, 'original_price'=>null, 'image'=>'https://images.unsplash.com/photo-1586023492125-27b2c045efd7?w=500&q=80','badge'=>null,        'rating'=>4.4,'reviews'=>29],
    ['id'=>11,'name'=>'Herringbone Bookcase',      'category'=>'Living Room','price'=>1149,'original_price'=>null, 'image'=>'https://images.unsplash.com/photo-1583847268964-b28dc8f51f92?w=500&q=80','badge'=>null,        'rating'=>4.6,'reviews'=>61],
    ['id'=>12,'name'=>'Stone Dining Bench',        'category'=>'Dining',    'price'=>799, 'original_price'=>null, 'image'=>'https://images.unsplash.com/photo-1616486338812-3dadae4b4ace?w=500&q=80','badge'=>'New',       'rating'=>4.5,'reviews'=>18],
    // Living Room extras
    ['id'=>13,'name'=>'Velvet Accent Chair',       'category'=>'Living Room','price'=>899, 'original_price'=>1100,'image'=>'https://images.unsplash.com/photo-1598300042247-d088f8ab3a91?w=500&q=80','badge'=>'Sale',      'rating'=>4.5,'reviews'=>73],
    ['id'=>14,'name'=>'Linen 2-Seater Sofa',       'category'=>'Living Room','price'=>1999,'original_price'=>2499,'image'=>'https://images.unsplash.com/photo-1555041469-a586c61ea9bc?w=500&q=80','badge'=>'Sale',      'rating'=>4.7,'reviews'=>88],
    ['id'=>15,'name'=>'Rattan Coffee Table',       'category'=>'Living Room','price'=>849, 'original_price'=>999, 'image'=>'https://images.unsplash.com/photo-1499933374294-4584851b32e3?w=500&q=80','badge'=>'Sale',      'rating'=>4.4,'reviews'=>42],
    ['id'=>16,'name'=>'Wooden Wall Shelf Set',     'category'=>'Living Room','price'=>399, 'original_price'=>null, 'image'=>'https://images.unsplash.com/photo-1618220179428-22790b461013?w=500&q=80','badge'=>null,        'rating'=>4.4,'reviews'=>56],
    ['id'=>17,'name'=>'Brass Floor Lamp',          'category'=>'Living Room','price'=>649, 'original_price'=>null, 'image'=>'https://images.unsplash.com/photo-1507473885765-e6ed057f782c?w=500&q=80','badge'=>null,        'rating'=>4.3,'reviews'=>34],
    ['id'=>18,'name'=>'Walnut TV Media Unit',      'category'=>'Living Room','price'=>1899,'original_price'=>null, 'image'=>'https://images.unsplash.com/photo-1593030761757-71fae45fa0e7?w=500&q=80','badge'=>'New',       'rating'=>4.6,'reviews'=>47],
    ['id'=>19,'name'=>'Leather Chesterfield Sofa', 'category'=>'Living Room','price'=>5499,'original_price'=>6500,'image'=>'https://images.unsplash.com/photo-1571898223751-76b611d2b99c?w=500&q=80','badge'=>'Premium',   'rating'=>4.9,'reviews'=>24],
    ['id'=>20,'name'=>'Ottoman Footstool',         'category'=>'Living Room','price'=>449, 'original_price'=>null, 'image'=>'https://images.unsplash.com/photo-1617325247661-675ab4b64ae2?w=500&q=80','badge'=>null,        'rating'=>4.4,'reviews'=>67],
    ['id'=>21,'name'=>'Cane Back Armchair',        'category'=>'Living Room','price'=>799, 'original_price'=>null, 'image'=>'https://images.unsplash.com/photo-1506439773649-6e0eb8cfb237?w=500&q=80','badge'=>'New',       'rating'=>4.3,'reviews'=>21],
    ['id'=>22,'name'=>'Modular Sectional Sofa',    'category'=>'Living Room','price'=>4999,'original_price'=>5999,'image'=>'https://images.unsplash.com/photo-1540574163026-643ea20ade25?w=500&q=80','badge'=>'Premium',   'rating'=>4.8,'reviews'=>33],
    ['id'=>23,'name'=>'Teak Root Coffee Table',    'category'=>'Living Room','price'=>2299,'original_price'=>null, 'image'=>'https://images.unsplash.com/photo-1567538096630-e0c55bd6374c?w=500&q=80','badge'=>'Premium',   'rating'=>5.0,'reviews'=>19],
    ['id'=>24,'name'=>'Ceramic Table Lamp Set',    'category'=>'Living Room','price'=>699, 'original_price'=>null, 'image'=>'https://images.unsplash.com/photo-1513506003901-1e6a35294aa5?w=500&q=80','badge'=>null,        'rating'=>4.6,'reviews'=>44],
    // Bedroom extras
    ['id'=>25,'name'=>'Walnut Bedside Table',      'category'=>'Bedroom',   'price'=>599, 'original_price'=>null, 'image'=>'https://images.unsplash.com/photo-1505693416388-ac5ce068fe85?w=500&q=80','badge'=>null,        'rating'=>4.7,'reviews'=>89],
    ['id'=>26,'name'=>'King Size Wardrobe',        'category'=>'Bedroom',   'price'=>5499,'original_price'=>6200,'image'=>'https://images.unsplash.com/photo-1558618047-3c8c76ca7d13?w=500&q=80','badge'=>'Premium',   'rating'=>4.9,'reviews'=>33],
    ['id'=>27,'name'=>'Chest of Drawers',          'category'=>'Bedroom',   'price'=>1399,'original_price'=>null, 'image'=>'https://images.unsplash.com/photo-1549497538-303791108f95?w=500&q=80','badge'=>null,        'rating'=>4.6,'reviews'=>52],
    ['id'=>28,'name'=>'Dressing Table and Mirror', 'category'=>'Bedroom',   'price'=>1699,'original_price'=>1999,'image'=>'https://images.unsplash.com/photo-1616594039964-ae9021a400a0?w=500&q=80','badge'=>'Sale',      'rating'=>4.7,'reviews'=>46],
    ['id'=>29,'name'=>'Upholstered Headboard',     'category'=>'Bedroom',   'price'=>849, 'original_price'=>null, 'image'=>'https://images.unsplash.com/photo-1631049307264-da0ec9d70304?w=500&q=80','badge'=>'New',       'rating'=>4.5,'reviews'=>31],
    ['id'=>30,'name'=>'Four Poster Bed Frame',     'category'=>'Bedroom',   'price'=>4299,'original_price'=>5000,'image'=>'https://images.unsplash.com/photo-1614148680759-4b99af7c3c14?w=500&q=80','badge'=>'Premium',   'rating'=>4.9,'reviews'=>15],
    ['id'=>31,'name'=>'Bedroom Bench Velvet',      'category'=>'Bedroom',   'price'=>749, 'original_price'=>null, 'image'=>'https://images.unsplash.com/photo-1588046130717-0eb0c9a3ba15?w=500&q=80','badge'=>null,        'rating'=>4.4,'reviews'=>28],
    ['id'=>32,'name'=>'Loft Bunk Bed',             'category'=>'Bedroom',   'price'=>2499,'original_price'=>null, 'image'=>'https://images.unsplash.com/photo-1595526114035-0d45ed16cfbf?w=500&q=80','badge'=>'New',       'rating'=>4.7,'reviews'=>22],
    ['id'=>33,'name'=>'Wooden Blanket Ladder',     'category'=>'Bedroom',   'price'=>299, 'original_price'=>null, 'image'=>'https://images.unsplash.com/photo-1515488764276-beab7607c1e6?w=500&q=80','badge'=>null,        'rating'=>4.6,'reviews'=>74],
    // Office extras
    ['id'=>34,'name'=>'Standing Desk Oak',         'category'=>'Office',    'price'=>2499,'original_price'=>2999,'image'=>'https://images.unsplash.com/photo-1593642632559-0c6d3fc62b89?w=500&q=80','badge'=>'Sale',      'rating'=>4.8,'reviews'=>56],
    ['id'=>35,'name'=>'Leather Executive Chair',   'category'=>'Office',    'price'=>1499,'original_price'=>1799,'image'=>'https://images.unsplash.com/photo-1589364222378-4e328e90caaa?w=500&q=80','badge'=>'Sale',      'rating'=>4.6,'reviews'=>71],
    ['id'=>36,'name'=>'L-Shape Corner Desk',       'category'=>'Office',    'price'=>1699,'original_price'=>null, 'image'=>'https://images.unsplash.com/photo-1593642702821-c8da6771f0c6?w=500&q=80','badge'=>'New',       'rating'=>4.5,'reviews'=>29],
    ['id'=>37,'name'=>'Monitor Riser Oak',         'category'=>'Office',    'price'=>449, 'original_price'=>null, 'image'=>'https://images.unsplash.com/photo-1547394765-185e1e68f34e?w=500&q=80','badge'=>null,        'rating'=>4.7,'reviews'=>94],
    ['id'=>38,'name'=>'Filing Cabinet 3 Drawer',  'category'=>'Office',    'price'=>799, 'original_price'=>null, 'image'=>'https://images.unsplash.com/photo-1586281380349-632531db7ed4?w=500&q=80','badge'=>null,        'rating'=>4.3,'reviews'=>27],
    ['id'=>39,'name'=>'Office Bookshelf',          'category'=>'Office',    'price'=>999, 'original_price'=>null, 'image'=>'https://images.unsplash.com/photo-1526040652367-ac003a0475fe?w=500&q=80','badge'=>null,        'rating'=>4.5,'reviews'=>38],
    ['id'=>40,'name'=>'Architect Desk Lamp',       'category'=>'Office',    'price'=>599, 'original_price'=>null, 'image'=>'https://images.unsplash.com/photo-1593078166039-c9878df5c520?w=500&q=80','badge'=>'New',       'rating'=>4.6,'reviews'=>48],
    // Outdoor extras
    ['id'=>41,'name'=>'Hammock with Stand',        'category'=>'Outdoor',   'price'=>1299,'original_price'=>1599,'image'=>'https://images.unsplash.com/photo-1520531158340-44015069e78e?w=500&q=80','badge'=>'Sale',      'rating'=>4.7,'reviews'=>41],
    ['id'=>42,'name'=>'Outdoor Sofa Set 5pc',      'category'=>'Outdoor',   'price'=>5999,'original_price'=>7000,'image'=>'https://images.unsplash.com/photo-1600585154526-990dced4db0d?w=500&q=80','badge'=>'Premium',   'rating'=>4.9,'reviews'=>18],
    ['id'=>43,'name'=>'Garden Bistro Set',         'category'=>'Outdoor',   'price'=>799, 'original_price'=>null, 'image'=>'https://images.unsplash.com/photo-1533090481720-856c6e3c1fdc?w=500&q=80','badge'=>null,        'rating'=>4.5,'reviews'=>53],
    ['id'=>44,'name'=>'Garden Swing Chair',        'category'=>'Outdoor',   'price'=>1499,'original_price'=>1799,'image'=>'https://images.unsplash.com/photo-1591988575840-4d0c7c78b42e?w=500&q=80','badge'=>'Sale',      'rating'=>4.6,'reviews'=>27],
    ['id'=>45,'name'=>'Teak Outdoor Dining Set',   'category'=>'Outdoor',   'price'=>4299,'original_price'=>5000,'image'=>'https://images.unsplash.com/photo-1600210492493-0946911123ea?w=500&q=80','badge'=>'Sale',      'rating'=>4.8,'reviews'=>22],
    ['id'=>46,'name'=>'Folding Teak Chair',        'category'=>'Outdoor',   'price'=>449, 'original_price'=>null, 'image'=>'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=500&q=80','badge'=>null,        'rating'=>4.5,'reviews'=>46],
    // Dining extras
    ['id'=>47,'name'=>'Round Oak Dining Table',    'category'=>'Dining',    'price'=>2199,'original_price'=>2599,'image'=>'https://images.unsplash.com/photo-1617806118233-18e1de247200?w=500&q=80','badge'=>'Sale',      'rating'=>4.8,'reviews'=>63],
    ['id'=>48,'name'=>'Wishbone Dining Chair',     'category'=>'Dining',    'price'=>499, 'original_price'=>null, 'image'=>'https://images.unsplash.com/photo-1592078615290-033ee584e267?w=500&q=80','badge'=>null,        'rating'=>4.6,'reviews'=>97],
    ['id'=>49,'name'=>'Extendable Dining Table',   'category'=>'Dining',    'price'=>2799,'original_price'=>3299,'image'=>'https://images.unsplash.com/photo-1549497538-303791108f95?w=500&q=80','badge'=>'Sale',      'rating'=>4.8,'reviews'=>55],
    ['id'=>50,'name'=>'Marble Dining Table',       'category'=>'Dining',    'price'=>4999,'original_price'=>5999,'image'=>'https://images.unsplash.com/photo-1560448075-cbc16bb4af8e?w=500&q=80','badge'=>'Premium',   'rating'=>4.9,'reviews'=>22],
    ['id'=>51,'name'=>'Dining Sideboard',          'category'=>'Dining',    'price'=>1999,'original_price'=>null, 'image'=>'https://images.unsplash.com/photo-1555041469-a586c61ea9bc?w=500&q=80','badge'=>'New',       'rating'=>4.7,'reviews'=>31],
    ['id'=>52,'name'=>'Bar Height Stools Set 2',   'category'=>'Dining',    'price'=>899, 'original_price'=>null, 'image'=>'https://images.unsplash.com/photo-1581539250439-c96689b516dd?w=500&q=80','badge'=>null,        'rating'=>4.4,'reviews'=>44],
];

$products = ($active_category === 'All') ? $all_products : array_values(array_filter($all_products, function($p) use ($active_category) { return $p['category'] === $active_category; }));

$cart_msg = '';
if (!empty($_SESSION['cart_message'])) { $cart_msg = $_SESSION['cart_message']; unset($_SESSION['cart_message']); }

include 'includes/header.php';
?>

<?php if ($cart_msg): ?>
<div style="background:#2C1810;color:#F5F0E8;text-align:center;padding:0.6rem;font-size:0.85rem;">
    ✓ <?= htmlspecialchars($cart_msg) ?> — <a href="/furniture-website/cart.php" style="color:#C4942A;text-decoration:underline;">View Cart</a>
</div>
<?php endif; ?>

<section class="page-banner">
    <div class="container">
        <div class="breadcrumb"><a href="/furniture-website/index.php">Home</a><span>›</span><span>Collection</span></div>
        <h1>Our Collection</h1>
        <p>Handcrafted furniture for every room — made to last a lifetime.</p>
    </div>
</section>

<div class="catalog-layout">
    <!-- SIDEBAR -->
    <aside class="catalog-sidebar">
        <div class="sidebar-section">
            <h3>Category</h3>
            <ul class="sidebar-filter-list">
                <?php foreach ($categories as $cat): ?>
                <li>
                    <a href="/furniture-website/catalog.php?category=<?= urlencode($cat) ?>" class="<?= $active_category === $cat ? 'active' : '' ?>">
                        <?= $cat ?>
                        <span class="filter-count"><?= $cat==='All' ? count($all_products) : count(array_filter($all_products, fn($p) => $p['category']===$cat)) ?></span>
                    </a>
                </li>
                <?php endforeach; ?>
            </ul>
        </div>
        <div class="sidebar-section">
            <h3>Price Range</h3>
            <div class="price-range">
                <input type="range" min="0" max="5000" value="5000" class="range-slider" id="priceRange" />
                <div class="price-labels"><span>₹0</span><span id="priceMax">₹5,000</span></div>
            </div>
        </div>
        <div class="sidebar-section">
            <h3>Material</h3>
            <ul class="checkbox-list">
                <li><label><input type="checkbox" /> Solid Teak</label></li>
                <li><label><input type="checkbox" /> Walnut</label></li>
                <li><label><input type="checkbox" /> Oak</label></li>
                <li><label><input type="checkbox" /> Marble</label></li>
                <li><label><input type="checkbox" /> Rattan</label></li>
            </ul>
        </div>
    </aside>

    <!-- PRODUCTS -->
    <main class="catalog-main">
        <div class="catalog-toolbar">
            <p class="results-count"><?= count($products) ?> products</p>
            <div class="sort-bar">
                <label>Sort by:</label>
                <select onchange="window.location='catalog.php?sort='+this.value+'&category=<?= urlencode($active_category) ?>'">
                    <option value="featured" <?= $sort==='featured'?'selected':'' ?>>Featured</option>
                    <option value="price_asc" <?= $sort==='price_asc'?'selected':'' ?>>Price: Low to High</option>
                    <option value="price_desc" <?= $sort==='price_desc'?'selected':'' ?>>Price: High to Low</option>
                    <option value="rating" <?= $sort==='rating'?'selected':'' ?>>Top Rated</option>
                </select>
            </div>
        </div>

        <div class="catalog-grid">
            <?php foreach ($products as $product): ?>
            <div class="product-card">
                <div class="product-img-wrap">
                    <img src="<?= $product['image'] ?>" alt="<?= $product['name'] ?>" loading="lazy" onerror="this.src='https://images.unsplash.com/photo-1555041469-a586c61ea9bc?w=500&q=80'" />
                    <?php if ($product['badge']): ?>
                    <span class="product-badge badge-<?= strtolower($product['badge']) ?>"><?= $product['badge'] ?></span>
                    <?php endif; ?>
                    <div class="product-actions">
                        <a href="/furniture-website/product.php?id=<?= $product['id'] ?>" class="product-action-btn">Quick View</a>
                    </div>
                </div>
                <div class="product-info">
                    <p class="product-category"><?= $product['category'] ?></p>
                    <h3 class="product-name"><a href="/furniture-website/product.php?id=<?= $product['id'] ?>"><?= $product['name'] ?></a></h3>
                    <div class="product-rating">
                        <?php for ($i=0;$i<5;$i++): ?>
                        <span class="star <?= $i < floor($product['rating']) ? 'filled' : '' ?>">★</span>
                        <?php endfor; ?>
                        <span class="review-count">(<?= $product['reviews'] ?>)</span>
                    </div>
                    <div class="product-price">
                        <span class="price-current">₹<?= number_format($product['price']) ?></span>
                        <?php if ($product['original_price']): ?>
                        <span class="price-original">₹<?= number_format($product['original_price']) ?></span>
                        <?php endif; ?>
                    </div>
                    <form method="POST" action="/furniture-website/add-to-cart.php">
                        <input type="hidden" name="product_id" value="<?= $product['id'] ?>" />
                        <input type="hidden" name="qty" value="1" />
                        <input type="hidden" name="redirect" value="/furniture-website/catalog.php?category=<?= urlencode($active_category) ?>" />
                        <button type="submit" class="btn btn-add-cart">Add to Cart</button>
                    </form>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </main>
</div>

<style>
.catalog-layout{display:grid;grid-template-columns:260px 1fr;gap:3rem;max-width:1280px;margin:0 auto;padding:3rem 2rem}
.catalog-sidebar{position:sticky;top:90px;align-self:start}
.sidebar-section{margin-bottom:2rem;padding-bottom:2rem;border-bottom:1px solid var(--border)}
.sidebar-section h3{font-family:var(--font-serif);font-size:1rem;font-weight:600;color:var(--brown);margin-bottom:1rem}
.sidebar-filter-list li a{display:flex;justify-content:space-between;align-items:center;padding:.4rem .75rem;border-radius:var(--radius);font-size:.85rem;color:var(--text-mid);transition:all var(--transition)}
.sidebar-filter-list li a:hover,.sidebar-filter-list li a.active{background:var(--cream);color:var(--gold)}
.filter-count{background:var(--cream-dark);color:var(--text-light);font-size:.7rem;padding:.15rem .5rem;border-radius:20px}
.range-slider{width:100%;accent-color:var(--gold)}
.price-labels{display:flex;justify-content:space-between;font-size:.8rem;color:var(--text-light);margin-top:.35rem}
.checkbox-list li{margin-bottom:.5rem}
.checkbox-list label{display:flex;align-items:center;gap:.5rem;font-size:.85rem;color:var(--text-mid);cursor:pointer}
.checkbox-list input{accent-color:var(--gold)}
.catalog-toolbar{display:flex;align-items:center;justify-content:space-between;margin-bottom:2rem;padding-bottom:1rem;border-bottom:1px solid var(--border)}
.results-count{font-size:.85rem;color:var(--text-light)}
.sort-bar{display:flex;align-items:center;gap:.75rem;font-size:.85rem;color:var(--text-mid)}
.sort-bar select{padding:.4rem .75rem;border:1px solid var(--border);border-radius:var(--radius);font-family:var(--font-sans);font-size:.85rem;outline:none;background:var(--white);cursor:pointer}
.catalog-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:1.5rem}
@media(max-width:1100px){.catalog-grid{grid-template-columns:repeat(2,1fr)}}
@media(max-width:800px){.catalog-layout{grid-template-columns:1fr}.catalog-sidebar{position:static}}
@media(max-width:500px){.catalog-grid{grid-template-columns:1fr}}
</style>

<script>
const r=document.getElementById('priceRange'),p=document.getElementById('priceMax');
if(r)r.addEventListener('input',function(){if(p)p.textContent='₹'+Number(this.value).toLocaleString('en-IN');});
</script>

<?php include 'includes/footer.php'; ?>
