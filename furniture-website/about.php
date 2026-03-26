<?php
if (session_status() === PHP_SESSION_NONE) session_start();
define('SITE_NAME', 'MANE FURNITURE');
define('SITE_TAGLINE', 'Luxury Furniture & Living');
$page_title = 'About Us';
include 'includes/header.php';
?>

<section class="page-banner">
    <div class="container">
        <div class="breadcrumb"><a href="index.php">Home</a><span>›</span><span>About</span></div>
        <h1>Our Story</h1>
        <p>Fifteen years of crafting spaces where lives unfold.</p>
    </div>
</section>

<!-- STORY -->
<section class="about-story">
    <div class="container">
        <div class="story-grid">
            <div class="story-img-wrap">
                <img src="https://images.unsplash.com/photo-1581539250439-c96689b516dd?w=700&q=85" alt="Our Workshop" />
                <div class="story-badge">Est. 2010 · Mumbai</div>
            </div>
            <div class="story-text">
                <p class="section-eyebrow">Who We Are</p>
                <h2 class="section-title">Born from a Passion for Beautiful Living</h2>
                <p>Mane Furniture was founded in 2010 by the Mane family in Pune, Maharashtra. Their vision was simple: to create furniture of exceptional quality that would be passed down through generations.</p>
                <p>Today, we operate across three showrooms in India's major cities, with a team of 150 master craftspeople and a collection of over 200 signature pieces. Yet our founding values remain unchanged — every piece is handcrafted with the same care and intention as the very first.</p>
                <div class="story-stats">
                    <div class="sstats"><span class="ss-num">15+</span><span class="ss-label">Years of Craft</span></div>
                    <div class="sstats"><span class="ss-num">150</span><span class="ss-label">Artisans</span></div>
                    <div class="sstats"><span class="ss-num">50K+</span><span class="ss-label">Happy Homes</span></div>
                    <div class="sstats"><span class="ss-num">3</span><span class="ss-label">Showrooms</span></div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- VALUES -->
<section class="values-section" id="craftsmanship">
    <div class="container">
        <div class="section-header centered">
            <p class="section-eyebrow">What We Stand For</p>
            <h2 class="section-title">Our Values</h2>
        </div>
        <div class="values-grid">
            <div class="value-card">
                <div class="value-num">01</div>
                <h3>Craftsmanship First</h3>
                <p>Every joint, every finish, every curve is considered. Our artisans spend years mastering techniques passed down through generations to ensure every piece is truly exceptional.</p>
            </div>
            <div class="value-card">
                <div class="value-num">02</div>
                <h3>Sustainable Materials</h3>
                <p>We source only from certified sustainable forests and work with suppliers who share our commitment to protecting the planet for future generations.</p>
            </div>
            <div class="value-card">
                <div class="value-num">03</div>
                <h3>Timeless Design</h3>
                <p>We don't chase trends. We design pieces that transcend time — furniture that feels as current and beautiful in 30 years as it does today.</p>
            </div>
            <div class="value-card">
                <div class="value-num">04</div>
                <h3>Customer Partnership</h3>
                <p>We see ourselves as partners in creating your ideal home — from the first design consultation to white-glove delivery and beyond.</p>
            </div>
        </div>
    </div>
</section>

<!-- TEAM -->
<section class="team-section">
    <div class="container">
        <div class="section-header centered">
            <p class="section-eyebrow">The Founders</p>
            <h2 class="section-title">Meet the People Behind Mane Furniture</h2>
        </div>
        <div class="team-grid">
            <div class="team-card">
                <div class="team-img">
                    <img src="https://images.unsplash.com/photo-1560250097-0b93528c311a?w=400&q=80" alt="Aditya Mane" />
                </div>
                <h3>Aditya Mane</h3>
                <p class="team-role">Co-Founder & Operations Director</p>
                <p>Aditya leads Mane Furniture with a bold vision for luxury living spaces, combining modern design sensibility with traditional Indian craftsmanship.</p>
            </div>
            <div class="team-card">
                <div class="team-img">
                    <img src="https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?w=400&q=80" alt="Akanksha Naigade" />
                </div>
                <h3>Akanksha Naigade</h3>
                <p class="team-role">Co-Founder & Operations Director</p>
                <p>Akanksha Naigade oversees all operations and supply chain, ensuring every piece of Mane Furniture meets the highest standards of quality and timely delivery.</p>
            </div>
            <div class="team-card">
                <div class="team-img">
                    <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=400&q=80" alt="Manohar Mane" />
                </div>
                <h3>Manohar Mane</h3>
                <p class="team-role">Master Craftsman & Founder</p>
                <p>With over 30 years of woodworking expertise, Manohar is the heart of Mane Furniture, personally overseeing the craftsmanship of every signature piece.</p>
            </div>
        </div>
    </div>
