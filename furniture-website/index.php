<?php
if (session_status() === PHP_SESSION_NONE) session_start();
define('SITE_NAME', 'MANE FURNITURE');
define('SITE_TAGLINE', 'Luxury Furniture & Living');

$featured_products = [
    ['id'=>1,'name'=>'Aria Lounge Chair','category'=>'Living Room','price'=>1299,'original_price'=>1599,'image'=>'https://images.unsplash.com/photo-1567538096630-e0c55bd6374c?w=600&q=80','badge'=>'Bestseller','rating'=>4.9,'reviews'=>128],
    ['id'=>2,'name'=>'Nordic Oak Bed Frame','category'=>'Bedroom','price'=>2199,'original_price'=>null,'image'=>'https://images.unsplash.com/photo-1505693416388-ac5ce068fe85?w=600&q=80','badge'=>'New','rating'=>4.8,'reviews'=>64],
    ['id'=>3,'name'=>'Executive Walnut Desk','category'=>'Office','price'=>1849,'original_price'=>2100,'image'=>'https://images.unsplash.com/photo-1518455027359-f3f8164ba6bd?w=600&q=80','badge'=>'Sale','rating'=>4.7,'reviews'=>92],
    ['id'=>4,'name'=>'Terrazzo Dining Table','category'=>'Dining','price'=>3499,'original_price'=>null,'image'=>'https://images.unsplash.com/photo-1555041469-a586c61ea9bc?w=600&q=80','badge'=>'Premium','rating'=>5.0,'reviews'=>41],
    ['id'=>5,'name'=>'Velvet Sofa - Sage','category'=>'Living Room','price'=>2799,'original_price'=>3200,'image'=>'https://images.unsplash.com/photo-1540574163026-643ea20ade25?w=600&q=80','badge'=>'Sale','rating'=>4.9,'reviews'=>210],
    ['id'=>6,'name'=>'Garden Teak Lounger','category'=>'Outdoor','price'=>899,'original_price'=>null,'image'=>'https://images.unsplash.com/photo-1600210492493-0946911123ea?w=600&q=80','badge'=>'New','rating'=>4.6,'reviews'=>37],
];

$categories = [
    ['name'=>'Living Room','icon'=>'🛋️','count'=>48,'image'=>'https://images.unsplash.com/photo-1586023492125-27b2c045efd7?w=500&q=80'],
    ['name'=>'Bedroom','icon'=>'🛏️','count'=>35,'image'=>'https://images.unsplash.com/photo-1616594039964-ae9021a400a0?w=500&q=80'],
    ['name'=>'Office','icon'=>'💼','count'=>27,'image'=>'https://images.unsplash.com/photo-1593642632559-0c6d3fc62b89?w=500&q=80'],
    ['name'=>'Outdoor','icon'=>'🌿','count'=>22,'image'=>'https://images.unsplash.com/photo-1600210492493-0946911123ea?w=500&q=80'],
];

$testimonials = [
    ['name'=>'Priya Sharma','city'=>'Mumbai','text'=>'The Aria Lounge Chair transformed my living room. The craftsmanship is impeccable — every detail speaks of quality.','rating'=>5,'avatar'=>'PS'],
    ['name'=>'Rahul Mehta','city'=>'Delhi','text'=>'Mane Furniture delivered exactly what they promised — luxury furniture on time, beautifully packaged. World-class service.','rating'=>5,'avatar'=>'RM'],
    ['name'=>'Ananya Iyer','city'=>'Bangalore','text'=>'The walnut desk is an absolute masterpiece. We furnished our entire home office with Mane Furniture. Worth every rupee.','rating'=>5,'avatar'=>'AI'],
];

// Show cart success message
$cart_msg = '';
if (!empty($_SESSION['cart_message'])) {
    $cart_msg = $_SESSION['cart_message'];
    unset($_SESSION['cart_message']);
}

include 'includes/header.php';
?>

<?php if ($cart_msg): ?>
<div style="background:#2C1810;color:#F5F0E8;text-align:center;padding:0.6rem;font-size:0.85rem;">
    ✓ <?= htmlspecialchars($cart_msg) ?> — <a href="/furniture-website/cart.php" style="color:#C4942A;text-decoration:underline;">View Cart</a>
</div>
<?php endif; ?>

<!-- HERO -->
<section class="hero">
    <div class="hero-bg">
        <img src="https://images.unsplash.com/photo-1618221195710-dd6b41faaea6?w=1800&q=90" alt="Luxury Interior" />
        <div class="hero-overlay"></div>
    </div>
    <div class="hero-content">
        <p class="hero-eyebrow">Est. 2010 · Crafted in Maharashtra</p>
        <h1 class="hero-title">Where Every Room<br><em>Tells a Story</em></h1>
        <p class="hero-subtitle">Discover handcrafted luxury furniture that transforms spaces into sanctuaries.</p>
        <div class="hero-actions">
            <a href="/furniture-website/catalog.php" class="btn btn-primary">Explore Collection</a>
            <a href="/furniture-website/about.php" class="btn btn-ghost">Our Story</a>
        </div>
        <div class="hero-stats">
            <div class="stat"><span class="stat-num">200+</span><span class="stat-label">Pieces</span></div>
            <div class="stat-divider"></div>
            <div class="stat"><span class="stat-num">15+</span><span class="stat-label">Years</span></div>
            <div class="stat-divider"></div>
            <div class="stat"><span class="stat-num">50K+</span><span class="stat-label">Homes</span></div>
        </div>
    </div>
    <div class="hero-scroll"><span>Scroll</span><div class="scroll-line"></div></div>
