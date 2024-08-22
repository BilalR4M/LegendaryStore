<?php

declare(strict_types=1);

use App\Helpers\Auth;
use App\Helpers\Csrf;
use App\Helpers\Html;

$root = dirname(__DIR__);
$autoload = $root . '/vendor/autoload.php';
if (!is_file($autoload)) {
    http_response_code(500);
    exit('Run composer install from the project directory before opening the site.');
}

require $autoload;

Auth::start();

set_exception_handler(static function (Throwable $e) use ($root): void {
    $dir = $root . '/storage';
    if (!is_dir($dir)) {
        mkdir($dir, 0775, true);
    }
    error_log(date('c') . ' ' . $e . PHP_EOL, 3, $dir . '/app.log');
    if (!headers_sent()) {
        http_response_code(500);
    }
    echo 'Something went wrong. Please try again later.';
    exit;
});

Csrf::verifyRequest();

function e(mixed $value): string
{
    return Html::e($value);
}

function csrf_field(): string
{
    return Csrf::field();
}
