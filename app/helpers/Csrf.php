<?php

declare(strict_types=1);

namespace App\Helpers;

final class Csrf
{
    public static function token(): string
    {
        if (empty($_SESSION['_csrf']) || !is_string($_SESSION['_csrf'])) {
            $_SESSION['_csrf'] = bin2hex(random_bytes(32));
        }

        return $_SESSION['_csrf'];
    }

    public static function field(): string
    {
        return '<input type="hidden" name="_csrf" value="' . Html::e(self::token()) . '">';
    }

    public static function verifyRequest(): void
    {
        if (($_SERVER['REQUEST_METHOD'] ?? 'GET') !== 'POST') {
            return;
        }

        $sent = $_POST['_csrf'] ?? '';
        $known = $_SESSION['_csrf'] ?? '';
        if (!is_string($sent) || !is_string($known) || $known === '' || !hash_equals($known, $sent)) {
            http_response_code(400);
            exit('Invalid request.');
        }
    }
}
