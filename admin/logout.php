<?php
require_once __DIR__ . '/../inc/session.php';
require_once __DIR__ . '/../inc/state.php';
admin_logout();
header('Location: login.php');
exit;