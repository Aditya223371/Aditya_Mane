<?php
if (session_status() === PHP_SESSION_NONE) session_start();
define('SITE_NAME', 'MANE FURNITURE');
define('SITE_TAGLINE', 'Luxury Furniture & Living');

$id = isset($_GET['id']) ? (int)$_GET['id'] : 1;

// Sample product detail data
$products = [
    1 => [
        'id' => 1, 'name' => 'Aria Lounge Chair', 'category' => 'Living Room',
        'price' => 1299, 'original_price' => 1599,
        'rating' => 4.9, 'reviews' => 128,
        'badge' => 'Bestseller',
        'description' => 'The Aria Lounge Chair is the pinnacle of comfort and refined aesthetic. Handcrafted in our Kochi atelier by master artisans, its solid walnut frame is paired with premium Italian leather upholstery to create a piece that is as durable as it is beautiful. Designed to cradle you in perfect ergonomic comfort for hours of reading, contemplating, or simply enjoying a quiet moment.',
        'features' => ['Solid walnut frame with hand-rubbed oil finish', 'Premium full-grain Italian leather', 'High-density foam cushioning', 'Hand-stitched detailing', 'Available in 4 leather colours', '10-year structural warranty'],
        'dimensions' => ['Width' => '80 cm', 'Depth' => '85 cm', 'Height' => '90 cm', 'Seat Height' => '42 cm', 'Weight' => '18 kg'],
        'images' => [
            'https://images.unsplash.com/photo-1567538096630-e0c55bd6374c?w=800&q=85',
            'https://images.unsplash.com/photo-1586023492125-27b2c045efd7?w=800&q=85',
            'https://images.unsplash.com/photo-1555041469-a586c61ea9bc?w=800&q=85',
            'https://images.unsplash.com/photo-1493663284031-b7e3aefcae8e?w=800&q=85',
        ],
        'delivery' => 'Free white-glove delivery in 7–10 business days',
        'materials' => 'Solid Walnut, Full-Grain Leather',
        'sku' => 'MSN-ALR-001',
    ],
];

$product = $products[$id] ?? $products[1];
$page_title = $product['name'];

include 'includes/header.php';
?>

<div class="product-page">
    <div class="container">
        <!-- Breadcrumb -->
        <div class="breadcrumb" style="padding: 1.5rem 0;">
            <a href="index.php">Home</a><span>›</span>
            <a href="catalog.php">Collection</a><span>›</span>
            <a href="catalog.php?category=<?= urlencode($product['category']) ?>"><?= $product['category'] ?></a><span>›</span>
            <span><?= $product['name'] ?></span>
        </div>

        <div class="product-detail-grid">
            <!-- IMAGES -->
            <div class="product-images">
                <div class="main-img-wrap">
                    <img src="<?= $product['images'][0] ?>" alt="<?= $product['name'] ?>" id="mainImg" />
                    <?php
if (session_status() === PHP_SESSION_NONE) session_start(); if ($product['badge']): ?>
                    <span class="product-badge badge-<?= strtolower($product['badge']) ?>"><?= $product['badge'] ?></span>
                    <?php
if (session_status() === PHP_SESSION_NONE) session_start(); endif; ?>
                </div>
                <div class="thumb-list">
                    <?php
if (session_status() === PHP_SESSION_NONE) session_start(); foreach ($product['images'] as $i => $img): ?>
                    <div class="thumb <?= $i === 0 ? 'active' : '' ?>" onclick="changeImg('<?= $img ?>', this)">
                        <img src="<?= $img ?>" alt="View <?= $i+1 ?>" />
                    </div>
                    <?php
if (session_status() === PHP_SESSION_NONE) session_start(); endforeach; ?>
                </div>
            </div>

            <!-- INFO -->
            <div class="product-detail-info">
                <p class="product-category"><?= $product['category'] ?></p>
                <h1><?= $product['name'] ?></h1>
                <p class="product-sku">SKU: <?= $product['sku'] ?></p>

                <div class="product-rating" style="margin: 0.75rem 0;">
                    <?php
if (session_status() === PHP_SESSION_NONE) session_start(); for ($i = 0; $i < 5; $i++): ?>
                    <span class="star <?= $i < floor($product['rating']) ? 'filled' : '' ?>">★</span>
                    <?php
