<?php

declare(strict_types=1);

namespace App\Models;

use App\Database;

final class Admin
{
    /** @return array<string, mixed>|null */
    public static function find(int $id): ?array
    {
        $stmt = Database::get()->prepare('SELECT * FROM admins WHERE id = ?');
        $stmt->execute([$id]);
        $row = $stmt->fetch();

        return $row === false ? null : $row;
    }

    /** @return array<string, mixed>|null */
    public static function findByName(string $name): ?array
    {
        $stmt = Database::get()->prepare('SELECT * FROM admins WHERE name = ?');
        $stmt->execute([$name]);
        $row = $stmt->fetch();

        return $row === false ? null : $row;
    }

    /** @return array<string, mixed>|null */
    public static function attempt(string $name, string $password): ?array
    {
        $admin = self::findByName($name);
        if ($admin === null || !password_verify($password, (string) $admin['password'])) {
            return null;
        }

        return $admin;
    }

    public static function create(string $name, string $password): void
    {
        $stmt = Database::get()->prepare('INSERT INTO admins (name, password) VALUES (?, ?)');
        $stmt->execute([$name, password_hash($password, PASSWORD_DEFAULT)]);
    }

    public static function updateName(int $id, string $name): void
    {
        $stmt = Database::get()->prepare('UPDATE admins SET name = ? WHERE id = ?');
        $stmt->execute([$name, $id]);
    }

    public static function updatePassword(int $id, string $password): void
    {
        $stmt = Database::get()->prepare('UPDATE admins SET password = ? WHERE id = ?');
        $stmt->execute([password_hash($password, PASSWORD_DEFAULT), $id]);
    }

    public static function delete(int $id): void
    {
        $stmt = Database::get()->prepare('DELETE FROM admins WHERE id = ?');
        $stmt->execute([$id]);
    }

    /** @return list<array<string, mixed>> */
    public static function all(): array
    {
        return Database::get()->query('SELECT id, name, created_at FROM admins ORDER BY id DESC')->fetchAll();
    }

    public static function count(): int
    {
        return (int) Database::get()->query('SELECT COUNT(*) FROM admins')->fetchColumn();
    }
}
