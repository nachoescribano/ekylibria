<?php
// router.php
if (php_sapi_name() !== 'cli-server') {
    die('This script can only be used with PHP\'s built-in server');
}

$url = parse_url($_SERVER['REQUEST_URI']);
$file = $_SERVER['DOCUMENT_ROOT'] . $url['path'];

// Static files
if (is_file($file)) {
    return false;
}

// WordPress files
if (preg_match('/\.php$/', $url['path'])) {
    // Ensure wp-admin URLs work
    if (strpos($url['path'], '/wp-admin') === 0) {
        require_once($_SERVER['DOCUMENT_ROOT'] . '/wp-admin/index.php');
        return true;
    }
    // Handle other PHP files
    require_once($_SERVER['DOCUMENT_ROOT'] . '/index.php');
    return true;
}

// All other URLs
require_once($_SERVER['DOCUMENT_ROOT'] . '/index.php'); 