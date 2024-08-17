<?php

declare(strict_types=1);

namespace App\Models;

use App\Database;

final class Product
{
    /** @return list<array<string, mixed>> */
    public static function all(): array
    {
        return Database::get()->query('SELECT * FROM products ORDER BY id DESC')->fetchAll();
    }

    /** @return list<array<string, mixed>> */
    public static function latest(int $limit): array
    {
        $limit = max(1, min(50, $limit));

        return Database::get()->query('SELECT * FROM products ORDER BY id DESC LIMIT ' . $limit)->fetchAll();
    }

    /** @return array<string, mixed>|null */
    public static function find(int $id): ?array
    {
        $stmt = Database::get()->prepare('SELECT * FROM products WHERE id = ?');
        $stmt->execute([$id]);
        $row = $stmt->fetch();

        return $row === false ? null : $row;
    }

    /** @return list<array<string, mixed>> */
    public static function byCategory(string $category): array
    {
        $stmt = Database::get()->prepare('SELECT * FROM products WHERE category = ? ORDER BY id DESC');
        $stmt->execute([$category]);

        return $stmt->fetchAll();
    }

    /** @return list<array<string, mixed>> */
    public static function search(string $term): array
    {
        $stmt = Database::get()->prepare('SELECT * FROM products WHERE name LIKE ? ORDER BY id DESC');
        $stmt->execute(['%' . $term . '%']);

        return $stmt->fetchAll();
    }

    public static function nameExists(string $name, ?int $exceptId = null): bool
    {
        if ($exceptId === null) {
            $stmt = Database::get()->prepare('SELECT id FROM products WHERE name = ?');
            $stmt->execute([$name]);
        } else {
            $stmt = Database::get()->prepare('SELECT id FROM products WHERE name = ? AND id <> ?');
            $stmt->execute([$name, $exceptId]);
        }

        return (bool) $stmt->fetch();
    }

    public static function create(string $name, string $details, int $price, string $category, string $image01, string $image02, string $image03): int
    {
        $stmt = Database::get()->prepare(
            'INSERT INTO products (name, details, price, category, image_01, image_02, image_03) VALUES (?, ?, ?, ?, ?, ?, ?)'
        );
        $stmt->execute([$name, $details, $price, $category, $image01, $image02, $image03]);

        return (int) Database::get()->lastInsertId();
    }

    public static function update(int $id, string $name, string $details, int $price, string $category): void
    {
        $stmt = Database::get()->prepare(
            'UPDATE products SET name = ?, details = ?, price = ?, category = ? WHERE id = ?'
        );
        $stmt->execute([$name, $details, $price, $category, $id]);
    }

    public static function updateImage(int $id, string $slot, string $filename): void
    {
        $column = match ($slot) {
            'image_01', 'image_02', 'image_03' => $slot,
            default => throw new \InvalidArgumentException('Unknown image slot'),
        };
        $stmt = Database::get()->prepare("UPDATE products SET {$column} = ? WHERE id = ?");
        $stmt->execute([$filename, $id]);
    }

    public static function delete(int $id): void
    {
        $stmt = Database::get()->prepare('DELETE FROM products WHERE id = ?');
        $stmt->execute([$id]);
    }

    public static function count(): int
    {
        return (int) Database::get()->query('SELECT COUNT(*) FROM products')->fetchColumn();
    }
}