</section>

<div class="announcement-bar">✦ Free White-Glove Delivery on orders above ₹50,000 &nbsp;·&nbsp; ✦ 10-Year Craftsmanship Warranty &nbsp;·&nbsp; ✦ EMI Available</div>

<!-- CATEGORIES -->
<section class="section categories-section">
    <div class="container">
        <div class="section-header">
            <div><p class="section-eyebrow">Shop by Room</p><h2 class="section-title">Find Your Space</h2></div>
        </div>
        <div class="categories-grid">
            <?php foreach ($categories as $cat): ?>
            <a href="/furniture-website/catalog.php?category=<?= urlencode($cat['name']) ?>" class="category-card">
                <div class="category-img"><img src="<?= $cat['image'] ?>" alt="<?= $cat['name'] ?>" loading="lazy" /></div>
                <div class="category-info">
                    <span class="category-icon"><?= $cat['icon'] ?></span>
                    <h3><?= $cat['name'] ?></h3>
                    <p><?= $cat['count'] ?> pieces</p>
                </div>
                <div class="category-arrow">→</div>
            </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- FEATURED PRODUCTS -->
<section class="section products-section">
    <div class="container">
        <div class="section-header">
            <div><p class="section-eyebrow">Curated Selection</p><h2 class="section-title">Featured Pieces</h2></div>
            <a href="/furniture-website/catalog.php" class="section-link">View All →</a>
        </div>
        <div class="products-grid">
            <?php foreach ($featured_products as $product): ?>
            <div class="product-card">
                <div class="product-img-wrap">
                    <img src="<?= $product['image'] ?>" alt="<?= $product['name'] ?>" loading="lazy" />
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
                    <!-- Direct POST form — no JavaScript needed -->
                    <form method="POST" action="/furniture-website/add-to-cart.php">
                        <input type="hidden" name="product_id" value="<?= $product['id'] ?>" />
                        <input type="hidden" name="qty" value="1" />
                        <input type="hidden" name="redirect" value="/furniture-website/index.php" />
                        <button type="submit" class="btn btn-add-cart">Add to Cart</button>
                    </form>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- CRAFT BANNER -->
<section class="craft-banner">
    <div class="craft-img"><img src="https://images.unsplash.com/photo-1581539250439-c96689b516dd?w=1400&q=85" alt="Craftsmanship" /><div class="craft-overlay"></div></div>
    <div class="container craft-content">
        <div class="craft-text">
            <p class="section-eyebrow light">Our Philosophy</p>
            <h2>Built to Last.<br><em>Designed to Inspire.</em></h2>
            <p>Every Mane Furniture piece is handcrafted by master artisans using sustainably sourced materials.</p>
            <a href="/furniture-website/about.php" class="btn btn-outline-light">Discover Our Craft</a>
        </div>
        <div class="craft-features">
            <div class="craft-feature"><span class="cf-icon">🪵</span><h4>Solid Hardwood</h4><p>Sustainably sourced teak, walnut & oak.</p></div>
            <div class="craft-feature"><span class="cf-icon">🤝</span><h4>Master Artisans</h4><p>Crafted by skilled makers with 20+ years.</p></div>
            <div class="craft-feature"><span class="cf-icon">🛡️</span><h4>10-Year Warranty</h4><p>Industry-leading guarantee on all pieces.</p></div>
            <div class="craft-feature"><span class="cf-icon">🌍</span><h4>Eco-Friendly</h4><p>Zero-waste and carbon-neutral shipping.</p></div>
        </div>
    </div>
</section>

<!-- TESTIMONIALS -->
<section class="section testimonials-section">
    <div class="container">
        <div class="section-header centered">
            <p class="section-eyebrow">What Our Clients Say</p>
            <h2 class="section-title">Loved by 50,000+ Homes</h2>
        </div>
        <div class="testimonials-grid">
            <?php foreach ($testimonials as $t): ?>
            <div class="testimonial-card">
                <div class="testimonial-stars"><?= str_repeat('★', $t['rating']) ?></div>
                <p class="testimonial-text">"<?= $t['text'] ?>"</p>
                <div class="testimonial-author">
                    <div class="author-avatar"><?= $t['avatar'] ?></div>
                    <div><p class="author-name"><?= $t['name'] ?></p><p class="author-city"><?= $t['city'] ?></p></div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- NEWSLETTER -->
<section class="newsletter-section">
    <div class="container">
        <div class="newsletter-box">
            <div class="nl-text"><h3>Join the Mane Furniture Circle</h3><p>Get exclusive access to new arrivals, design tips & offers.</p></div>
            <form class="nl-form" action="subscribe.php" method="POST">
                <input type="email" name="email" placeholder="Your email address" required />
                <button type="submit" class="btn btn-primary">Subscribe</button>
            </form>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