</section>

<!-- SUSTAINABILITY -->
<section class="sustainability-section" id="sustainability">
    <div class="container sus-grid">
        <div class="sus-text">
            <p class="section-eyebrow">Our Planet</p>
            <h2 class="section-title">Built Responsibly</h2>
            <p>Every decision we make is filtered through the question: "Is this good for the planet?" From the forests we source from, to the oils we finish with, to the packaging we ship in — sustainability is not a feature, it's our foundation.</p>
            <ul class="sus-list">
                <li>✦ 100% sustainably sourced wood from FSC-certified forests</li>
                <li>✦ Zero-waste manufacturing with wood offcuts donated to local artisans</li>
                <li>✦ Carbon-neutral shipping on all orders within India</li>
                <li>✦ Biodegradable and recycled packaging materials</li>
                <li>✦ Water-based, non-toxic finishes and adhesives throughout</li>
            </ul>
        </div>
        <div class="sus-img">
            <img src="https://images.unsplash.com/photo-1441974231531-c6227db76b6e?w=700&q=80" alt="Forest" />
        </div>
    </div>
</section>

<style>
.about-story { padding: 5rem 0; }
.story-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 5rem; align-items: center; }
.story-img-wrap { position: relative; }
.story-img-wrap img { width: 100%; border-radius: var(--radius-lg); box-shadow: var(--shadow-lg); }
.story-badge { position: absolute; bottom: 2rem; right: -1.5rem; background: var(--gold); color: var(--white); padding: 0.75rem 1.5rem; border-radius: var(--radius); font-size: 0.8rem; font-weight: 500; letter-spacing: 0.1em; }
.story-text p { color: var(--text-mid); margin-bottom: 1rem; }
.story-text .section-title { margin: 0.5rem 0 1.5rem; }
.story-stats { display: grid; grid-template-columns: repeat(4, 1fr); gap: 1.5rem; margin-top: 2rem; padding-top: 2rem; border-top: 1px solid var(--border); }
.sstats { text-align: center; }
.ss-num { display: block; font-family: var(--font-serif); font-size: 2rem; font-weight: 600; color: var(--gold); }
.ss-label { font-size: 0.72rem; text-transform: uppercase; letter-spacing: 0.1em; color: var(--text-light); }
.values-section { padding: 5rem 0; background: var(--cream); }
.values-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 2rem; margin-top: 3rem; }
.value-card { background: var(--white); border-radius: var(--radius-lg); padding: 2rem; box-shadow: var(--shadow); transition: transform var(--transition); }
.value-card:hover { transform: translateY(-5px); }
.value-num { font-family: var(--font-serif); font-size: 3rem; color: var(--cream-dark); font-weight: 600; line-height: 1; margin-bottom: 1rem; }
.value-card h3 { font-family: var(--font-serif); font-size: 1.15rem; color: var(--brown); margin-bottom: 0.75rem; }
.value-card p { font-size: 0.85rem; color: var(--text-light); line-height: 1.7; }
.team-section { padding: 5rem 0; }
.team-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 2rem; margin-top: 3rem; }
.team-card { text-align: center; }
.team-img { width: 180px; height: 180px; border-radius: 50%; overflow: hidden; margin: 0 auto 1.25rem; border: 4px solid var(--gold); }
.team-img img { width: 100%; height: 100%; object-fit: cover; }
.team-card h3 { font-family: var(--font-serif); font-size: 1.3rem; color: var(--brown); }
.team-role { font-size: 0.78rem; color: var(--gold); text-transform: uppercase; letter-spacing: 0.1em; margin: 0.35rem 0 0.75rem; }
.team-card > p { font-size: 0.85rem; color: var(--text-light); line-height: 1.7; }
.sustainability-section { padding: 5rem 0; background: var(--cream); }
.sus-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 5rem; align-items: center; }
.sus-text p { color: var(--text-mid); margin-bottom: 1.5rem; }
.sus-list { list-style: none; }
.sus-list li { padding: 0.5rem 0; font-size: 0.9rem; color: var(--text-mid); border-bottom: 1px solid var(--border); }
.sus-img img { width: 100%; border-radius: var(--radius-lg); box-shadow: var(--shadow-lg); }
@media (max-width: 900px) {
    .story-grid, .sus-grid { grid-template-columns: 1fr; }
    .values-grid { grid-template-columns: repeat(2, 1fr); }
    .team-grid { grid-template-columns: 1fr 1fr; }
    .story-stats { grid-template-columns: repeat(2, 1fr); }
    .story-badge { right: 0; }
}
@media (max-width: 600px) {
    .values-grid, .team-grid { grid-template-columns: 1fr; }
}
</style>

<?php
if (session_status() === PHP_SESSION_NONE) session_start(); include 'includes/footer.php'; ?>
