-- ============================================================
--  MAISON FURNITURE — Complete MySQL Database Schema
--  Run this in phpMyAdmin or via: mysql -u root -p < schema.sql
-- ============================================================

CREATE DATABASE IF NOT EXISTS maison_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE maison_db;

-- ── USERS ────────────────────────────────────────────────────
CREATE TABLE users (
    id           INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    first_name   VARCHAR(100)  NOT NULL,
    last_name    VARCHAR(100)  NOT NULL,
    email        VARCHAR(255)  NOT NULL UNIQUE,
    phone        VARCHAR(20),
    password     VARCHAR(255)  NOT NULL,
    role         ENUM('customer','admin') DEFAULT 'customer',
    status       ENUM('active','inactive','banned') DEFAULT 'active',
    marketing    TINYINT(1) DEFAULT 1,
    last_login   DATETIME,
    created_at   TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at   TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_email (email),
    INDEX idx_role  (role)
);

-- Default admin user (password: Admin@1234 — CHANGE IMMEDIATELY)
INSERT INTO users (first_name, last_name, email, password, role, status)
VALUES ('Admin', 'Maison', 'admin@maisonliving.com',
        '$2y$12$LfWw1Q5Vq6VcHpZ1Z2G3IuUWM2vE1kK9nXyZwE4Y0pA2D3vR8Ld5i',
        'admin', 'active');

