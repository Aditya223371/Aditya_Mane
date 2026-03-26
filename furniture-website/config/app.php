<?php
/**
 * config/app.php
 * Global path constants — include this at the top of every PHP page
 * to make all file includes and asset links work from any folder depth.
 */

// Absolute filesystem path to the project root
define('ROOT_PATH', dirname(__DIR__));

// Web URL base path — change this if your folder name is different
// e.g. if you renamed the folder to "my-shop", set it to '/my-shop'
define('BASE_URL', '/furniture-website');

// Helper function for asset URLs
function asset(string $path): string {
    return BASE_URL . '/assets/' . ltrim($path, '/');
}

// Helper function for page URLs
function url(string $path): string {
    return BASE_URL . '/' . ltrim($path, '/');
}
