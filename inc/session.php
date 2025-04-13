<?php
// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Helper: Check if admin is logged in
function is_admin_logged_in() {
    return isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true;
}

// Helper: Log in admin
function admin_login() {
    $_SESSION['admin_logged_in'] = true;
}

// Helper: Log out admin
function admin_logout() {
    unset($_SESSION['admin_logged_in']);
}