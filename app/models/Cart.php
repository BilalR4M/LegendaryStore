<?php

declare(strict_types=1);

namespace App\Models;

use App\Database;

final class Cart
{
    public static function countFor(int $userId): int
    {
        if ($userId < 1) {
            return 0;
        }
        $stmt = Database::get()->prepare('SELECT COUNT(*) FROM cart WHERE user_id = ?');
        $stmt->execute([$userId]);

        return (int) $stmt->fetchColumn();
    }

    /** @return list<array<string, mixed>> */
    public static function forUser(int $userId): array
    {
        $stmt = Database::get()->prepare('SELECT * FROM cart WHERE user_id = ? ORDER BY id DESC');
        $stmt->execute([$userId]);

        return $stmt->fetchAll();
    }

    public static function hasProduct(int $userId, int $productId): bool
    {
        $stmt = Database::get()->prepare('SELECT id FROM cart WHERE user_id = ? AND pid = ?');
        $stmt->execute([$userId, $productId]);

        return (bool) $stmt->fetch();
    }

    public static function add(int $userId, int $productId, int $qty): string
    {
        $product = Product::find($productId);
        if ($product === null) {
            return 'product not found';
        }
        if (self::hasProduct($userId, $productId)) {
            return 'already added to cart';
        }

        Wishlist::removeProduct($userId, $productId);
        $stmt = Database::get()->prepare(
            'INSERT INTO cart (user_id, pid, name, price, quantity, image) VALUES (?, ?, ?, ?, ?, ?)'
        );
        $stmt->execute([
            $userId,
            $productId,
            $product['name'],
            $product['price'],
            $qty,
            $product['image_01'],
        ]);

        return 'added to cart';
    }

    public static function updateQty(int $id, int $userId, int $qty): void
    {
        $stmt = Database::get()->prepare('UPDATE cart SET quantity = ? WHERE id = ? AND user_id = ?');
        $stmt->execute([$qty, $id, $userId]);
    }

    public static function delete(int $id, int $userId): void
    {
        $stmt = Database::get()->prepare('DELETE FROM cart WHERE id = ? AND user_id = ?');
        $stmt->execute([$id, $userId]);
    }

    public static function clear(int $userId): void
    {
        $stmt = Database::get()->prepare('DELETE FROM cart WHERE user_id = ?');
        $stmt->execute([$userId]);
    }
}
