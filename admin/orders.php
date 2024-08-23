<?php

require dirname(__DIR__) . '/app/bootstrap.php';

use App\Helpers\Auth;
use App\Helpers\Flash;
use App\Helpers\Validate;
use App\Models\Order;

Auth::requireAdmin();

if (isset($_POST['update_payment'])) {
    $orderId = Validate::id($_POST['order_id'] ?? null);
    $status = Validate::text($_POST['payment_status'] ?? '', 20);
    if ($orderId === null || !in_array($status, Validate::PAYMENT_STATUSES, true)) {
        Flash::add('payment status was not updated');
    } else {
        Order::updateStatus($orderId, $status);
        Flash::add('payment status updated');
    }
    header('Location: orders.php');
    exit;
}

if (isset($_POST['delete_order'])) {
    $orderId = Validate::id($_POST['order_id'] ?? null);
    if ($orderId !== null) {
        Order::delete($orderId);
        Flash::add('order deleted');
    }
    header('Location: orders.php');
    exit;
}

$orders = Order::all();
$pageTitle = 'placed orders';
require dirname(__DIR__) . '/app/views/partials/admin_header.php';
?>

<section class="orders">
   <h1 class="heading">placed orders</h1>
   <div class="box-container">
   <?php if ($orders === []): ?>
      <p class="empty">no orders placed yet!</p>
   <?php else: ?>
      <?php foreach ($orders as $order): ?>
         <div class="box">
            <p> placed on : <span><?= e((string) $order['placed_on']) ?></span> </p>
            <p> name : <span><?= e((string) $order['name']) ?></span> </p>
            <p> email : <span><?= e((string) $order['email']) ?></span> </p>
            <p> number : <span><?= e((string) $order['number']) ?></span> </p>
            <p> address : <span><?= e((string) $order['address']) ?></span> </p>
            <p> total products : <span><?= e(Order::itemsLabel((int) $order['id'])) ?></span> </p>
            <p> total price : <span>$<?= e((string) $order['total_price']) ?>/-</span> </p>
            <p> payment method : <span><?= e((string) $order['method']) ?></span> </p>
            <form action="" method="post">
               <?= csrf_field() ?>
               <input type="hidden" name="order_id" value="<?= e((string) $order['id']) ?>">
               <select name="payment_status" class="select">
                  <option value="<?= e((string) $order['payment_status']) ?>" selected><?= e((string) $order['payment_status']) ?></option>
                  <option value="pending">pending</option>
                  <option value="completed">completed</option>
               </select>
               <div class="flex-btn">
                  <input type="submit" value="update" class="option-btn" name="update_payment">
                  <button type="submit" name="delete_order" value="1" class="delete-btn" onclick="return confirm('delete this order?');">delete</button>
               </div>
            </form>
         </div>
      <?php endforeach; ?>
   <?php endif; ?>
   </div>
</section>

<?php require dirname(__DIR__) . '/app/views/partials/admin_footer.php'; ?>
