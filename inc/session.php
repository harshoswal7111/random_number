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

// Helper: Get generated numbers
function get_generated_numbers() {
    return isset($_SESSION['generated_numbers']) ? $_SESSION['generated_numbers'] : [];
}

// Helper: Set generated numbers
function set_generated_numbers($numbers) {
    $_SESSION['generated_numbers'] = $numbers;
}

// Helper: Get admin override sequence
function get_admin_next_numbers() {
    return isset($_SESSION['admin_next_numbers']) ? $_SESSION['admin_next_numbers'] : [];
}

// Helper: Set admin override sequence
function set_admin_next_numbers($numbers) {
    $_SESSION['admin_next_numbers'] = $numbers;
}