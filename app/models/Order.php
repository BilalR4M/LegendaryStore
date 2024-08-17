<?php

declare(strict_types=1);

namespace App\Models;

use App\Database;

final class Order
{
    /**
     * @param list<array<string, mixed>> $items
     */
    public static function place(int $userId, string $name, string $number, string $email, string $method, string $address): bool
    {
        $items = Cart::forUser($userId);
        if ($items === []) {
            return false;
        }

        $pdo = Database::get();
        $pdo->beginTransaction();
        try {
            $total = 0;
            foreach ($items as $item) {
                $total += (int) $item['price'] * (int) $item['quantity'];
            }

            $stmt = $pdo->prepare(
                'INSERT INTO orders (user_id, name, number, email, method, address, total_price, placed_on) VALUES (?, ?, ?, ?, ?, ?, ?, CURDATE())'
            );
            $stmt->execute([$userId, $name, $number, $email, $method, $address, $total]);
            $orderId = (int) $pdo->lastInsertId();

            $itemStmt = $pdo->prepare(
                'INSERT INTO order_items (order_id, product_id, name, quantity, unit_price) VALUES (?, ?, ?, ?, ?)'
            );
            foreach ($items as $item) {
                $itemStmt->execute([
                    $orderId,
                    $item['pid'],
                    $item['name'],
                    $item['quantity'],
                    $item['price'],
                ]);
            }

            Cart::clear($userId);
            $pdo->commit();

            return true;
        } catch (\Throwable $e) {
            if ($pdo->inTransaction()) {
                $pdo->rollBack();
            }
            throw $e;
        }
    }

    /** @return list<array<string, mixed>> */
    public static function forUser(int $userId): array
    {
        $stmt = Database::get()->prepare('SELECT * FROM orders WHERE user_id = ? ORDER BY id DESC');
        $stmt->execute([$userId]);

        return $stmt->fetchAll();
    }

    /** @return list<array<string, mixed>> */
    public static function all(): array
    {
        return Database::get()->query('SELECT * FROM orders ORDER BY id DESC')->fetchAll();
    }

    /** @return list<array<string, mixed>> */
    public static function items(int $orderId): array
    {
        $stmt = Database::get()->prepare(
            'SELECT name, quantity, unit_price FROM order_items WHERE order_id = ? ORDER BY id'
        );
        $stmt->execute([$orderId]);

        return $stmt->fetchAll();
    }

    public static function itemsLabel(int $orderId): string
    {
        $parts = [];
        foreach (self::items($orderId) as $item) {
            $parts[] = $item['name'] . ' (' . $item['unit_price'] . ' x ' . $item['quantity'] . ')';
        }

        return implode(' - ', $parts);
    }

    public static function updateStatus(int $id, string $status): void
    {
        $stmt = Database::get()->prepare('UPDATE orders SET payment_status = ? WHERE id = ?');
        $stmt->execute([$status, $id]);
    }

    public static function delete(int $id): void
    {
        $stmt = Database::get()->prepare('DELETE FROM orders WHERE id = ?');
        $stmt->execute([$id]);
    }

    public static function count(): int
    {
        return (int) Database::get()->query('SELECT COUNT(*) FROM orders')->fetchColumn();
    }

    public static function sumByStatus(string $status): int
    {
        $stmt = Database::get()->prepare('SELECT COALESCE(SUM(total_price), 0) FROM orders WHERE payment_status = ?');
        $stmt->execute([$status]);

        return (int) $stmt->fetchColumn();
    }
}
