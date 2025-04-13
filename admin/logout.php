<?php
require_once __DIR__ . '/../inc/session.php';
admin_logout();
header('Location: login.php');
exit;