if (session_status() === PHP_SESSION_NONE) session_start(); endfor; ?>
                    <span class="review-count">(<?= $product['reviews'] ?> reviews)</span>
                </div>

                <div class="product-price" style="margin-bottom: 1.5rem;">
                    <span class="price-current">₹<?= number_format($product['price']) ?></span>
                    <?php
if (session_status() === PHP_SESSION_NONE) session_start(); if ($product['original_price']): ?>
                    <span class="price-original">₹<?= number_format($product['original_price']) ?></span>
                    <span class="price-save">Save <?= round((1 - $product['price']/$product['original_price'])*100) ?>%</span>
                    <?php
if (session_status() === PHP_SESSION_NONE) session_start(); endif; ?>
                </div>

                <p style="color: var(--text-mid); margin-bottom: 2rem; line-height: 1.8;"><?= $product['description'] ?></p>

                <!-- COLOR -->
                <div class="product-option">
                    <label>Colour: <strong>Cognac Brown</strong></label>
                    <div class="color-swatches">
                        <span class="swatch active" style="background:#8B4513;" title="Cognac Brown"></span>
                        <span class="swatch" style="background:#1A1A1A;" title="Onyx Black"></span>
                        <span class="swatch" style="background:#F5F0E8;" title="Ivory Cream"></span>
                        <span class="swatch" style="background:#6B8E6B;" title="Sage Green"></span>
                    </div>
                </div>

                <!-- QUANTITY -->
                <div class="product-option">
                    <label>Quantity:</label>
                    <div class="qty-control">
                        <button onclick="changeQty(-1)">−</button>
                        <input type="number" id="qtyInput" value="1" min="1" max="10" readonly />
                        <button onclick="changeQty(1)">+</button>
                    </div>
                </div>

                <div class="product-ctas">
                    <button class="btn btn-primary" onclick="addToCart(<?= $product['id'] ?>)" style="flex:1; justify-content:center;">Add to Cart</button>
                    <button class="btn btn-wishlist">♡</button>
                </div>

                <!-- DELIVERY -->
                <div class="delivery-info">
                    <span>🚚</span>
                    <p><?= $product['delivery'] ?></p>
                </div>

                <!-- ACCORDION -->
                <div class="accordions">
                    <details class="accordion" open>
                        <summary>Features & Specifications</summary>
                        <ul class="feat-list">
                            <?php
if (session_status() === PHP_SESSION_NONE) session_start(); foreach ($product['features'] as $f): ?>
                            <li>✦ <?= $f ?></li>
                            <?php
if (session_status() === PHP_SESSION_NONE) session_start(); endforeach; ?>
                        </ul>
                    </details>

                    <details class="accordion">
                        <summary>Dimensions</summary>
                        <table class="dim-table">
                            <?php
if (session_status() === PHP_SESSION_NONE) session_start(); foreach ($product['dimensions'] as $k => $v): ?>
                            <tr><td><?= $k ?></td><td><?= $v ?></td></tr>
                            <?php
if (session_status() === PHP_SESSION_NONE) session_start(); endforeach; ?>
                        </table>
                    </details>

                    <details class="accordion">
                        <summary>Materials & Care</summary>
                        <p style="font-size:0.88rem;color:var(--text-mid);padding:1rem 0;">Materials: <strong><?= $product['materials'] ?></strong>. Care with a soft cloth dampened with clean water. For leather, use a pH-neutral leather conditioner every 6 months. Avoid direct sunlight and heat sources.</p>
                    </details>

                    <details class="accordion">
                        <summary>Delivery & Warranty</summary>
                        <p style="font-size:0.88rem;color:var(--text-mid);padding:1rem 0;">Includes white-glove delivery, assembly, and removal of packaging. All Mane Furniture pieces come with a 10-year structural warranty and 2-year upholstery warranty.</p>
                    </details>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.product-page { padding: 0 0 5rem; }
