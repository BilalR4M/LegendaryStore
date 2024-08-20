<?php

declare(strict_types=1);

namespace App\Helpers;

final class Auth
{
    public static function start(): void
    {
        if (session_status() === PHP_SESSION_ACTIVE) {
            return;
        }

        session_set_cookie_params([
            'httponly' => true,
            'samesite' => 'Lax',
            'path' => '/',
        ]);
        session_start();
    }

    public static function userId(): int
    {
        return isset($_SESSION['user_id']) ? (int) $_SESSION['user_id'] : 0;
    }

    public static function adminId(): int
    {
        return isset($_SESSION['admin_id']) ? (int) $_SESSION['admin_id'] : 0;
    }

    public static function requireAdmin(): void
    {
        if (self::adminId() < 1) {
            header('Location: login.php');
            exit;
        }
    }

    public static function requireUser(): void
    {
        if (self::userId() < 1) {
            header('Location: login.php');
            exit;
        }
    }

    public static function loginUser(int $id): void
    {
        session_regenerate_id(true);
        $_SESSION['user_id'] = $id;
    }

    public static function loginAdmin(int $id): void
    {
        session_regenerate_id(true);
        $_SESSION['admin_id'] = $id;
    }

    public static function logout(): void
    {
        $_SESSION = [];
        if (ini_get('session.use_cookies')) {
            $params = session_get_cookie_params();
            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params['path'],
                $params['domain'],
                (bool) $params['secure'],
                (bool) $params['httponly']
            );
        }
        session_destroy();
    }
}
