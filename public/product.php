<?php

require dirname(__DIR__) . '/app/bootstrap.php';

use App\Helpers\Auth;
use App\Helpers\Catalog;
use App\Helpers\Validate;
use App\Models\Product;

Catalog::handlePost(Auth::userId());
$productId = Validate::id($_GET['pid'] ?? null);
$product = $productId === null ? null : Product::find($productId);

$pageTitle = 'quick view';
require dirname(__DIR__) . '/app/views/partials/header.php';
?>

<section class="quick-view">
   <h1 class="heading">quick view</h1>
   <?php if ($product === null): ?>
      <p class="empty">no products added yet!</p>
   <?php else: ?>
   <form action="" method="post" class="box">
      <?= csrf_field() ?>
      <input type="hidden" name="pid" value="<?= e((string) $product['id']) ?>">
      <div class="row">
         <div class="image-container">
            <div class="main-image">
               <img src="uploads/<?= e((string) $product['image_01']) ?>" alt="">
            </div>
            <div class="sub-image">
               <img src="uploads/<?= e((string) $product['image_01']) ?>" alt="">
               <img src="uploads/<?= e((string) $product['image_02']) ?>" alt="">
               <img src="uploads/<?= e((string) $product['image_03']) ?>" alt="">
            </div>
         </div>
         <div class="content">
            <div class="name"><?= e((string) $product['name']) ?></div>
            <div class="flex">
               <div class="price"><span>$</span><?= e((string) $product['price']) ?><span>/-</span></div>
               <input type="number" name="qty" class="qty" min="1" max="99" value="1">
            </div>
            <div class="details"><?= e((string) $product['details']) ?></div>
            <div class="flex-btn">
               <input type="submit" value="add to cart" class="btn" name="add_to_cart">
               <input class="option-btn" type="submit" name="add_to_wishlist" value="add to wishlist">
            </div>
         </div>
      </div>
   </form>
   <?php endif; ?>
</section>

<?php require dirname(__DIR__) . '/app/views/partials/footer.php'; ?>
