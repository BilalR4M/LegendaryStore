<?php

require dirname(__DIR__) . '/app/bootstrap.php';

use App\Helpers\Auth;
use App\Helpers\Flash;
use App\Helpers\Validate;
use App\Models\Cart;
use App\Models\Order;

Auth::requireUser();
$userId = Auth::userId();

if (isset($_POST['order'])) {
    $name = Validate::text($_POST['name'] ?? '', 20);
    $number = Validate::phone($_POST['number'] ?? '', 10);
    $email = Validate::email($_POST['email'] ?? '');
    $method = Validate::text($_POST['method'] ?? '', 50);
    $address = Validate::text($_POST['address'] ?? '', 500);

    if ($name === '' || $number === null || $email === null || !in_array($method, Validate::PAYMENT_METHODS, true)) {
        Flash::add('check the order details');
    } elseif (!Order::place($userId, $name, $number, $email, $method, $address)) {
        Flash::add('your cart is empty');
    } else {
        Flash::add('order placed successfully');
        header('Location: orders.php');
        exit;
    }
}

$items = Cart::forUser($userId);
$grandTotal = 0;
foreach ($items as $item) {
    $grandTotal += (int) $item['price'] * (int) $item['quantity'];
}

$pageTitle = 'checkout';
require dirname(__DIR__) . '/app/views/partials/header.php';
?>

<section class="checkout-orders">
   <form action="" method="post">
      <?= csrf_field() ?>
      <h3>your orders</h3>
      <div class="display-orders">
      <?php if ($items === []): ?>
         <p class="empty">your cart is empty!</p>
      <?php else: ?>
         <?php foreach ($items as $item): ?>
            <p><?= e((string) $item['name']) ?> <span>(<?= '$' . e((string) $item['price']) . '/- x ' . e((string) $item['quantity']) ?>)</span></p>
         <?php endforeach; ?>
      <?php endif; ?>
         <div class="grand-total">grand total : <span>$<?= e((string) $grandTotal) ?>/-</span></div>
      </div>

      <h3>place your orders</h3>
      <div class="flex">
         <div class="inputBox">
            <span>your name :</span>
            <input type="text" name="name" placeholder="enter your name" class="box" maxlength="20" required>
         </div>
         <div class="inputBox">
            <span>your number :</span>
            <input type="text" name="number" placeholder="enter your number" class="box" maxlength="10" required>
         </div>
         <div class="inputBox">
            <span>your email :</span>
            <input type="email" name="email" placeholder="enter your email" class="box" maxlength="50" required>
         </div>
         <div class="inputBox">
            <span>your address :</span>
            <input type="text" name="address" placeholder="enter your address" class="box" maxlength="500" required>
         </div>
         <div class="inputBox">
            <span>payment method :</span>
            <select name="method" class="box" required>
               <option value="credit card">credit card</option>
               <option value="paytm">paytm</option>
               <option value="paypal">paypal</option>
            </select>
         </div>
      </div>
      <input type="submit" name="order" class="btn <?= $grandTotal > 0 ? '' : 'disabled' ?>" value="place order" <?= $grandTotal > 0 ? '' : 'disabled' ?>>
   </form>
</section>

<?php require dirname(__DIR__) . '/app/views/partials/footer.php'; ?>
