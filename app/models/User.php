<?php

declare(strict_types=1);

namespace App\Models;

use App\Database;

final class User
{
    /** @return array<string, mixed>|null */
    public static function find(int $id): ?array
    {
        $stmt = Database::get()->prepare('SELECT * FROM users WHERE id = ?');
        $stmt->execute([$id]);
        $row = $stmt->fetch();

        return $row === false ? null : $row;
    }

    /** @return array<string, mixed>|null */
    public static function findByEmail(string $email): ?array
    {
        $stmt = Database::get()->prepare('SELECT * FROM users WHERE email = ?');
        $stmt->execute([$email]);
        $row = $stmt->fetch();

        return $row === false ? null : $row;
    }

    /** @return array<string, mixed>|null */
    public static function attempt(string $email, string $password): ?array
    {
        $user = self::findByEmail($email);
        if ($user === null || !password_verify($password, (string) $user['password'])) {
            return null;
        }

        return $user;
    }

    public static function emailTaken(string $email, ?int $exceptId = null): bool
    {
        $user = self::findByEmail($email);

        return $user !== null && (int) $user['id'] !== $exceptId;
    }

    public static function create(string $name, string $email, string $password): void
    {
        $stmt = Database::get()->prepare('INSERT INTO users (name, email, password) VALUES (?, ?, ?)');
        $stmt->execute([$name, $email, password_hash($password, PASSWORD_DEFAULT)]);
    }

    public static function updateProfile(int $id, string $name, string $email): void
    {
        $stmt = Database::get()->prepare('UPDATE users SET name = ?, email = ? WHERE id = ?');
        $stmt->execute([$name, $email, $id]);
    }

    public static function updatePassword(int $id, string $password): void
    {
        $stmt = Database::get()->prepare('UPDATE users SET password = ? WHERE id = ?');
        $stmt->execute([password_hash($password, PASSWORD_DEFAULT), $id]);
    }

    public static function delete(int $id): void
    {
        $pdo = Database::get();
        $pdo->beginTransaction();
        try {
            $orders = $pdo->prepare('SELECT id FROM orders WHERE user_id = ?');
            $orders->execute([$id]);
            $orderIds = $orders->fetchAll(\PDO::FETCH_COLUMN);
            if ($orderIds !== []) {
                $placeholders = implode(',', array_fill(0, count($orderIds), '?'));
                $pdo->prepare("DELETE FROM order_items WHERE order_id IN ($placeholders)")->execute($orderIds);
                $pdo->prepare('DELETE FROM orders WHERE user_id = ?')->execute([$id]);
            }
            $pdo->prepare('DELETE FROM users WHERE id = ?')->execute([$id]);
            $pdo->commit();
        } catch (\Throwable $e) {
            if ($pdo->inTransaction()) {
                $pdo->rollBack();
            }
            throw $e;
        }
    }

    /** @return list<array<string, mixed>> */
    public static function all(): array
    {
        return Database::get()->query('SELECT id, name, email, created_at FROM users ORDER BY id DESC')->fetchAll();
    }

    public static function count(): int
    {
        return (int) Database::get()->query('SELECT COUNT(*) FROM users')->fetchColumn();
    }
}
