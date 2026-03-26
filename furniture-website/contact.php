<?php
if (session_status() === PHP_SESSION_NONE) session_start();
define('SITE_NAME', 'MANE FURNITURE');
define('SITE_TAGLINE', 'Luxury Furniture & Living');
$page_title = 'Contact Us';
include 'includes/header.php';
?>

<section class="page-banner">
    <div class="container">
        <div class="breadcrumb"><a href="index.php">Home</a><span>›</span><span>Contact</span></div>
        <h1>Get in Touch</h1>
        <p>Our design consultants are here to help you create your perfect space.</p>
    </div>
</section>

<section class="contact-section">
    <div class="container contact-grid">
        <!-- INFO -->
        <div class="contact-info">
            <h2>We'd Love to Hear From You</h2>
            <p>Whether you need design advice, want to visit a showroom, or have questions about your order — our team is ready to assist.</p>

            <div class="contact-cards">
                <div class="contact-card">
                    <div class="cc-icon">📍</div>
                    <h4>Showrooms</h4>
                    <p>Mumbai: BKC, Bandra Kurla Complex<br>Delhi: Khan Market<br>Bangalore: UB City</p>
                </div>
                <div class="contact-card">
                    <div class="cc-icon">📞</div>
                    <h4>Call Us</h4>
                    <p>+91 98765 43210<br>Mon – Sat: 10am – 7pm</p>
                </div>
                <div class="contact-card">
                    <div class="cc-icon">✉️</div>
                    <h4>Email</h4>
                    <p>hello@manefurniture.com<br>We respond within 24 hours</p>
                </div>
                <div class="contact-card">
                    <div class="cc-icon">🎨</div>
                    <h4>Design Consultation</h4>
                    <p>Book a free 1-hour session with our interior design experts.</p>
                </div>
            </div>
        </div>

        <!-- FORM -->
        <div class="contact-form-wrap">
            <h3>Send Us a Message</h3>
            <div id="formSuccess" style="display:none;" class="form-success">
                ✓ Thank you! Your message has been sent. We'll get back to you soon.
            </div>
            <form id="contactForm" action="process_contact.php" method="POST">
                <div class="form-row">
                    <div class="form-group">
                        <label>First Name *</label>
                        <input type="text" name="first_name" required placeholder="Priya" />
                    </div>
                    <div class="form-group">
                        <label>Last Name *</label>
                        <input type="text" name="last_name" required placeholder="Sharma" />
                    </div>
                </div>
                <div class="form-group">
                    <label>Email Address *</label>
                    <input type="email" name="email" required placeholder="priya@example.com" />
                </div>
                <div class="form-group">
                    <label>Phone Number</label>
                    <input type="tel" name="phone" placeholder="+91 98765 43210" />
                </div>
                <div class="form-group">
                    <label>Subject *</label>
                    <select name="subject" required>
                        <option value="">Select a topic...</option>
                        <option>Product Enquiry</option>
                        <option>Order Tracking</option>
                        <option>Design Consultation</option>
                        <option>Return / Exchange</option>
                        <option>Bulk / Corporate Orders</option>
                        <option>Other</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Message *</label>
                    <textarea name="message" rows="5" required placeholder="Tell us how we can help you..."></textarea>
                </div>
                <button type="submit" class="btn btn-primary" style="width:100%; justify-content:center;">Send Message</button>
            </form>
        </div>
    </div>
</section>

<!-- MAP PLACEHOLDER -->
<div class="map-section">
    <div class="map-placeholder">
        <div class="map-label">
            <span class="map-pin">📍</span>
            <div>
                <h4>Mane Furniture Mumbai Flagship</h4>
                <p>Bandra Kurla Complex, Mumbai 400051</p>
            </div>
        </div>
        <img src="https://images.unsplash.com/photo-1524661135-423995f22d0b?w=1400&q=80" alt="Our Location" style="width:100%;height:400px;object-fit:cover;opacity:0.6;" />
    </div>
</div>

<style>
.contact-section { padding: 5rem 0; }
.contact-grid { display: grid; grid-template-columns: 1fr 1.2fr; gap: 4rem; align-items: start; }
.contact-info h2 { font-family: var(--font-serif); font-size: 2rem; font-weight: 400; color: var(--brown); margin-bottom: 1rem; }
.contact-info > p { color: var(--text-light); margin-bottom: 2rem; }
.contact-cards { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }
.contact-card { background: var(--cream); border-radius: var(--radius-lg); padding: 1.25rem; border-left: 3px solid var(--gold); }
.cc-icon { font-size: 1.5rem; margin-bottom: 0.5rem; }
.contact-card h4 { font-family: var(--font-serif); font-size: 1rem; color: var(--brown); margin-bottom: 0.35rem; }
.contact-card p { font-size: 0.82rem; color: var(--text-light); line-height: 1.6; }
.contact-form-wrap { background: var(--white); border-radius: var(--radius-lg); padding: 2.5rem; box-shadow: var(--shadow-lg); border: 1px solid var(--border); }
.contact-form-wrap h3 { font-family: var(--font-serif); font-size: 1.5rem; color: var(--brown); margin-bottom: 1.5rem; }
.form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }
.form-group { margin-bottom: 1.25rem; }
.form-group label { display: block; font-size: 0.78rem; font-weight: 500; letter-spacing: 0.06em; text-transform: uppercase; color: var(--text-mid); margin-bottom: 0.4rem; }
.form-group input, .form-group select, .form-group textarea {
    width: 100%; padding: 0.8rem 1rem; border: 1.5px solid var(--border); border-radius: var(--radius);
    font-family: var(--font-sans); font-size: 0.9rem; color: var(--text); background: var(--off-white);
    outline: none; transition: border-color var(--transition); resize: vertical;
}
.form-group input:focus, .form-group select:focus, .form-group textarea:focus { border-color: var(--gold); background: var(--white); }
.form-success { background: #E8F5E9; color: #2E7D32; padding: 1rem 1.25rem; border-radius: var(--radius); margin-bottom: 1.5rem; font-size: 0.9rem; }
.map-section { position: relative; overflow: hidden; background: var(--cream); }
.map-placeholder { position: relative; }
.map-label { position: absolute; top: 2rem; left: 2rem; z-index: 10; background: var(--white); border-radius: var(--radius-lg); padding: 1rem 1.25rem; display: flex; align-items: center; gap: 0.75rem; box-shadow: var(--shadow-lg); }
.map-pin { font-size: 1.5rem; }
.map-label h4 { font-family: var(--font-serif); font-size: 1rem; color: var(--brown); }
.map-label p { font-size: 0.8rem; color: var(--text-light); }
@media (max-width: 900px) { .contact-grid { grid-template-columns: 1fr; } .contact-cards { grid-template-columns: 1fr; } }
@media (max-width: 500px) { .form-row { grid-template-columns: 1fr; } }
</style>

<?php
if (session_status() === PHP_SESSION_NONE) session_start(); include 'includes/footer.php'; ?>
