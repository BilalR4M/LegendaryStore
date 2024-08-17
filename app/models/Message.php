<?php

declare(strict_types=1);

namespace App\Models;

use App\Database;

final class Message
{
    /** @return list<array<string, mixed>> */
    public static function all(): array
    {
        return Database::get()->query('SELECT * FROM messages ORDER BY id DESC')->fetchAll();
    }

    public static function count(): int
    {
        return (int) Database::get()->query('SELECT COUNT(*) FROM messages')->fetchColumn();
    }

    public static function exists(string $name, string $email, string $number, string $message): bool
    {
        $stmt = Database::get()->prepare(
            'SELECT id FROM messages WHERE name = ? AND email = ? AND number = ? AND message = ?'
        );
        $stmt->execute([$name, $email, $number, $message]);

        return (bool) $stmt->fetch();
    }

    public static function create(?int $userId, string $name, string $email, string $number, string $message): void
    {
        $stmt = Database::get()->prepare(
            'INSERT INTO messages (user_id, name, email, number, message) VALUES (?, ?, ?, ?, ?)'
        );
        $stmt->execute([$userId, $name, $email, $number, $message]);
    }

    public static function delete(int $id): void
    {
        $stmt = Database::get()->prepare('DELETE FROM messages WHERE id = ?');
        $stmt->execute([$id]);
    }
}
