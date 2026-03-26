# MANE FURNITURE — Luxury Furniture Website (PHP)
## Complete Project Documentation
### Aditya Rajendra Mane
---

## 📁 Project Structure

```
furniture-website/
├── index.php              ← Home / Landing Page
├── catalog.php            ← Product Catalog / Shop
├── product.php            ← Single Product Detail Page
├── about.php              ← About Us Page
├── contact.php            ← Contact Page
│
├── includes/
│   ├── header.php         ← Shared header + navigation
│   └── footer.php         ← Shared footer
│
├── assets/
│   ├── css/
│   │   └── style.css      ← Main stylesheet
│   └── js/
│       └── main.js        ← Main JavaScript
│
└── README.md              ← This file
```

---

## 🚀 Setup Instructions

### Requirements
- PHP 7.4+ or PHP 8.x
- Apache or Nginx web server
- (Optional) MySQL for dynamic products

### Local Development
```bash
# Option 1: PHP Built-in Server
cd furniture-website
php -S localhost:8000

# Option 2: XAMPP / WAMP / MAMP
# Copy folder to htdocs/ or www/
# Open http://localhost/furniture-website

# Option 3: Laravel Herd / Valet
# Point to the folder directory
```

### Production Deployment
1. Upload all files to your web host via FTP/SFTP
2. Point your domain to the folder
3. Ensure PHP is enabled on the server

---

## 📄 Pages Included

| Page | File | Description |
|------|------|-------------|
| Home | `index.php` | Hero, categories, featured products, testimonials, newsletter |
| Catalog | `catalog.php` | Full product grid with sidebar filters & sort |
| Product | `product.php` | Detail view with image gallery, options, accordion |
| About | `about.php` | Story, values, team, sustainability |
| Contact | `contact.php` | Contact form, info cards, map section |

---

## 🎨 Design System

### Colors
| Variable | Value | Usage |
|----------|-------|-------|
| `--cream` | `#F5F0E8` | Background |
| `--brown` | `#2C1810` | Primary text, nav |
| `--gold` | `#C4942A` | Accent, CTA |
| `--white` | `#FFFFFF` | Cards |

### Typography
- **Display / Headings**: Cormorant Garamond (Google Fonts)
- **Body / UI**: Jost (Google Fonts)

---

## 🔧 Features

### Frontend
- ✅ Fully responsive (mobile, tablet, desktop)
- ✅ Sticky header with scroll effect
- ✅ Mega dropdown navigation
- ✅ Full-screen hero with animation
- ✅ Category grid with hover effects
- ✅ Product cards with quick-view overlay
- ✅ Image gallery with thumbnail switching (product page)
- ✅ Accordion-style specs panel
- ✅ Color swatch selector
- ✅ Quantity control
- ✅ Mobile hamburger menu
- ✅ Search bar toggle
- ✅ Cart count badge
- ✅ Wishlist toggle
- ✅ Cart toast notification
- ✅ Back-to-top button
- ✅ Scroll reveal animations
- ✅ Lazy loading images

### PHP / Backend
- ✅ Shared header/footer includes
- ✅ Dynamic product data (array-based, ready for DB)
- ✅ URL-based category filtering (`?category=Living+Room`)
- ✅ URL-based sorting (`?sort=price_asc`)
- ✅ Product page via query param (`?id=1`)
- ✅ Contact form (ready to connect to mail or DB)

---

## 🗄️ Adding MySQL Database

To connect to a database, create a `config/db.php`:

```php
<?php
$host = 'localhost';
$db   = 'maison_db';
$user = 'root';
$pass = 'your_password';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
} catch (PDOException $e) {
    die('DB Error: ' . $e->getMessage());
}
```

Then in `catalog.php`, replace the `$all_products` array with:
```php
require 'config/db.php';
$stmt = $pdo->query("SELECT * FROM products WHERE status = 'active'");
$all_products = $stmt->fetchAll();
```

### MySQL Table Schema
```sql
CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    category VARCHAR(100),
    price DECIMAL(10,2),
    original_price DECIMAL(10,2),
    image VARCHAR(500),
    badge VARCHAR(50),
    rating DECIMAL(2,1) DEFAULT 0,
    reviews INT DEFAULT 0,
    description TEXT,
    sku VARCHAR(100),
    status ENUM('active','inactive') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

---

## 📧 Contact Form Processing

Create `process_contact.php`:
```php
<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name    = htmlspecialchars($_POST['first_name'] . ' ' . $_POST['last_name']);
    $email   = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $subject = htmlspecialchars($_POST['subject']);
    $message = htmlspecialchars($_POST['message']);

    $to      = 'hello@maisonliving.com';
    $headers = "From: $email\r\nReply-To: $email\r\nContent-Type: text/html\r\n";
    $body    = "<h3>New Enquiry from $name</h3><p><b>Subject:</b> $subject</p><p>$message</p>";

    if (mail($to, "Maison Enquiry: $subject", $body, $headers)) {
        header('Location: contact.php?success=1');
    } else {
        header('Location: contact.php?error=1');
    }
    exit;
}
```

---

## 🔌 Next Steps to Expand

1. **Admin Panel** — Add `admin/` folder with product CRUD, order management
2. **Cart Page** — `cart.php` with session-based cart
3. **Checkout** — `checkout.php` with payment gateway (Razorpay, Stripe)
4. **User Auth** — `login.php`, `register.php`, `my-account.php`
5. **Search** — `search.php` with MySQL `LIKE` queries
6. **CMS** — Connect to WordPress headless or build a custom CMS
7. **SEO** — Add `sitemap.xml`, meta tags, Open Graph tags per page

---

## 📞 Support

Built with ❤️ by Claude. For questions or customization, reach out via Claude.ai.
