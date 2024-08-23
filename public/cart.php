<?php

require dirname(__DIR__) . '/app/bootstrap.php';

use App\Helpers\Auth;
use App\Helpers\Flash;
use App\Helpers\Validate;
use App\Models\Cart;

Auth::requireUser();
$userId = Auth::userId();

if (isset($_POST['delete'])) {
    $cartId = Validate::id($_POST['cart_id'] ?? null);
    if ($cartId !== null) {
        Cart::delete($cartId, $userId);
    }
}

if (isset($_POST['delete_all'])) {
    Cart::clear($userId);
    header('Location: cart.php');
    exit;
}

if (isset($_POST['update_qty'])) {
    $cartId = Validate::id($_POST['cart_id'] ?? null);
    $qty = Validate::qty($_POST['qty'] ?? null);
    if ($cartId === null || $qty === null) {
        Flash::add('quantity must be between 1 and 99');
    } else {
        Cart::updateQty($cartId, $userId, $qty);
        Flash::add('cart quantity updated');
    }
}

$items = Cart::forUser($userId);
$grandTotal = 0;
$pageTitle = 'shopping cart';
require dirname(__DIR__) . '/app/views/partials/header.php';
?>

<section class="products shopping-cart">
   <h3 class="heading">shopping cart</h3>
   <div class="box-container">
   <?php if ($items === []): ?>
      <p class="empty">your cart is empty</p>
   <?php else: ?>
      <?php foreach ($items as $item): ?>
         <?php $subTotal = (int) $item['price'] * (int) $item['quantity']; $grandTotal += $subTotal; ?>
         <form action="" method="post" class="box">
            <?= csrf_field() ?>
            <input type="hidden" name="cart_id" value="<?= e((string) $item['id']) ?>">
            <a href="product.php?pid=<?= e((string) $item['pid']) ?>" class="fas fa-eye"></a>
            <img src="uploads/<?= e((string) $item['image']) ?>" alt="">
            <div class="name"><?= e((string) $item['name']) ?></div>
            <div class="flex">
               <div class="price">$<?= e((string) $item['price']) ?>/-</div>
               <input type="number" name="qty" class="qty" min="1" max="99" value="<?= e((string) $item['quantity']) ?>">
               <button type="submit" class="fas fa-edit" name="update_qty" value="1"></button>
            </div>
            <div class="sub-total"> sub total : <span>$<?= e((string) $subTotal) ?>/-</span> </div>
            <input type="submit" value="delete item" onclick="return confirm('delete this from cart?');" class="delete-btn" name="delete">
         </form>
      <?php endforeach; ?>
   <?php endif; ?>
   </div>

   <div class="cart-total">
      <p>grand total : <span>$<?= e((string) $grandTotal) ?>/-</span></p>
      <a href="shop.php" class="option-btn">continue shopping</a>
      <form action="" method="post" onsubmit="return confirm('delete all from cart?');">
         <?= csrf_field() ?>
         <button type="submit" name="delete_all" value="1" class="delete-btn <?= $grandTotal > 0 ? '' : 'disabled' ?>" <?= $grandTotal > 0 ? '' : 'disabled' ?>>delete all item</button>
      </form>
      <a href="checkout.php" class="btn <?= $grandTotal > 0 ? '' : 'disabled' ?>">proceed to checkout</a>
   </div>
</section>

<?php require dirname(__DIR__) . '/app/views/partials/footer.php'; ?>