-- ── CATEGORIES ───────────────────────────────────────────────
CREATE TABLE categories (
    id          INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name        VARCHAR(100) NOT NULL,
    slug        VARCHAR(120) NOT NULL UNIQUE,
    icon        VARCHAR(10),
    description TEXT,
    image_url   VARCHAR(500),
    sort_order  INT DEFAULT 0,
    status      ENUM('active','inactive') DEFAULT 'active',
    created_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO categories (name, slug, icon, sort_order) VALUES
('Living Room', 'living-room', '🛋️', 1),
('Bedroom',     'bedroom',     '🛏️', 2),
('Office',      'office',      '💼', 3),
('Outdoor',     'outdoor',     '🌿', 4),
('Dining',      'dining',      '🍽️', 5);

-- ── PRODUCTS ─────────────────────────────────────────────────
CREATE TABLE products (
    id             INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    category_id    INT UNSIGNED,
    name           VARCHAR(255) NOT NULL,
    slug           VARCHAR(280) NOT NULL UNIQUE,
    sku            VARCHAR(100) UNIQUE,
    description    TEXT,
    price          DECIMAL(10,2) NOT NULL,
    original_price DECIMAL(10,2),
    stock          INT DEFAULT 0,
    badge          ENUM('Bestseller','New','Sale','Premium') DEFAULT NULL,
    rating         DECIMAL(2,1) DEFAULT 0.0,
    review_count   INT DEFAULT 0,
    materials      VARCHAR(255),
    dimensions     JSON,            -- {"width":"80cm","depth":"85cm","height":"90cm"}
    colors         JSON,            -- ["Cognac Brown","Onyx Black","Sage Green"]
    weight_kg      DECIMAL(6,2),
    status         ENUM('active','inactive','draft') DEFAULT 'active',
    featured       TINYINT(1) DEFAULT 0,
    created_at     TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at     TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE SET NULL,
    INDEX idx_category (category_id),
    INDEX idx_status   (status),
    INDEX idx_featured (featured),
    FULLTEXT idx_search (name, description)
);

-- ── PRODUCT IMAGES ───────────────────────────────────────────
CREATE TABLE product_images (
    id          INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    product_id  INT UNSIGNED NOT NULL,
    image_url   VARCHAR(500) NOT NULL,
    alt_text    VARCHAR(255),
    sort_order  INT DEFAULT 0,
    is_primary  TINYINT(1) DEFAULT 0,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE,
    INDEX idx_product (product_id)
);

-- ── ORDERS ───────────────────────────────────────────────────
CREATE TABLE orders (
    id                    INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id               INT UNSIGNED,
    razorpay_payment_id   VARCHAR(100),
    razorpay_order_id     VARCHAR(100),
    razorpay_signature    VARCHAR(255),
    ship_name             VARCHAR(200) NOT NULL,
    ship_email            VARCHAR(255) NOT NULL,
    ship_phone            VARCHAR(20),
    ship_addr1            VARCHAR(300) NOT NULL,
    ship_addr2            VARCHAR(300),
    ship_city             VARCHAR(100) NOT NULL,
    ship_state            VARCHAR(100) NOT NULL,
    ship_pin              VARCHAR(10)  NOT NULL,
    delivery_notes        TEXT,
    order_note            TEXT,
    coupon_code           VARCHAR(50),
    discount              DECIMAL(10,2) DEFAULT 0,
    subtotal              DECIMAL(10,2) NOT NULL,
    delivery              DECIMAL(10,2) DEFAULT 0,
    gst                   DECIMAL(10,2) DEFAULT 0,
    total                 DECIMAL(10,2) NOT NULL,
    status                ENUM('pending','paid','processing','shipped','delivered','cancelled','refunded') DEFAULT 'pending',
    payment_method        ENUM('razorpay','cod','emi') DEFAULT 'razorpay',
    tracking_number       VARCHAR(100),
    shipped_at            DATETIME,
    delivered_at          DATETIME,
    created_at            TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at            TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL,
    INDEX idx_user   (user_id),
    INDEX idx_status (status),
    INDEX idx_created(created_at)
);

-- ── ORDER ITEMS ──────────────────────────────────────────────
CREATE TABLE order_items (
    id           INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    order_id     INT UNSIGNED NOT NULL,
    product_id   INT UNSIGNED,
    product_name VARCHAR(255) NOT NULL,
    sku          VARCHAR(100),
    color        VARCHAR(100),
    price        DECIMAL(10,2) NOT NULL,
    qty          INT NOT NULL,
    line_total   DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (order_id)   REFERENCES orders(id)   ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE SET NULL,
    INDEX idx_order (order_id)
);

-- ── COUPONS ──────────────────────────────────────────────────
CREATE TABLE coupons (
    id            INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    code          VARCHAR(50) NOT NULL UNIQUE,
    type          ENUM('percent','fixed') DEFAULT 'percent',
    value         DECIMAL(10,2) NOT NULL,
    min_order     DECIMAL(10,2) DEFAULT 0,
    max_uses      INT DEFAULT NULL,
    used_count    INT DEFAULT 0,
    expires_at    DATETIME DEFAULT NULL,
    status        ENUM('active','inactive') DEFAULT 'active',
    created_at    TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO coupons (code, type, value, min_order, status) VALUES
('MAISON10',  'percent', 10,    0,      'active'),
('WELCOME',   'percent', 15,    0,      'active'),
('FREESHIP',  'fixed',   2500,  0,      'active'),
('LUXURY500', 'fixed',   500,   20000,  'active');

-- ── REVIEWS ──────────────────────────────────────────────────
CREATE TABLE reviews (
    id          INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    product_id  INT UNSIGNED NOT NULL,
    user_id     INT UNSIGNED,
    order_id    INT UNSIGNED,
    name        VARCHAR(100) NOT NULL,
    city        VARCHAR(100),
    rating      TINYINT NOT NULL CHECK (rating BETWEEN 1 AND 5),
    title       VARCHAR(255),
    body        TEXT,
    status      ENUM('pending','approved','rejected') DEFAULT 'pending',
    created_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id)    REFERENCES users(id)    ON DELETE SET NULL,
    INDEX idx_product (product_id),
    INDEX idx_status  (status)
);

-- ── WISHLIST ─────────────────────────────────────────────────
CREATE TABLE wishlist (
    id          INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id     INT UNSIGNED NOT NULL,
    product_id  INT UNSIGNED NOT NULL,
    created_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id)    REFERENCES users(id)    ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE,
    UNIQUE KEY uk_user_product (user_id, product_id)
);

-- ── NEWSLETTER ───────────────────────────────────────────────
CREATE TABLE newsletter_subscribers (
    id          INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    email       VARCHAR(255) NOT NULL UNIQUE,
    status      ENUM('subscribed','unsubscribed') DEFAULT 'subscribed',
    created_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- ── ORDER STATUS LOG ─────────────────────────────────────────
CREATE TABLE order_status_log (
    id          INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    order_id    INT UNSIGNED NOT NULL,
    status      VARCHAR(50)  NOT NULL,
    note        TEXT,
    created_by  INT UNSIGNED,
    created_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE
);

-- ============================================================
-- End of schema
-- ============================================================
