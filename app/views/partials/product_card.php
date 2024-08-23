<?php
/** @var array<string, mixed> $product */
$cardClass = $cardClass ?? 'box';
?>
<form action="" method="post" class="<?= e($cardClass) ?>">
   <?= csrf_field() ?>
   <input type="hidden" name="pid" value="<?= e((string) $product['id']) ?>">
   <button class="fas fa-heart" type="submit" name="add_to_wishlist" value="1"></button>
   <a href="product.php?pid=<?= e((string) $product['id']) ?>" class="fas fa-eye"></a>
   <img src="uploads/<?= e((string) $product['image_01']) ?>" alt="">
   <div class="name"><?= e((string) $product['name']) ?></div>
   <div class="flex">
      <div class="price"><span>$</span><?= e((string) $product['price']) ?><span>/-</span></div>
      <input type="number" name="qty" class="qty" min="1" max="99" value="1">
   </div>
   <input type="submit" value="add to cart" class="btn" name="add_to_cart">
</form>
