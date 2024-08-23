<?php

require dirname(__DIR__) . '/app/bootstrap.php';

use App\Helpers\Auth;

if (($_SERVER['REQUEST_METHOD'] ?? 'GET') !== 'POST') {
    header('Location: login.php');
    exit;
}

Auth::logout();
header('Location: login.php');
exit;