.product-detail-grid { display: grid; grid-template-columns: 1.1fr 1fr; gap: 4rem; align-items: start; padding-bottom: 4rem; }
.main-img-wrap { position: relative; border-radius: var(--radius-lg); overflow: hidden; margin-bottom: 1rem; }
.main-img-wrap img { width: 100%; height: 550px; object-fit: cover; transition: opacity 0.3s; }
.thumb-list { display: grid; grid-template-columns: repeat(4, 1fr); gap: 0.75rem; }
.thumb { border-radius: var(--radius); overflow: hidden; cursor: pointer; border: 2px solid transparent; transition: border-color var(--transition); }
.thumb.active { border-color: var(--gold); }
.thumb img { width: 100%; height: 90px; object-fit: cover; }
.product-detail-info h1 { font-family: var(--font-serif); font-size: 2.25rem; font-weight: 400; color: var(--brown); margin: 0.5rem 0; }
.product-sku { font-size: 0.75rem; color: var(--text-light); letter-spacing: 0.1em; }
.price-save { background: #FFF3E0; color: #E65100; font-size: 0.78rem; font-weight: 600; padding: 0.2rem 0.6rem; border-radius: 20px; margin-left: 0.5rem; }
.product-option { margin-bottom: 1.25rem; }
.product-option label { display: block; font-size: 0.82rem; font-weight: 500; text-transform: uppercase; letter-spacing: 0.08em; color: var(--text-mid); margin-bottom: 0.5rem; }
.color-swatches { display: flex; gap: 0.5rem; }
.swatch { width: 30px; height: 30px; border-radius: 50%; cursor: pointer; border: 2px solid transparent; transition: all var(--transition); }
.swatch.active, .swatch:hover { border-color: var(--gold); transform: scale(1.1); }
.qty-control { display: flex; align-items: center; border: 1.5px solid var(--border); border-radius: var(--radius); width: fit-content; }
.qty-control button { width: 40px; height: 40px; font-size: 1.1rem; color: var(--text-mid); transition: all var(--transition); }
.qty-control button:hover { color: var(--gold); }
.qty-control input { width: 50px; text-align: center; border: none; font-family: var(--font-sans); font-size: 0.9rem; background: none; }
.product-ctas { display: flex; gap: 0.75rem; margin: 1.5rem 0; }
.btn-wishlist { width: 50px; height: 50px; border: 1.5px solid var(--border); border-radius: var(--radius); font-size: 1.2rem; display: flex; align-items: center; justify-content: center; transition: all var(--transition); }
.btn-wishlist:hover { border-color: #E05252; color: #E05252; }
.delivery-info { display: flex; align-items: center; gap: 0.75rem; background: var(--cream); border-radius: var(--radius); padding: 0.75rem 1rem; font-size: 0.85rem; color: var(--text-mid); margin-bottom: 1.5rem; }
.delivery-info span { font-size: 1.25rem; }
.accordion { border-bottom: 1px solid var(--border); }
.accordion summary { padding: 1rem 0; font-size: 0.85rem; font-weight: 500; letter-spacing: 0.06em; text-transform: uppercase; color: var(--text-mid); cursor: pointer; list-style: none; display: flex; justify-content: space-between; align-items: center; }
.accordion summary::-webkit-details-marker { display: none; }
.accordion[open] summary { color: var(--gold); }
.accordion summary::after { content: '+'; font-size: 1.2rem; color: var(--gold); transition: transform var(--transition); }
.accordion[open] summary::after { transform: rotate(45deg); }
.feat-list { padding: 0.75rem 0 1rem; }
.feat-list li { font-size: 0.85rem; color: var(--text-mid); padding: 0.3rem 0; }
.dim-table { width: 100%; border-collapse: collapse; margin: 0.5rem 0 1rem; }
.dim-table td { padding: 0.5rem 0; font-size: 0.85rem; color: var(--text-mid); border-bottom: 1px solid var(--border); }
.dim-table td:first-child { color: var(--text-light); width: 40%; }
@media (max-width: 900px) { .product-detail-grid { grid-template-columns: 1fr; } }
</style>

<script>
function changeImg(src, thumb) {
    document.getElementById('mainImg').style.opacity = '0';
    setTimeout(() => {
        document.getElementById('mainImg').src = src;
        document.getElementById('mainImg').style.opacity = '1';
    }, 200);
    document.querySelectorAll('.thumb').forEach(t => t.classList.remove('active'));
    thumb.classList.add('active');
}
function changeQty(delta) {
    const input = document.getElementById('qtyInput');
    const val = parseInt(input.value) + delta;
    if (val >= 1 && val <= 10) input.value = val;
}
document.querySelectorAll('.swatch').forEach(s => {
    s.addEventListener('click', function() {
        document.querySelectorAll('.swatch').forEach(x => x.classList.remove('active'));
        this.classList.add('active');
    });
});
</script>

<?php
if (session_status() === PHP_SESSION_NONE) session_start(); include 'includes/footer.php'; ?>
