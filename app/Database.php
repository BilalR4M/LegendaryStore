<?php

declare(strict_types=1);

namespace App;

use PDO;
use RuntimeException;

final class Database
{
    private static ?PDO $pdo = null;

    public static function get(): PDO
    {
        if (!self::$pdo) {
            $path = __DIR__ . '/config/config.php';
            if (!is_file($path)) {
                throw new RuntimeException('Missing app/config/config.php. Copy config.example.php and update it.');
            }

            $config = require $path;
            $c = $config['db'] ?? null;
            if (!is_array($c)) {
                throw new RuntimeException('Database settings are missing from config.php.');
            }

            self::$pdo = new PDO(
                "mysql:host={$c['host']};dbname={$c['name']};charset=utf8mb4",
                (string) $c['user'],
                (string) $c['pass'],
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false,
                ]
            );
        }

        return self::$pdo;
    }
}
