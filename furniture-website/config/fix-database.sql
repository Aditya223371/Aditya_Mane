-- ============================================================
-- fix-database.sql
-- Run this in phpMyAdmin if you get foreign key errors on checkout
-- ============================================================
USE maison_db;

-- Step 1: Drop the problematic foreign key constraint on order_items
SET FOREIGN_KEY_CHECKS = 0;

-- Drop and recreate order_items without strict product_id FK
DROP TABLE IF EXISTS order_items;
CREATE TABLE order_items (
    id           INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    order_id     INT UNSIGNED NOT NULL,
    product_id   INT UNSIGNED DEFAULT NULL,
    product_name VARCHAR(255) NOT NULL,
    sku          VARCHAR(100) DEFAULT NULL,
    color        VARCHAR(100) DEFAULT NULL,
    price        DECIMAL(10,2) NOT NULL,
    qty          INT NOT NULL,
    line_total   DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
    INDEX idx_order (order_id)
);

-- Step 2: Insert all 12 products into products table
-- (so future foreign key references work)
INSERT IGNORE INTO products (id, category_id, name, slug, sku, price, stock, status, featured, created_at) VALUES
(1,  1, 'Aria Lounge Chair',    'aria-lounge-chair',    'MF-001', 1299, 10, 'active', 1, NOW()),
(2,  2, 'Nordic Oak Bed Frame', 'nordic-oak-bed-frame', 'MF-002', 2199, 5,  'active', 1, NOW()),
(3,  3, 'Executive Walnut Desk','executive-walnut-desk','MF-003', 1849, 8,  'active', 1, NOW()),
(4,  5, 'Terrazzo Dining Table','terrazzo-dining-table','MF-004', 3499, 4,  'active', 1, NOW()),
(5,  1, 'Velvet Sofa Sage',     'velvet-sofa-sage',     'MF-005', 2799, 6,  'active', 1, NOW()),
(6,  4, 'Garden Teak Lounger',  'garden-teak-lounger',  'MF-006', 899,  12, 'active', 0, NOW()),
(7,  1, 'Marble Console Table', 'marble-console-table', 'MF-007', 1499, 7,  'active', 0, NOW()),
(8,  2, 'Linen Platform Bed',   'linen-platform-bed',   'MF-008', 1899, 5,  'active', 0, NOW()),
(9,  3, 'Ergonomic Study Chair','ergonomic-study-chair','MF-009', 699,  15, 'active', 0, NOW()),
(10, 4, 'Rattan Accent Chair',  'rattan-accent-chair',  'MF-010', 549,  10, 'active', 0, NOW()),
(11, 1, 'Herringbone Bookcase', 'herringbone-bookcase', 'MF-011', 1149, 8,  'active', 0, NOW()),
(12, 5, 'Stone Dining Bench',   'stone-dining-bench',   'MF-012', 799,  9,  'active', 0, NOW());

SET FOREIGN_KEY_CHECKS = 1;

SELECT 'Fix applied successfully! You can now checkout.' AS message;

-- Add updated_at and cancel_reason columns if they don't exist
ALTER TABLE orders 
    ADD COLUMN IF NOT EXISTS updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    ADD COLUMN IF NOT EXISTS cancel_reason VARCHAR(255) DEFAULT NULL;

SELECT 'Database fully updated!' AS message;
