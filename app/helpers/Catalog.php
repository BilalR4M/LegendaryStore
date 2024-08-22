<?php

declare(strict_types=1);

namespace App\Helpers;

use App\Models\Cart;
use App\Models\Wishlist;

final class Catalog
{
    public static function handlePost(int $userId): void
    {
        if (($_SERVER['REQUEST_METHOD'] ?? 'GET') !== 'POST') {
            return;
        }

        $wantsWishlist = isset($_POST['add_to_wishlist']);
        $wantsCart = isset($_POST['add_to_cart']);
        if (!$wantsWishlist && !$wantsCart) {
            return;
        }

        if ($userId < 1) {
            header('Location: login.php');
            exit;
        }

        $productId = Validate::id($_POST['pid'] ?? null);
        if ($productId === null) {
            Flash::add('product not found');
            return;
        }

        if ($wantsWishlist) {
            Flash::add(Wishlist::add($userId, $productId));
            return;
        }

        $qty = Validate::qty($_POST['qty'] ?? 1);
        if ($qty === null) {
            Flash::add('quantity must be between 1 and 99');
            return;
        }

        Flash::add(Cart::add($userId, $productId, $qty));
    }
}
