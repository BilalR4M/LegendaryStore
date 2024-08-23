<?php

require dirname(__DIR__) . '/app/bootstrap.php';

use App\Helpers\Auth;
use App\Helpers\Catalog;
use App\Helpers\Validate;
use App\Models\Wishlist;

Auth::requireUser();
$userId = Auth::userId();

if (isset($_POST['delete'])) {
    $wishlistId = Validate::id($_POST['wishlist_id'] ?? null);
    if ($wishlistId !== null) {
        Wishlist::delete($wishlistId, $userId);
    }
}

if (isset($_POST['delete_all'])) {
    Wishlist::clear($userId);
    header('Location: wishlist.php');
    exit;
}

Catalog::handlePost($userId);

$items = Wishlist::forUser($userId);
$grandTotal = 0;
$pageTitle = 'wishlist';
require dirname(__DIR__) . '/app/views/partials/header.php';
?>

<section class="products">
   <h3 class="heading">your wishlist</h3>
   <div class="box-container">
   <?php if ($items === []): ?>
      <p class="empty">your wishlist is empty</p>
   <?php else: ?>
      <?php foreach ($items as $item): ?>
         <?php $grandTotal += (int) $item['price']; ?>
         <form action="" method="post" class="box">
            <?= csrf_field() ?>
            <input type="hidden" name="pid" value="<?= e((string) $item['pid']) ?>">
            <input type="hidden" name="wishlist_id" value="<?= e((string) $item['id']) ?>">
            <a href="product.php?pid=<?= e((string) $item['pid']) ?>" class="fas fa-eye"></a>
            <img src="uploads/<?= e((string) $item['image']) ?>" alt="">
            <div class="name"><?= e((string) $item['name']) ?></div>
            <div class="flex">
               <div class="price">$<?= e((string) $item['price']) ?>/-</div>
               <input type="number" name="qty" class="qty" min="1" max="99" value="1">
            </div>
            <input type="submit" value="add to cart" class="btn" name="add_to_cart">
            <input type="submit" value="delete item" onclick="return confirm('delete this from wishlist?');" class="delete-btn" name="delete">
         </form>
      <?php endforeach; ?>
   <?php endif; ?>
   </div>

   <div class="wishlist-total">
      <p>grand total : <span>$<?= e((string) $grandTotal) ?>/-</span></p>
      <a href="shop.php" class="option-btn">continue shopping</a>
      <form action="" method="post" onsubmit="return confirm('delete all from wishlist?');">
         <?= csrf_field() ?>
         <button type="submit" name="delete_all" value="1" class="delete-btn <?= $grandTotal > 0 ? '' : 'disabled' ?>" <?= $grandTotal > 0 ? '' : 'disabled' ?>>delete all item</button>
      </form>
   </div>
</section>

<?php require dirname(__DIR__) . '/app/views/partials/footer.php'; ?>
